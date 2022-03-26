@extends('front.layouts.app')

@section('bodyClass', 'bg-light')

@section('content')
<div class="container my-4 login">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card elevation-2">
                <div class="card-header text-center text-bold">Create New Account</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <x-input
                                field="name"
                                text="Full Name"
                                :autofocus="true"
                            />
                        </div>

                        <div class="mb-3">
                            <x-input
                                type="email"
                                field="email"
                                text="Email Address"
                            />
                        </div>

                        <div class="mb-3">
                            <x-input
                                type="password"
                                field="password"
                                text="Password"
                            />
                        </div>

                        <div class="mb-3">
                            <x-input
                                type="password"
                                field="password_confirmation"
                                text="Confirm Password"
                            />
                        </div>

                        <div class="form-group pt-2">
                                <button type="submit" class="btn btn-primary" style="min-width: 150px">
                                    {{ __('Create New Account') }}
                                </button>
                        </div>
                        <hr>

                        <div class="mt-2 text-center text-muted">
                            Already have an account? <a href="/login">Log In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
