@extends('front.layouts.app')
@section('title', $title ?? 'All Listings')

@section('content')
<header class="homepage-header py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <div class="row d-flex justify-content-center mt-4">
                <form class="col-md-6 d-flex"  method="GET" action="/search">
                    <div class="input-group">
                        <input type="text" autofocus name="q" class="form-control form-control-lg" placeholder="Search Listings.." value="{{ $search ?? '' }}">
                        <button class="btn btn-lg btn-secondary" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                              </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<section class="position-relative" style="margin-top: -400px">
    <div class="container">
        <div class="card card-body py-4">

            <h4 class="text-bold text-center my-4 pb-4">
                {{ !empty($category) ? 'Listings by Category: ' . $category->name : 'All Listings'}}
            </h4>

            <div class="row">
                @foreach($listings as $listing)
                    <x-product-card :listing="$listing" />
                @endforeach
            </div>

        </div>
    </div>
</section>

@endsection