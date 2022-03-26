@extends('adminlte::page')

@section('title', 'Add New Listing')

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
            Add New Listing
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.listings.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.listings.store') }}" enctype="multipart/form-data">
            @csrf

            <x-input
                field="name"
                text="Listing Name"
                :required="true"
            />

            <x-input
                field="base_price"
                type="number"
                text="Base Price"
                :required="true"
            />

            <x-input
                type="select"
                field="user_id"
                text="User"
                :options="$users"
            />

            <x-input
                type="select"
                field="category_id"
                text="Category"
                :options="$categories"
            />

            <x-input
                field="expiry_date"
                type="datetime-local"
                text="Expiry Date (Leave Empty for 1 Month for Now)"
            />

            <x-input
                type="textarea"
                field="description"
                text="Description"
            />

            <x-input
                type="file"
                field="image"
                text="Image of Location (Cover / Optional)"
            />

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection