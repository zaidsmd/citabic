@extends('admin.layouts.master')


@section('title',__('admin.certification.title'))

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/dataTables.bootstrap5.min.css" />
@endpush
@section('content')
    <x-breadcrumb item="CMS" active="{{__('admin.certification.title')}}"/>

    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{__('admin.certification.list')}}</h5>
                    <a href="{{ route('admin.certifications.create') }}" class="btn btn-primary btn-sm">
                        {{__('admin.certification.add')}}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" id="certifications-table">
                        <thead>
                        <tr>
                            <th>{{__('admin.certification.fields.image')}}</th>
                            <th>{{__('admin.certification.fields.name')}}</th>
                            <th>{{__('admin.certification.fields.description')}}</th>
                            <th class="text-end">{{__('admin.common.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/build/js/plugins/dataTables.min.js"></script>
    <script src="/build/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script type="module"  src="/build/js/certifications/index.js"></script>

@endpush
