<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $primaryKey = 'voter_id';

    protected $fillable = [
        'user_id',
        'name',
        'national_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'voter_id', 'voter_id');
    }
}
