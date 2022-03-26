<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Listing;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('front.profile.index', compact('user'));
    }

    public function editProfile(): View
    {
        $user = auth()->user();

        return view('front.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'image' => ['nullable', 'image', 'mimes:png,jpeg,gif'],
        ]);

        unset($data['image']);
        if ($request->hasFile('image')) {
            $data['media_id'] = MediaService::upload($request->file('image'));
            if ($user->media_id && $user->media) {
                Storage::delete($user->media->path);
            }
        }

        auth()->user()->update($data);

        return redirect()->route('profile.index')
            ->with('success', 'Profile Updated Successfully!');
    }

    public function password(): View
    {
        return view('front.profile.password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'  => ['required', 'current_password'],
            'password'          => ['required', 'confirmed', 'min:6'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully!');
    }

    public function bids()
    {
        $user = auth()->user();

        $bids = Bid::query()
            ->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->with('listing')
            ->get();

        return view('front.profile.bids', compact('user', 'bids'));
    }

    public function listings()
    {
        $user = auth()->user();

        $listings = Listing::query()
            ->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->with('bids')
            ->get();

        return view('front.profile.listings', compact('user', 'listings'));
    }
}
