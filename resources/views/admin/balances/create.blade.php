@extends('adminlte::page')

@section('title', 'Add Balance')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
            Add Balance
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.balances.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.balances.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @endif">
                    <option value="">Choose a user...</option>

                    @foreach($users as $user)
                        <option
                            value="{{ $user->id }}"
                            @if(old('user_id') == $user->id) selected @endif
                        >{{ $user->name }}</option>
                    @endforeach
                </select>

                @error('user_id')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>


            <x-input
                field="amount"
                text="Amount"
                type="number"
                :required="true"
            />

            <x-input
                field="title"
                text="Title (Optional)"
            />

            <x-input
                field="description"
                text="Description (Optional)"
                type="textarea"
            />


            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection