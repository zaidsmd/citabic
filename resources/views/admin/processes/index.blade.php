@extends('admin.layouts.master')

@section('title', __('admin.processes.index.page_title'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>@lang('admin.processes.index.title')</h5>
                    <a href="{{ route('admin.processes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>
                        @lang('admin.processes.add')
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="processes-table">
                            <thead>
                                <tr>
                                    <th>@lang('admin.processes.table.title')</th>
                                    <th>@lang('admin.processes.table.description')</th>
                                    <th class="text-end">@lang('admin.processes.table.actions')</th>
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
    <script type="module"  src="{{asset('/build/js/processes/index.js')}}"></script>
@endpush
