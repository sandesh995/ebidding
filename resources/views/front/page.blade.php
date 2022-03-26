@extends('front.layouts.app')
@section('title', 'About Us')
@section('content')
<div class="container py-4" style="max-width: 800px;margin:auto">
    <div class="card mb-2">
        <div class="card-header">
            <h4 class="bold text-center mb-0">
                {{ $page->title }}
            </h4>
        </div>
        <div class="card-body">
           {!! \Str::markdown($page->body) !!}
        </div>
    </div>
</div>

@endsection