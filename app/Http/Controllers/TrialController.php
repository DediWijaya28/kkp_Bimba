<?php

namespace App\Http\Controllers;

use App\Models\Trial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TrialController extends Controller
{
    public function create()
    {
        return view('trial.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'child_age' => 'required|integer|min:2|max:12',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create User
        $user = User::create([
            'name' => ucwords(strtolower($validated['parent_name'])),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'parent',
        ]);

        // Create Trial linked to User
        Trial::create([
            'user_id' => $user->id,
            'child_name' => ucwords(strtolower($validated['child_name'])),
            'parent_name' => ucwords(strtolower($validated['parent_name'])),
            'phone' => $validated['phone'],
            'child_age' => $validated['child_age'],
            'status' => 'pending',
        ]);

        // Login User
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran trial berhasil! Akun Anda telah dibuat.');
    }

    public function success()
    {
        return view('trial.success');
    }

    // Admin Methods
    public function index()
    {
        $trials = Trial::latest()->get();
        return view('admin.trials.index', compact('trials'));
    }

    public function update(Request $request, Trial $trial)
    {
        $request->validate([
            'status' => 'required|in:pending,scheduled,completed,registered',
            'scheduled_at' => 'nullable|date',
        ]);
        
        $data = ['status' => $request->status];
        if ($request->has('scheduled_at')) {
            $data['scheduled_at'] = $request->scheduled_at;
        }

        $trial->update($data);
        return back()->with('success', 'Status trial berhasil diperbarui.');
    }
    public function destroy(Trial $trial)
    {
        $trial->delete();
        return back()->with('success', 'Data trial berhasil dihapus.');
    }
}
