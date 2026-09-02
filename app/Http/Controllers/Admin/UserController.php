<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $users = User::query()
            ->with('organizations')
            ->paginate(15);

        return view('admin.users.index', compact('users', 'currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:owner,admin,editor,viewer'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Attach to current org with role
        $user->organizations()->syncWithoutDetaching([
            $currentOrg->id => ['role' => $validated['role']],
        ]);

        return back()->with('success', "User '{$user->name}' created and assigned to {$currentOrg->title}.");
    }

    public function update(Request $request, User $user)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:owner,admin,editor,viewer'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // Update role on current org
        $user->organizations()->syncWithoutDetaching([
            $currentOrg->id => ['role' => $validated['role']],
        ]);

        return back()->with('success', "User '{$user->name}' updated.");
    }

    public function destroy(User $user)
    {
        if (User::count() <= 1) {
            return back()->with('error', 'Cannot delete the only user.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User '{$name}' deleted.");
    }
}
