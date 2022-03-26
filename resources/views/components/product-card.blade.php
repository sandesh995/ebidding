@props(['listing'])
@php
$colors = collect(['primary', 'success', 'info', 'dark', 'warning']);
@endphp

<div class="col-6 col-sm-4 col-md-3 pb-2">
    <div class="card h-100 mb-2">
        <!-- Sale badge-->
        <div class="badge bg-{{ $colors->random(1)->first() }} text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
           {{ $listing->category->name }}
        </div>
        <!-- Product image-->
        <img class="card-img-top" style="height: 155px;object-fit:cover" src="{{ $listing->picture }}" alt="..." />
        <!-- Product details-->
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">{{ $listing->name }}</h5>
                <!-- Product price-->
                Base: Rs. {{ $listing->base_price}}
                @if($listing->largest_bid > 0)
                    / Bid: Rs. {{ $listing->largest_bid }}
                @endif
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
                <a class="btn btn-outline-dark mt-auto" href="/listing/{{ $listing->id }}">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>