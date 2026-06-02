<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $voter = $user->voter;
        $election = Election::first();

        if (! $voter) {
            return redirect()->route('dashboard')->with('error', 'Please complete your voter registration before voting.');
        }

        if (! $election || ! $election->is_active) {
            return redirect()->route('dashboard')->with('error', 'The election is not currently active. Please check back later.');
        }

        $hasVoted = Vote::where('voter_id', $voter->voter_id)->exists();
        $candidates = Candidate::orderBy('position')->orderBy('name')->get();
        $selectedCandidate = session('vote.selected_candidate_id');

        return view('vote', [
            'candidates' => $candidates,
            'hasVoted' => $hasVoted,
            'selectedCandidate' => $selectedCandidate,
        ]);
    }

    public function rememberSelection(Request $request)
    {
        $request->validate([
            'candidate_id' => ['required', 'integer', 'exists:candidates,candidate_id'],
        ]);

        session(['vote.selected_candidate_id' => $request->candidate_id]);

        return response()->json(['status' => 'stored']);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'candidate_id' => ['required', 'integer', 'exists:candidates,candidate_id'],
        ]);

        $election = Election::first();
        if (! $election || ! $election->is_active) {
            return redirect()->route('vote.index')->with('error', 'The election is not currently active. You cannot vote right now.');
        }

        $user = Auth::user();
        $voter = $user->voter;

        if (! $voter) {
            return redirect()->route('vote.index')->with('error', 'Voter profile not found.');
        }

        if (Vote::where('voter_id', $voter->voter_id)->exists()) {
            return redirect()->route('vote.index')->with('error', 'You have already cast your vote. One voter, one vote.');
        }

        Vote::create([
            'voter_id' => $voter->voter_id,
            'candidate_id' => $request->candidate_id,
        ]);

        session()->forget('vote.selected_candidate_id');

        return redirect()->route('vote.index')->with('success', 'Your vote has been submitted successfully.');
    }
}
