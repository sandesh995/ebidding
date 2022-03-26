@extends('adminlte::page')

@section('title', 'Balance History')

@section('content')

    <x-alert />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Balance History
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.balances.create') }}" class="btn btn-primary btn-sm">
                    Add New
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if (count($balances) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balances as $balance)
                            <tr>
                                <td>{{ $balance->id }}</td>
                                <td>
                                    @if($balance->user_id)
                                    <a href="{{ route('admin.users.show', $balance->user_id) }}">
                                        {{ $balance->user->name }}
                                    </a>
                                    @endif
                                </td>
                                <td style="background: {{ $balance->amount < 0 ? '#FECACA' : '#A7F3D0' }}">{{ $balance->type }}</td>
                                <td>Rs. {{ $balance->amount }}</td>
                                <td>{{ $balance->title }}</td>
                                <td>
                                    <a href="{{ route('admin.balances.show', $balance) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-fw fa-eye"></i>
                                        <span>Show</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning mb-0 text-center">
                    There are no items in the table.
                </div>
            @endif
        </div>

        @if ($balances->perPage() < $balances->total())
            <div class="card-footer">
                {{ $balances->links() }}
            </div>
        @endif
    </div>
@endsection
