@extends('adminlte::page')

@section('title', 'Page Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Page Details
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table">
                <tr>
                    <th style="width: 15%">ID</th>
                    <td>{{ $page->id }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $page->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $page->slug }}</td>
                </tr>
                <tr>
                    <th>Body</th>
                    <td>{!! Str::markdown($page->body) !!}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if ($page->media_id && $page->media)
                            <img src="/storage/{{ $page->media->path }}" height="100px" alt="">
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
