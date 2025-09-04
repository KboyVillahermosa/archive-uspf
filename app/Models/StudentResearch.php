<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentResearch extends Model
{
    use HasFactory;

    protected $table = 'student_research';

    protected $fillable = [
        'title', 'authors', 'department', 'program', 'banner_image',
        'research_file', 'abstract', 'tags', 'status', 'admin_notes',
        'user_id', 'approved_by', 'approved_at', 'views_count', 'downloads_count'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
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
