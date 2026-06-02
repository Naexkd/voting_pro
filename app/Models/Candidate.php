<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $primaryKey = 'candidate_id';

    protected $fillable = [
        'name',
        'position',
        'details',
        'photo_url',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class, 'candidate_id', 'candidate_id');
    }

    public function getPhotoUrlAttribute($value)
    {
        return $value ?: 'images/candidates/default.svg';
    }
}
