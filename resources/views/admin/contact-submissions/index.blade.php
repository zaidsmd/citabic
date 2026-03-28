@extends('admin.layouts.master')

@section('title', __('admin.contact_submissions.title'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('admin.contact_submissions.list_title') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="contact-submissions-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.contact_submissions.columns.name') }}</th>
                                    <th>{{ __('admin.contact_submissions.columns.email') }}</th>
                                    <th>{{ __('admin.contact_submissions.columns.subject') }}</th>
                                    <th>{{ __('admin.contact_submissions.columns.number') }}</th>
                                    <th>{{ __('admin.contact_submissions.columns.message') }}</th>
                                    <th>{{ __('admin.contact_submissions.columns.submitted_at') }}</th>
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

            $('#contact-submissions-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('admin.contact-submissions.index') }}',
                order: [[5, 'desc']],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'subject', name: 'subject' },
                    { data: 'number', name: 'number' },
                    { data: 'message', name: 'message' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
                ],
            });
        });
    </script>
@endpush
