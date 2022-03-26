@extends('front.layouts.app')

@section('content')
<section>
    <div class="container px-4 px-lg-5 my-5">
        <x-alert-new />

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="mb-2">
                    <img
                        id="main-image"
                        style="width: 100%;border-radius: 10px;height: 300px;object-fit:cover"
                        class="shadow"
                        src="{{ $listing->picture }}"
                        alt="Cover Image"
                    />
                </div>
                @if(count($images) > 0)
                <div class="d-flex mb-4 mb-md-0" id="grid-images">
                    <img
                        id="img-0" class="grid-img active-img"
                        src="{{ $listing->picture }}"
                        onclick="change(0, '{{ $listing->picture }}')"
                        alt=""
                    >
                    @foreach($images as $img)
                      <img
                        id="img-{{ $loop->index + 1 }}" class="grid-img"
                        src="{{ asset('storage/'. $img->path) }}"
                        onclick="change({{ $loop->index + 1 }}, '{{ asset('storage/'. $img->path) }}')"
                        alt=""
                    >
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-12 col-md-6">
                <h2 class="bold mb-3">{{ $listing->name }}</h2>

                <table class="table table-sm table-bordered" style="box-shadow: none!important">
                    <tr>
                        <th>Listing By</th>
                        <td>{{ $listing->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Base Price</th>
                        <td><b>Rs. {{ $listing->base_price }}</b></td>
                    </tr>
                    @if($bidding_count > 0)
                    <tr>
                        <th>Largest Bid</th>
                        <td><b>Rs. {{ $listing->largest_bid }}</b></td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            {{ $listing->expiry_date < now() ? 'Auction Ended' : 'Auction Ends' }}
                        </th>
                        <td>{{ $listing->expiry_date->format('M j, Y H:i A') }} / {{ $listing->expiry_date->diffForHumans() }}</td>
                    </tr>
                </table>

                @if($listing->expiry_date >= now())
                @auth
                <form action="{{ route('front.bid', $listing) }}" method="post">
                    @csrf
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="amount" class="form-label">Your Bid Amount</label>
                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                class="form-control"
                                style="width: 150px"
                                value="{{ old('amount') ?? ( $listing->largest_bid ?? $listing->base_price ) + 1 }}"
                            >
                        </div>
                        <div style="padding-top: 32px;padding-left: 10px">
                            <button type="submit" class="btn btn-primary">Place Bid</button>
                        </div>
                    </div>
                    <p><small>Enter price more than Rs. {{ $listing->largest_bid ?? $listing->base_price }}</small></p>
                </form>
                @else
                <p>You need to be <a href="{{ route('login') }}">Logged in</a> to place a bid.</p>
                @endauth
                @else
                    <p>
                        Auction has ended.
                        @if($bidding_count > 0)
                        <b><i>{{ $all_bids->first()->user->name }}</i></b> has won the auction for <b>Rs. {{ $listing->largest_bid }}</b>!
                        @endif
                    </p>
                @endif

                @if($bidding_count > 0)
                <p class="pt-3">Total Bids: <b>[{{ $bidding_count }} Bids]</b></p>
                @else
                <p class="pt-3">No Bids Yet!</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="container mb-4">
    <div class="pt-3 mt-2" style="border-top:1px solid #ccc;">
        <div class="d-flex">
            <div class="col-7">
                <h5 class="bold mb-2">Description</h5>
                <p>{!! \Str::markdown($listing->description ?? "" ) !!}</p>
            </div>
            <div class="col-4">
                <h5 class="bold mb-2">Bids</h5>
                <ul>
                    @foreach($all_bids as $bid)
                    <li>
                        <b><i>{{ $bid->user->name }}</i></b> bid <b>Rs. {{ $bid->bid_price }}</b> <small class="text-muted">[{{ $bid->created_at->format('H:i A, M j, Y')}}]</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

@if(count($user_listings) > 0)
<section class="container mb-4">
    <h5 class="bold mb-2">More from {{ $listing->user->name }}</h3>

    <div class="row">
        @foreach($user_listings as $item)
            <x-product-card :listing="$item" />
        @endforeach
    </div>
</section>
@endif

@if(count($related_listings) > 0)
<section class="container mb-4">
    <h5 class="bold mb-2">More from Same Category</h5>

    <div class="row">
        @foreach($related_listings as $item)
            <x-product-card :listing="$item" />
        @endforeach
    </div>
</section>
@endif

@endsection

@push('js')
<script>
function change(id, url) {
    // Clear All Images with Path
    let images = document.querySelectorAll('#grid-images img');
    images.forEach(img => {
        img.classList.remove('active-img');
    });

    // Active Image
    document.getElementById('img-' + id).classList.add('active-img');

    // Replace Image
    document.getElementById('main-image').src = url;
}
</script>
@endpush()
