@extends('adminlte::page')

@section('title', 'Update Page Details')

@section('content')
<x-editor element="#body" />

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
            Update Page Details
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <x-input
                field="title"
                text="Title"
                :current="$page->title"
            />

            <x-input
                field="slug"
                text="URL Slug"
                :current="$page->slug"
            />

            <x-input
                type="textarea"
                field="body"
                text="Page Content"
                :current="$page->body"
            />

            <x-input
                type="file"
                field="image"
                text="Cover Image"
            />
            @if($page->media_id && $page->media)
            <div class="mb-3">
                Current Image: <br>
                <img src="/storage/{{ $page->media->path }}" alt="" height="30px">
            </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection