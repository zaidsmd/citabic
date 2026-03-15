@extends('admin.layouts.master')

@section('title', 'Processes')

@section('content')
    <x-breadcrumb item="CMS" active="Processes"/>

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
                    <h5>Manage Processes</h5>
                    <a href="{{ route('admin.processes.create') }}" class="btn btn-primary btn-sm">Add Process</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($processes as $process)
                                    <tr>
                                        <td>{{ $process->sort_order }}</td>
                                        <td>{{ $process->title }}</td>
                                        <td>{{ Str::limit($process->description, 100) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.processes.edit', $process) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            <form action="{{ route('admin.processes.destroy', $process) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No processes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
