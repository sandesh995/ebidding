@extends('adminlte::page')

@section('title', 'Update Listings')

@section('plugins.Select2')

@push('js')
<script>
    $(document).ready(function() {
        $('#category_id').select2();
        $('#user_id').select2();
    });
</script>
@endpush

@section('content')
<x-editor element="#description" />

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
            Update Listings
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.listings.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.listings.update', $listing) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-input
                field="name"
                text="Listing Name"
                :required="true"
                :current="$listing->name"
            />

            <x-input
                field="base_price"
                type="number"
                text="Base Price"
                :required="true"
                :current="$listing->base_price"
            />

            <x-input
                type="select"
                field="user_id"
                text="User"
                :options="$users"
                :current="$listing->user_id"
            />

            <x-input
                type="select"
                field="category_id"
                text="Category"
                :options="$categories"
                :current="$listing->category_id"
            />

            <x-input
                field="expiry_date"
                type="datetime-local"
                :current="$listing->datetime_format"
                text="Expiry Date (Leave Empty for 1 Month for Now)"
            />

            <x-input
                type="textarea"
                field="description"
                text="Description"
                :current="$listing->description"
            />

            <x-input
                type="file"
                field="image"
                text="Image of Listing (Cover / Optional / Upload to override Existing)"
            />

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection