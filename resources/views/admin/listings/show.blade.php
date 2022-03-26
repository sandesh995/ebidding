@extends('adminlte::page')

@section('title', 'Listing Details')

@section('content')

    <x-alert />
    <x-delete />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Listing Details
            </h3>

            <div class="card-tools">
                @if($listing->expiry_date < now())
                    <a href="{{ route('admin.listings.handle', $listing) }}" class="btn btn-secondary btn-sm">
                        Handle Bid Winner Payment
                    </a>
                @endif
                <a href="{{ route('admin.listings.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table">
                <tr>
                    <th style="width: 15%">ID</th>
                    <td>{{ $listing->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $listing->name }}</td>
                </tr>
                <tr>
                    <th>Base Price</th>
                    <td>Rs. {{ $listing->base_price }}</td>
                </tr>
                <tr>
                    <th>Bids</th>
                    <td>
                        @if(count($total_bids) == 0)
                            There are no bidding for this listing yet!
                        @else
                        <p>Highest Bid: <b>Rs. {{ $listing->largest_bid }}</b></p>
                        <hr>
                        <ul style="margin-bottom: 0">
                            @foreach($total_bids as $bid)
                                <li>
                                    <b><i>{{ $bid->user->name }}</i></b> bid <b>Rs. {{ $bid->bid_price }}</b>
                                    <small class="text-muted ml-1" title="{{ $bid->created_at->diffForHumans() }}">
                                        [{{ $bid->created_at->format('H:i A, M j, Y')}}]
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Expiry Date</th>
                    <td>
                        @if($listing->expiry_date < now())
                            <span class="text-danger text-bold">EXPIRED: </span>
                        @endif
                        {{ $listing->expiry_date->format('Y/m/d H:i:s A') }}

                        [{{ $listing->expiry_date->diffForHumans() }}]
                        @if($listing->expiry_date > now())
                            <button onclick="forceExpire()" type="button" class="float-right btn btn-danger btn-xs">Force Expire</button>
                            <form id="force-expire" action="{{ route('admin.listings.expire', $listing) }}" method="post">
                                @csrf
                            </form>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>
                        @if($listing->category_id && $listing->category)
                        <a href="{{ route('admin.categories.show', $listing->category_id) }}">
                            {{ $listing->category->name }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>User</th>
                    <td>
                        @if($listing->user_id && $listing->user)
                        <a href="{{ route('admin.users.show', $listing->user_id) }}">
                            {{ $listing->user->name }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! Str::markdown($listing->description ?? '') !!}</td>
                </tr>
                <tr>
                    <th>Cover Image</th>
                    <td>
                        <div class="d-flex">
                            @if ($listing->media_id && $listing->media)
                            <div class="p-1 bg-light elevation-1 m-1" style="position: relative">
                                <img src="/storage/{{ $listing->media->path }}" height="100px" alt="">
                                <div style="position:absolute; bottom:8px;right:8px">
                                    <button class="btn btn-xs btn-danger" type="button" onclick="confirmDelete('cover')">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-cover"action="{{ route('admin.listings.images.cover', $listing) }}" method="POST" class="d-none">
                                    @csrf
                                    @method("DELETE")
                                </form>
                            </div>
                        @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Other Images</th>
                    <td>
                        <div>
                            <button onclick="$('#uploadMedia').toggle()" class="btn btn-info">Add More Images</button>

                            <div id="uploadMedia" class="mt-2 mb-3" style="display:none">
                                <form action="{{ route('admin.listings.images.store', $listing) }}" enctype="multipart/form-data" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="images">Add More Images... (Multiple Uploads Supported)</label>
                                        <input type="file" name="images[]" id="images" class="form-control-file" multiple="multiple">
                                    </div>

                                    <input type="submit" value="Upload" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach($images as $media)
                            <div class="p-1 bg-light elevation-1 m-1" style="position: relative">
                                <img src="/storage/{{ $media->path }}" height="100px" alt="">
                                <div style="position:absolute; bottom:8px;right:8px">
                                    <button class="btn btn-xs btn-danger" type="button" onclick="confirmDelete({{ $media->id }})">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $media->id }}"action="{{ route('admin.listings.images.destroy', [$listing, $media]) }}" method="POST" class="d-none">
                                    @csrf
                                    @method("DELETE")
                                </form>
                            </div>
                            @endforeach
                        </div>

                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function forceExpire() {
            if(confirm('Are you sure you want to mark this product as expired?')) {
                document.getElementById('force-expire').submit();
            }
        }
    </script>
@endsection
