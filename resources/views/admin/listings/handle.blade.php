@extends('adminlte::page')

@section('title', 'Listing Details')

@section('content')

    <x-alert />
    <x-delete />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Handle Listing Winner Payment
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.listings.show', $listing) }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <p>This listing has expired. There were total of {{ count($bids) }} bids for this listing!</p>
            @if(count($bids) > 0)
            <ul class="margin-bottom: 0">
                @foreach($bids as $bid)
                <li>
                    <b><i>{{ $bid->user->name }}</i></b> bid <b>Rs. {{ $bid->bid_price }}</b>
                    <small class="text-muted ml-1" title="{{ $bid->created_at->diffForHumans() }}">
                        [{{ $bid->created_at->format('H:i A, M j, Y')}}]
                    </small>
                </li>
                @endforeach
            </ul>

            <p><b>Top Bid: Rs. {{ $listing->largest_bid }}</b> by <b>{{ $bids->first()->user->name }}</b></p>

            <form action="{{ route('admin.listings.complete', $listing) }}" method="post">
                @csrf

                <button type="submit" class="btn btn-primary">
                    Handle Payment/Refunds and Mark Listing as Complete
                </button>
            </form>
            @else
                <p>Since no one has placed any bids for this listing, there is nothing to do!</p>
            @endif
        </div>
    </div>
@endsection
