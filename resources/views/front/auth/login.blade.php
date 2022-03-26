@extends('front.layouts.app')


@section('title', 'Log In | ' . config('app.name'))

@section('content')
<div class="container my-4 login">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card elevation-2">
                <div class="card-header text-center text-bold">Log In</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <x-input
                                type="email"
                                field="email"
                                text="Email Address"
                                :autofocus="true"
                            />
                        </div>

                        <div class="mb-3">
                            <x-input
                                type="password"
                                field="password"
                                text="Password"
                            />
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group pt-2">
                                <button type="submit" class="btn btn-primary" style="min-width: 150px">
                                    {{ __('Log In') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>
                        <hr>

                        <div class="mt-2 text-center text-muted">
                            Don't have an account yet? <a href="/register">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
