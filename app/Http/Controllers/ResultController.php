<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $candidates = Candidate::withCount(['votes as vote_count'])->orderByDesc('vote_count')->orderBy('name')->get();
        $totalVotes = Vote::count();
        $election = Election::first();

        return view('results', [
            'candidates' => $candidates,
            'totalVotes' => $totalVotes,
            'election' => $election,
        ]);
    }
}
