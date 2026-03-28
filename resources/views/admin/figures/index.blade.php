@extends('admin.layouts.master')

@section('title', __('admin.figures.title'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.figures.manage') }}</h5>
                    <a href="{{ route('admin.figures.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>
                        {{ __('admin.figures.add') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="figures-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.figures.order') }}</th>
                                    <th>{{ __('admin.figures.label_fr') }}</th>
                                    <th>{{ __('admin.figures.value') }}</th>
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

            $('#figures-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.figures.index') }}',
                columns: [
                    { data: 'sort_order', name: 'sort_order' },
                    { data: 'label', name: 'label' },
                    { data: 'value', name: 'value' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
