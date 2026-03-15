@extends('admin.layouts.master')

@section('title', 'References')

@section('content')
    <x-breadcrumb item="CMS" active="References"/>

    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Manage References</h5>
                    <a href="{{ route('admin.references.create') }}" class="btn btn-primary btn-sm">Add Reference</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Client</th>
                                    <th>Slug</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($references as $reference)
                                    <tr>
                                        <td>{{ $reference->sort_order }}</td>
                                        <td>
                                            @if($reference->image)
                                                <img src="{{ asset('storage/' . $reference->image) }}" alt="" style="height: 40px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ $reference->title }}</td>
                                        <td>{{ $reference->client }}</td>
                                        <td><code>{{ $reference->slug }}</code></td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.references.edit', $reference) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            <form action="{{ route('admin.references.destroy', $reference) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
