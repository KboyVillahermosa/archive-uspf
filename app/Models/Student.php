<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'course_and_year',
        'user_id',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }
}
