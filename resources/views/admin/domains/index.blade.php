@extends('admin.layouts.master')

@section('title', __('admin.domains.title'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.domains.manage') }}</h5>
                    <a href="{{ route('admin.domains.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>
                        {{ __('admin.domains.add') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="domains-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.domains.title_fr') }}</th>
                                    <th>{{ __('admin.domains.items_count') }}</th>
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

            $('#domains-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.domains.index') }}',
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'items_count', name: 'items_count', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
