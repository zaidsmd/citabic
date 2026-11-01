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

    <!-- Social Share Modal -->
    <div class="modal fade" id="socialShareModal" tabindex="-1" aria-labelledby="socialShareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="socialShareModalLabel">
                        <i class="ti ti-share me-2 text-primary"></i>@lang('admin.references.share_modal_title')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        @lang('admin.references.share_card_description')
                    </p>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">@lang('admin.references.share_url')</label>
                        <div class="input-group">
                            <input type="text" id="shareReferenceUrl" class="form-control form-control-sm bg-light" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnCopyShareUrl" title="@lang('admin.references.copy')">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">@lang('admin.references.share_caption')</label>
                        <textarea id="shareCaption" class="form-control form-control-sm bg-light" rows="4" readonly></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="text-muted" style="font-size: 11px;">@lang('admin.references.share_caption_hint')</small>
                            <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none" id="btnCopyShareCaption" style="font-size: 12px;">
                                <i class="ti ti-copy me-1"></i><span id="copyCaptionText">@lang('admin.references.copy_caption')</span>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="#" id="btnPublishFacebook" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-2 d-flex align-items-center justify-content-center btn-social-share" data-platform="facebook" style="background-color: #1877F2; border-color: #1877F2; font-weight: 500;">
                            <i class="fab fa-facebook-f me-2 fs-6"></i> @lang('admin.references.open_facebook')
                        </a>
                        <a href="#" id="btnPublishLinkedin" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-2 d-flex align-items-center justify-content-center btn-social-share" data-platform="linkedin" style="background-color: #0A66C2; border-color: #0A66C2; font-weight: 500;">
                            <i class="fab fa-linkedin-in me-2 fs-6"></i> @lang('admin.references.open_linkedin')
                        </a>
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
    <script type="module" src="{{asset('/build/js/references/index.js')}}"></script>
@endpush
