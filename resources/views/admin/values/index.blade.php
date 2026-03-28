@extends('admin.layouts.master')

@php($title = $type === 'human_values' ? __('admin.values.title_human_values') : __('admin.values.title_values'))

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.values.manage', ['title' => $title]) }}</h5>
                    <a href="{{ route('admin.values.create', ['type' => $type]) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>
                        {{ $type === 'human_values' ? __('admin.values.add_human_value') : __('admin.values.add_value') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="values-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.values.image') }}</th>
                                    <th>{{ __('admin.values.title_fr') }}</th>
                                    <th>{{ __('admin.values.text_fr') }}</th>
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

            $('#values-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('admin.values.index') }}',
                    data: {
                        type: '{{ $type }}',
                    },
                },
                columns: [
                    { data: 'image_preview', name: 'image_preview', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'text_excerpt', name: 'text', orderable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
