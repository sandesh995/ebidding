@extends('adminlte::page')

@section('title', 'Add New Page')

@section('content')
<x-editor element="#body" />

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
            Add New Page
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
            @csrf

            <x-input
                field="title"
                text="Title"
            />

            <x-input
                field="slug"
                text="URL Slug"
            />

            <x-input
                type="textarea"
                field="body"
                text="Page Content"
            />

            <x-input
                type="file"
                field="image"
                text="Cover Image"
            />

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection