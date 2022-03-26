@extends('front.layouts.app')

@section('title', 'Update Profile')

@section('content')
    <div class="container py-4">
        <x-alert-new />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="bold">Update Profile</span>
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">Back to Profile</a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf

                    <x-input
                        text="Full Name"
                        field="name"
                        :current="$user->name"
                    />

                    <x-input
                        text="Email Address"
                        field="email"
                        type="email"
                        :current="$user->email"
                    />

                    <x-input
                        text="Profile Picture"
                        field="image"
                        type="file"
                    />

                    @if($user->media_id && $user->media)
                    <div style="display:inline-block" class="bg-light p-4">
                        Current: <br><br> <img src="{{ $user->photo }}" height="50px" />
                    </div>
                    @endif

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update Profile
                        </button>
                    </div>
                </form>


            </div>
    </div>
</div>
@endsection
