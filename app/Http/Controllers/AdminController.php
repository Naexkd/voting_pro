<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\UploadedFile;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->is_admin, 403);
    }

    public function index(): View
    {
        $this->authorizeAdmin();

        $election = Election::firstOrCreate([
            'title' => 'Gasabo District Election',
        ], [
            'description' => 'Manage the main voting period for district offices.',
            'is_active' => false,
        ])->load('winnerCandidate');

        $candidates = Candidate::withCount('votes')->orderByDesc('votes_count')->get();
        $admins = User::where('is_admin', true)->get();
        $recentVotes = Vote::with(['candidate', 'voter'])->latest('created_at')->limit(8)->get();

        return view('admin.dashboard', [
            'candidates' => $candidates,
            'totalVotes' => Vote::count(),
            'totalVoters' => Voter::count(),
            'totalCandidates' => Candidate::count(),
            'election' => $election,
            'admins' => $admins,
            'recentVotes' => $recentVotes,
        ]);
    }

    public function createCandidate(): View
    {
        $this->authorizeAdmin();

        return view('admin.candidates.create');
    }

    public function storeCandidate(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['name', 'position', 'details']);
        if ($request->hasFile('photo')) {
            $data['photo_url'] = $this->storeImage($request->file('photo'), 'candidates');
        }

        Candidate::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Candidate added successfully.');
    }

    public function editCandidate(Candidate $candidate): View
    {
        $this->authorizeAdmin();

        return view('admin.candidates.edit', [
            'candidate' => $candidate,
        ]);
    }

    public function updateCandidate(Request $request, Candidate $candidate): RedirectResponse
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['name', 'position', 'details']);
        if ($request->hasFile('photo')) {
            $data['photo_url'] = $this->storeImage($request->file('photo'), 'candidates');
        }

        $candidate->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Candidate updated successfully.');
    }

    public function destroyCandidate(Candidate $candidate): RedirectResponse
    {
        $this->authorizeAdmin();

        $candidate->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Candidate removed successfully.');
    }

    public function voteReview(): View
    {
        $this->authorizeAdmin();

        $votes = Vote::with(['candidate', 'voter'])->orderByDesc('created_at')->paginate(20);

        return view('admin.votes', [
            'votes' => $votes,
        ]);
    }

    public function destroyVote(Vote $vote): RedirectResponse
    {
        $this->authorizeAdmin();

        $vote->delete();

        return redirect()->route('admin.votes.index')->with('success', 'Vote corrected and removed successfully.');
    }

    public function startElection(): RedirectResponse
    {
        $this->authorizeAdmin();

        $election = Election::first();
        if (! $election) {
            $election = Election::create([
                'title' => 'Gasabo District Election',
                'description' => 'Manage the main voting period for district offices.',
            ]);
        }

        $election->update([
            'is_active' => true,
            'started_at' => now(),
            'ended_at' => null,
            'winner_candidate_id' => null,
            'winner_notes' => null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Election has been started.');
    }

    public function stopElection(): RedirectResponse
    {
        $this->authorizeAdmin();

        $election = Election::first();
        if ($election) {
            $election->update([
                'is_active' => false,
                'ended_at' => now(),
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Election has been stopped.');
    }

    public function resetElection(): RedirectResponse
    {
        $this->authorizeAdmin();

        $election = Election::first();
        if (! $election) {
            return redirect()->route('admin.dashboard')->with('error', 'Election record not found.');
        }

        Vote::query()->delete();

        $election->update([
            'is_active' => false,
            'started_at' => null,
            'ended_at' => null,
            'winner_candidate_id' => null,
            'winner_notes' => null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Election has been reset. Votes cleared and winner removed.');
    }

    public function selectWinner(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $request->validate([
            'winner_candidate_id' => ['required', 'integer', 'exists:candidates,candidate_id'],
            'winner_notes' => ['nullable', 'string'],
        ]);

        $election = Election::first();
        if (! $election) {
            return redirect()->route('admin.dashboard')->with('error', 'Election record not found.');
        }

        if ($election->is_active) {
            return redirect()->route('admin.dashboard')->with('error', 'Stop the election before declaring a winner.');
        }

        $election->update([
            'winner_candidate_id' => $request->winner_candidate_id,
            'winner_notes' => $request->winner_notes,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Winner has been recorded successfully.');
    }

    public function manageAdmins(): View
    {
        $this->authorizeAdmin();

        $admins = User::where('is_admin', true)->get();
        $users = User::where('is_admin', false)->orderBy('name')->get();

        return view('admin.manage-admins', [
            'admins' => $admins,
            'users' => $users,
        ]);
    }

    public function promoteToAdmin(User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        $user->update(['is_admin' => true]);

        return redirect()->route('admin.admins.index')->with('success', "{$user->name} is now an admin.");
    }

    public function demoteFromAdmin(User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        // Don't allow removing yourself as admin
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.admins.index')->with('error', 'You cannot remove yourself as admin.');
        }

        // Ensure at least one admin remains
        if (User::where('is_admin', true)->count() <= 1) {
            return redirect()->route('admin.admins.index')->with('error', 'At least one admin must remain.');
        }

        $user->update(['is_admin' => false]);

        return redirect()->route('admin.admins.index')->with('success', "{$user->name} is no longer an admin.");
    }

    protected function storeImage(UploadedFile $photo, string $folder): string
    {
        $destination = public_path("images/{$folder}");
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $filename = uniqid("{$folder}_") . '.' . $photo->extension();
        $photo->move($destination, $filename);

        return "images/{$folder}/{$filename}";
    }
}
