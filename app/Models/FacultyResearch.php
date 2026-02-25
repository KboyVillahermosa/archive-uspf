<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacultyResearch extends Model
{
    use HasFactory;

    protected $table = 'faculty_research';

    protected $fillable = [
        'title', 'co_researchers', 'department', 'banner_image',
        'research_file', 'abstract_file', 'abstract', 'tags', 'status', 'admin_notes',
        'user_id', 'approved_by', 'approved_at', 'views_count', 'downloads_count',
        'adviser_id', 'adviser_approved_at', 'adviser_approved_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'adviser_approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function adviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    public function adviserApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_approved_by');
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }
}
