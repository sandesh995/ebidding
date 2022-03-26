@extends('front.layouts.app')

@section('title', 'My Listings')

@section('content')
<div class="container py-4">
    <x-alert-new />

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <span class="bold">My Listings</span>
                <a href="{{ route('profile.index') }}" class="btn btn-primary">Back to Profile</a>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($listings) == 0)
            <div class="my-4 d-flex justify-content-center">
                <p class="text-center my-3">You do not have any listings!</p>
            </div>
            @else
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Listing</th>
                        <th>Base Amount</th>
                        <th>Max Bid</th>
                        <th>Created</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>Rs. {{ $item->base_price }}</td>
                        <td>
                            @if($item->largest_bid)
                                Rs. {{ $item->largest_bid }}
                            @else
                                No Bids Yet!
                            @endif
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->expiry_date }}</td>
                        <td>
                            @if($item->expiry_date <= now())
                                Expired
                                @if($item->all_complete) [Complete] @endif
                            @else
                                Active
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('front.listing', $item) }}" class="btn btn-info btn-sm">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
    </div>
</div>
@endsection
