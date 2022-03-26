@extends('adminlte::page')

@section('title', 'Pages List')

@section('content')

    <x-alert />
    <x-delete />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold" style="font-size: 1.3rem;line-height: 1.5">
                Pages List
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
                    Add New
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if (count($pages) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    @if($page->media_id && $page->media)
                                        <img src="/storage/{{ $page->media->path }}" alt="" height="30px">
                                    @endif
                                </td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-fw fa-eye"></i>
                                        <span>Show</span>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-fw fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <a href="#!" onclick="confirmDelete({{ $page->id }})" class="btn btn-danger btn-sm">
                                        <i class="fas fa-fw fa-trash"></i>
                                        <span>Delete</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $page->id }}"
                                        action="{{ route('admin.pages.destroy', $page) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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

        @if ($pages->perPage() < $pages->total())
            <div class="card-footer">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection
