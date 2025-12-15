<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ResearchAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_type',
        'research_id',
        'action',
        'ip_address',
        'user_agent',
        'download_purpose',
        'download_notes',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function trackView($researchType, $researchId, $request)
    {
        // Get client IP (handles proxies/load balancers)
        $ipAddress = $request->ip() ?? '0.0.0.0';
        $userAgent = $request->userAgent() ?? '';
        $userId = auth()->check() ? auth()->id() : null;
        
        // Light deduplication: only prevent rapid refreshes (30 seconds)
        // This allows legitimate views while preventing refresh spam
        // If user is authenticated, use user_id for better deduplication
        // Otherwise, use IP + User-Agent combination for better accuracy behind proxies
        $thirtySecondsAgo = now()->subSeconds(30);
        $query = self::where('research_type', $researchType)
            ->where('research_id', $researchId)
            ->where('action', 'view')
            ->where('created_at', '>=', $thirtySecondsAgo);
        
        if ($userId) {
            // For authenticated users, check by user_id
            $query->where('user_id', $userId);
        } else {
            // For anonymous users, check by IP + User-Agent
            $query->where('ip_address', $ipAddress)
                  ->where('user_agent', $userAgent);
        }
        
        $existing = $query->first();

        if (!$existing) {
            try {
                $created = self::create([
                'research_type' => $researchType,
                'research_id' => $researchId,
                'action' => 'view',
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'user_id' => $userId
                ]);
                
                // Log for debugging (can be removed later)
                if ($userId) {
                    \Log::info('View tracked with user_id', [
                        'user_id' => $userId,
                        'research_type' => $researchType,
                        'research_id' => $researchId,
                        'analytic_id' => $created->id
                    ]);
                }
            } catch (\Exception $e) {
                // Log error but don't break the page
                \Log::error('Failed to track view: ' . $e->getMessage(), [
                    'research_type' => $researchType,
                    'research_id' => $researchId,
                    'ip' => $ipAddress,
                    'user_id' => $userId
                ]);
            }
        }
    }

    public static function trackDownload($researchType, $researchId, $request, $purpose = null, $notes = null)
    {
        $userId = auth()->check() ? auth()->id() : null;
        
        try {
            $created = self::create([
            'research_type' => $researchType,
            'research_id' => $researchId,
            'action' => 'download',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'download_purpose' => $purpose,
                'download_notes' => $notes,
                'user_id' => $userId
            ]);
            
            // Log for debugging (can be removed later)
            if ($userId) {
                \Log::info('Download tracked with user_id', [
                    'user_id' => $userId,
                    'research_type' => $researchType,
                    'research_id' => $researchId,
                    'analytic_id' => $created->id
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to track download: ' . $e->getMessage(), [
                'research_type' => $researchType,
                'research_id' => $researchId,
                'user_id' => $userId
        ]);
        }
    }

    public static function getViewCount($researchType, $researchId)
    {
        return self::where('research_type', $researchType)
            ->where('research_id', $researchId)
            ->where('action', 'view')
            ->count();
    }

    public static function getDownloadCount($researchType, $researchId)
    {
        return self::where('research_type', $researchType)
            ->where('research_id', $researchId)
            ->where('action', 'download')
            ->count();
    }

    /**
     * Get both view and download counts for a research item
     * Following MVC best practices - centralized data retrieval
     *
     * @param string $researchType
     * @param int $researchId
     * @return array ['views' => int, 'downloads' => int]
     */
    public static function getAnalytics($researchType, $researchId)
    {
        return [
            'views' => self::getViewCount($researchType, $researchId),
            'downloads' => self::getDownloadCount($researchType, $researchId),
        ];
    }
}
