@extends('front.layouts.app')
@section('title', 'Add New Listing')
@section('content')
<x-editor element="#description" />

<div class="container py-4" style="max-width: 700px;margin:auto">
    <div class="card mb-2">
        <div class="card-header">
            <span class="bold">Add New Listing</span>
        </div>
        <div class="card-body">
            <p>Adding new listing is free! <span class="text-warning" style="font-weight: bold">Please make sure to fill all the details correctly, as you will not be able to edit them later!</span></p>
            <h5>Please Note:</h5>
            <ul>
                <li class="text-danger">Fields marked with <b>*</b> are required!</li>
                <li>After adding the product, bidding will start immediately.</li>
                <li>Bidding will last for 30 days since adding the product!</li>
                <li><b>{{ config('app.name', 'E-Bidding') }}</b> will take <b>10% cut</b> from the listing after it has been bid successfully!</li>
            </ul>


            <hr>

            <form action="{{ route('front.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-input
                    field="name"
                    type="text"
                    text="Product Name"
                    :required="true"
                />

                <x-input
                    field="base_price"
                    type="number"
                    text="Base Price"
                    :required="true"
                />

                <x-input
                    field="category_id"
                    type="select"
                    :options="$categories"
                    text="Category"
                    :required="true"
                />

                <x-input
                    field="description"
                    type="textarea"
                    text="Description"
                />

                <x-input
                    field="image"
                    type="file"
                    text="Main Image"
                    :required="true"
                />

                <x-input
                    field="images[]"
                    type="file"
                    text="Other Images (Can Upload Multiple)"
                    :multiple="true"
                />

                <button type="submit" class="btn btn-primary mt-2">
                    Create New Listing
                </button>
            </form>
        </div>
    </div>
</div>

@endsection