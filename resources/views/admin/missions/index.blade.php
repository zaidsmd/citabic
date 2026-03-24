@extends('admin.layouts.master')
@section('title', 'Missions')
@section('content')
    <x-breadcrumb item="CMS" active="Missions"/>
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
                    <h5>Manage Missions</h5>
                    <a href="{{ route('admin.missions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-1"></i> Add Mission
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="missions-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Title (FR)</th>
                                    <th>Title (EN)</th>
                                    <th>Icon</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($missions as $mission)
                                    @php
                                        $fr = $mission->translations->firstWhere('locale', 'fr');
                                        $en = $mission->translations->firstWhere('locale', 'en');
                                    @endphp
                                    <tr>
                                        <td>{{ $mission->order }}</td>
                                        <td>{{ $fr?->title ?? '-' }}</td>
                                        <td>{{ $en?->title ?? '-' }}</td>
                                        <td>
                                            @if($mission->icon)
                                                <img src="{{ Storage::disk('public')->url($mission->icon) }}"
                                                     alt="icon" style="height:40px;width:40px;object-fit:cover;border-radius:4px;">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.missions.edit', $mission) }}" class="btn btn-sm btn-light-primary me-1">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.missions.destroy', $mission) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger"
                                                        onclick="return confirm('Are you sure you want to delete this mission?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No missions found.</td>
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
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $.fn.DataTable !== 'undefined') {
                $('#missions-table').DataTable({
                    order: [[0, 'asc']],
                    columnDefs: [{ orderable: false, targets: [3, 4] }]
                });
            }
        });
    </script>
@endpush
