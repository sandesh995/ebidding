@extends('adminlte::page')

@section('title', 'User Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                User Details
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 15%">ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($user->media_id && $user->media)
                            <img src="/storage/{{ $user->media->path }}" style="height: 150px" />
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td class="p-0">
                        <table class="m-0 table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->balances as $balance)
                                <tr>
                                    <td>{{ $balance->created_at }}</td>
                                    <td>{{ $balance->title }}</td>
                                    <td style="background: {{ $balance->amount < 0 ? '#FECACA' : '#A7F3D0' }}">
                                        {{ $balance->type }}
                                    </td>
                                    <td>Rs. {{ abs($balance->amount) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" style="background: #FEE2E2" colspan="4">No Balance Record Found!</td>
                                </tr>
                                @endforelse
                                <tr>
                                    <th style="text-align: right" colspan="3">Current Balance</th>
                                    <th>Rs. {{ $user->balances()->sum('amount') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Listings</th>
                    <td>
                        <ul class="mb-0">
                            @foreach($user->listings as $listing)
                            <li>
                                <a href="{{ route('admin.listings.show', $listing) }}">
                                    {{ $listing->name }} [Price: Rs. {{ $listing->base_price }}]
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Registered At</th>
                    <td>{{ $user->created_at }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $user->updated_at }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
