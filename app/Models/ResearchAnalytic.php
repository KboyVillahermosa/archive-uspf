<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'download_notes'
    ];

    public static function trackView($researchType, $researchId, $request)
    {
        // Only track one view per IP per research item per day
        $today = now()->format('Y-m-d');
        $existing = self::where('research_type', $researchType)
            ->where('research_id', $researchId)
            ->where('action', 'view')
            ->where('ip_address', $request->ip())
            ->whereDate('created_at', $today)
            ->first();

        if (!$existing) {
            self::create([
                'research_type' => $researchType,
                'research_id' => $researchId,
                'action' => 'view',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }
    }

    public static function trackDownload($researchType, $researchId, $request, $purpose = null, $notes = null)
    {
        self::create([
            'research_type' => $researchType,
            'research_id' => $researchId,
            'action' => 'download',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'download_purpose' => $purpose,
            'download_notes' => $notes
        ]);
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
}
