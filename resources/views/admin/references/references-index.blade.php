@extends('admin.layouts.master')

@section('title', 'References')

@section('content')
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
                    <h5>@lang('admin.references.list')</h5>
                    <a href="{{ route('admin.references.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i> @lang('admin.references.add')
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="references-table">
                            <thead>
                                <tr>
                                    <th>@lang('admin.references.table.image')</th>
                                    <th>@lang('admin.references.table.title')</th>
                                    <th>@lang('admin.references.table.client')</th>
                                    <th>@lang('admin.references.table.slug')</th>
                                    <th>@lang('admin.references.table.actions')</th>
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
    <script type="module"  src="{{asset('/build/js/references/index.js')}}"></script>
@endpush
