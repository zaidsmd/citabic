@extends('admin.layouts.master')

@section('title', __('admin.missions.title'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.missions.index.title') }}</h5>
                    <a href="{{ route('admin.missions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-1"></i> {{ __('admin.missions.add_item') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="missions-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.missions.index.table.order') }}</th>
                                    <th>{{ __('admin.missions.index.table.title_fr') }}</th>
                                    <th>{{ __('admin.missions.index.table.title_en') }}</th>
                                    <th>{{ __('admin.missions.index.table.icon') }}</th>
                                    <th class="text-end">{{ __('admin.missions.index.table.actions') }}</th>
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

            $('#missions-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.missions.index') }}',
                columns: [
                    { data: 'order', name: 'order' },
                    { data: 'title_fr', name: 'title_fr', orderable: false },
                    { data: 'title_en', name: 'title_en', orderable: false },
                    { data: 'icon_preview', name: 'icon_preview', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
