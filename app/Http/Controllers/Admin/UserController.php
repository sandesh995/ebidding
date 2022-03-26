<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public $roles = [
        'User', 'Admin',
    ];

    public function index(): View
    {
        $users = User::with('media')->paginate(30);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = $this->roles;

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => ['required', 'max:190'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', new Password(8)],
            'role'      => ['required', Rule::in($this->roles)],
            'image'     => ['nullable', 'image', 'mimes:jpeg,png,gif'],
        ]);

        if ($request->hasFile('image') && !empty($request->file('image'))) {
            $data['media_id'] = MediaService::upload($request->file('image'));
        }

        unset($data['image']);

        $data['password'] = bcrypt($request->input('password'));

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'New User Created!');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = $this->roles;

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'      => ['required', 'max:190'],
            'email'     => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'  => ['nullable', new Password(8)],
            'role'      => ['required', Rule::in($this->roles)],
            'image'     => ['nullable', 'image', 'mimes:jpeg,png,gif'],
        ]);

        if ($request->hasFile('image') && !empty($request->file('image'))) {
            // If Existing Picture, Delete It before Uploading New One
            if ($user->media_id && $user->media) {
                Storage::delete("public/" . $user->media->path);
            }
            $data['media_id'] = MediaService::upload($request->file('image'));
        }

        unset($data['image']);

        if (!empty($request->input('password'))) {
            $data['password'] = bcrypt($request->input('password'));
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User Updated!');
    }

    public function destroy(User $user): RedirectResponse
    {

        if ($user->id == auth()->id())
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete yourself!');

        if ($user->role == "Admin")
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete another admin!');

        // If All Check Pass, Delete User
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User Deleted!');
    }
}
