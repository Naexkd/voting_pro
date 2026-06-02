<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidate;

class Election extends Model
{
    use HasFactory;

    protected $primaryKey = 'election_id';

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'started_at',
        'ended_at',
        'winner_candidate_id',
        'winner_notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'winner_candidate_id' => 'integer',
        'winner_notes' => 'string',
    ];

    public function winnerCandidate()
    {
        return $this->belongsTo(Candidate::class, 'winner_candidate_id', 'candidate_id');
    }
}
