@extends('adminlte::page')

@section('title', 'Listings List')

@section('content')

    <x-alert />
    <x-delete />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                {{ !empty($search) ? 'Searching: ' . $search_term : 'Listings List' }}

                @if (!empty($search))
                 <a href="{{ route('admin.listings.index') }}" class="btn btn-primary btn-sm ml-4">Go Back</a>
                @endif
            </h3>

            <div class="card-tools">
                <form action="{{ route('admin.listings.search') }}" method="get" class="mr-3" style="display:inline-block">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" value="{{ $search_term ?? '' }}" class="form-control"
                            placeholder="Search Listings...">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-info btn-flat">Search</button>
                        </span>
                    </div>
                </form>

                <a href="{{ route('admin.listings.create') }}" class="btn btn-primary btn-sm">
                    Add New
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if (count($listings) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listings as $listing)
                            <tr>
                                <td>
                                    @if($listing->media_id && $listing->media)
                                        <img src="/storage/{{ $listing->media->path }}" alt="" height="30px">
                                    @endif
                                </td>
                                <td>
                                    #{{ $listing->id }} -
                                    {{ $listing->name }}
                                </td>
                                <td>Rs. {{ $listing->base_price }}</td>
                                <td>{{ $listing->category->name }}</td>
                                <td>{{ $listing->user->name }}</td>
                                <td>
                                    <a href="{{ route('admin.listings.show', $listing) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-fw fa-eye"></i>
                                        <span>Show</span>
                                    </a>
                                    <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-fw fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    {{-- <a href="#!" onclick="confirmDelete({{ $listing->id }})"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-fw fa-trash"></i>
                                        <span>Delete</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $listing->id }}"
                                        action="{{ route('admin.listings.destroy', $listing) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning mb-0 text-center">
                    There are no items in the table.
                </div>
            @endif
        </div>

        @if ($listings->perPage() < $listings->total())
            <div class="card-footer">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
@endsection
