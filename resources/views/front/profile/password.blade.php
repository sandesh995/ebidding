@extends('front.layouts.app')

@section('title', 'Update Password')

@section('content')
    <div class="container py-4">
        <x-alert-new />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="bold">Update Password</span>
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">Back to Profile</a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('profile.password.update') }}" method="post">
                    @method("PUT")
                    @csrf

                    <x-input
                        text="Current Password"
                        field="current_password"
                        type="password"
                        :old="false"
                    />

                    <x-input
                        text="New Password"
                        field="password"
                        type="password"
                        :old="false"
                    />

                    <x-input
                        text="Confirm New Password"
                        field="password_confirmation"
                        type="password"
                        :old="false"
                    />

                    <button type="submit" class="btn btn-primary mt-3">
                        Change Password
                    </button>
                </form>

            </div>
    </div>
</div>
@endsection
