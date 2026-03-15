@extends('admin.layouts.master')

@section('title', 'Domains')

@section('content')
    <x-breadcrumb item="CMS" active="Domains"/>

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
                    <h5>Manage Domains</h5>
                    <a href="{{ route('admin.domains.create') }}" class="btn btn-primary btn-sm">Add Domain</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Items Count</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($domains as $domain)
                                    <tr>
                                        <td>{{ $domain->sort_order }}</td>
                                        <td>{{ $domain->title }}</td>
                                        <td>{{ is_array($domain->items) ? count($domain->items) : 0 }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.domains.edit', $domain) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No domains found.</td>
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
