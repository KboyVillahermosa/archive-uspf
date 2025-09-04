<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'title', 'author', 'department', 'year_completed', 'keywords',
        'document_file', 'abstract', 'status', 'admin_notes',
        'user_id', 'approved_by', 'approved_at', 'views_count', 'downloads_count'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'year_completed' => 'integer',
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
