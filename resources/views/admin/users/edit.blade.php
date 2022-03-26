@extends('adminlte::page')

@section('title', 'Update User Info')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Update User Info
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-input
                    field="name"
                    text="Full Name"
                    :current="$user->name"
                    :required="true"
                />

                <x-input
                    field="email"
                    text="Email Address"
                    type="email"
                    :current="$user->email"
                    :required="true"
                />

                <x-input
                    field="password"
                    text="Password (Change to Override, Leave Empty Otherwise)"
                    type="password"
                />

                <div class="form-group">
                    <label for="role">Role <x-required /></label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @endif">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @if ($user->role == $role) selected @endif>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <x-input
                    field="image"
                    type="file"
                    text="Profile Picture (Upload to Override Existing)"
                />

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-fw fa-save mr-2"></i>
                    <span>Save</span>
                </button>

            </form>
        </div>
    </div>
@endsection
