@extends('adminlte::page')

@section('title', 'Update Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
            Update Category
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                Go Back
            </a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-input
                field="name"
                text="Name"
                :current="$category->name"
                :required="true"
            />

            <div class="form-group">
                <label for="category_id">Parent Category</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @endif">
                    <option value="">Choose a category...</option>
                    @foreach($categories as $cat)
                        <option
                            value="{{ $cat->id }}"
                            @if($category->category_id == $cat->id) selected @endif
                        >{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-fw fa-save mr-2"></i>
                <span>Save</span>
            </button>

        </form>


    </div>
</div>
@endsection