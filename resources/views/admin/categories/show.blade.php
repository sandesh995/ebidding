@extends('adminlte::page')

@section('title', 'Category Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Category Details
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                    Go Back
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table">
                <tr>
                    <th style="width: 15%">ID</th>
                    <td>{{ $category->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Parent</th>
                    <td>
                        @if($category->category_id)
                        <a href="{{ route('admin.categories.show', $category->category_id) }}">
                            {{ $category->parentCategory->name }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Child Categories</th>
                    <td>
                        <ul>
                            @foreach($category->childCategories as $cat)
                                <li>
                                    <a href="{{ route('admin.categories.show', $cat) }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
