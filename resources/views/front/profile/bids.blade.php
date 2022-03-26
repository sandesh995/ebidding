@extends('front.layouts.app')

@section('title', 'My Bid History')

@section('content')
<div class="container py-4">
    <x-alert-new />

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <span class="bold">My Bid History</span>
                <a href="{{ route('profile.index') }}" class="btn btn-primary">Back to Profile</a>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($bids) == 0)
            <div class="my-4 d-flex justify-content-center">
                <p class="text-center my-3">You have not placed your bid yet!</p>
            </div>
            @else
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Listing</th>
                        <th>Your Bid</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bids as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a href="{{ route('front.listing', $item->listing_id) }}">
                                <b>{{ $item->listing->name }}</b>
                            </a>
                        </td>
                        <td>Rs. {{ $item->bid_price }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{ route('front.listing', $item->listing_id) }}" class="btn btn-info btn-sm">
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
