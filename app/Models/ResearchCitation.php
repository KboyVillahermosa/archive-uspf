<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchCitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'citing_user_id',
        'citing_research_title', 
        'citing_research_type',
        'cited_research_id',
        'cited_research_type',
        'citation_context'
    ];

    public function citingUser()
    {
        return $this->belongsTo(User::class, 'citing_user_id');
    }

    public function getCitedResearch()
    {
        switch ($this->cited_research_type) {
            case 'student':
                return StudentResearch::find($this->cited_research_id);
            case 'faculty': 
                return FacultyResearch::find($this->cited_research_id);
            case 'thesis':
                return Thesis::find($this->cited_research_id);
            case 'dissertation':
                return Dissertation::find($this->cited_research_id);
            default:
                return null;
        }
    }
}
