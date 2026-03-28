@extends('admin.layouts.master')

@section('title', __('admin.posts.index.title'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.posts.index.title') }}</h5>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>
                        {{ __('admin.common.create') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="posts-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.posts.index.image') }}</th>
                                    <th>{{ __('admin.posts.title') }}</th>
                                    <th>{{ __('admin.posts.index.status') }}</th>
                                    <th>{{ __('admin.posts.index.categories') }}</th>
                                    <th>{{ __('admin.posts.index.published_at') }}</th>
                                    <th>{{ __('admin.posts.index.views') }}</th>
                                    <th class="text-end">{{ __('admin.common.actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('build/js/plugins/jquery.min.js')}}"></script>
    <script src="{{asset('build/js/plugins/dataTables.min.js')}}"></script>
    <script src="{{asset('build/js/plugins/dataTables.bootstrap5.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $.fn.DataTable === 'undefined') {
                return;
            }

            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.posts.index') }}',
                columns: [
                    { data: 'image_preview', name: 'image_preview', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'status_badge', name: 'status', orderable: false },
                    { data: 'categories_badges', name: 'categories_badges', orderable: false, searchable: false },
                    { data: 'published_at_display', name: 'published_at' },
                    { data: 'views', name: 'views' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
