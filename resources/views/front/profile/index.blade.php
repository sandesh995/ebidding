@extends('front.layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 align-items-center justify-content-center">
                    <img src="{{ $user->photo }}" style="border-radius: 50%;height: 100px;width: 100px;object-fit:cover" alt="">
                </div>

                <div class="text-center mb-2">
                    <h3>{{ $user->name }}</h3>
                    <p class="text-muted">Registered Since {{ $user->created_at->format('j F, Y') }}</p>
                    <p class="text-muted">Balance: Rs. {{ $user->current_balance }}</p>
                </div>

                <x-alert-new />

                <div class="my-2 d-flex align-items-center justify-content-center">
                    <a href="{{ route('front.balance') }}" class="btn btn-secondary me-2 d-flex align-items-center">
                       Balance History
                    </a>

                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary me-2 d-flex align-items-center">
                        Edit Profile
                    </a>
                    <a href="{{ route('profile.password') }}" class="btn btn-secondary d-flex align-items-center">
                        Change Password
                    </a>
                </div>

                <div class="my-2 d-flex align-items-center justify-content-center">
                    <a href="{{ route('profile.bids') }}" class="btn btn-secondary me-2 d-flex align-items-center">
                       Bid History
                    </a>
                    <a href="{{ route('profile.listings') }}" class="btn btn-secondary me-2 d-flex align-items-center">
                        My Listings
                     </a>
                </div>
            </div>
        </div>
    </div>
@endsection