@extends('adminlte::page')

@section('title', 'Balance Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Balance Details
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.balances.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table">
                <tr>
                    <th>User</th>
                    <td>
                        @if($balance->user_id)
                        <a href="{{ route('admin.users.show', $balance->user_id) }}">
                            {{ $balance->user->name }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>Rs. {{ $balance->amount }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $balance->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $balance->description }}</td>
                </tr>
                <tr>
                    <th>Added At</th>
                    <td>{{ $balance->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
