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

    <!-- Social Share Modal -->
    <div class="modal fade" id="socialShareModal" tabindex="-1" aria-labelledby="socialShareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="socialShareModalLabel">
                        <i class="ti ti-share me-2 text-primary"></i>@lang('admin.posts.share_modal_title')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        @lang('admin.posts.share_card_description')
                    </p>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">@lang('admin.posts.share_url')</label>
                        <div class="input-group">
                            <input type="text" id="sharePostUrl" class="form-control form-control-sm bg-light" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnCopyShareUrl" title="@lang('admin.posts.copy')">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">@lang('admin.posts.share_caption')</label>
                        <textarea id="shareCaption" class="form-control form-control-sm bg-light" rows="4" readonly></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="text-muted" style="font-size: 11px;">@lang('admin.posts.share_caption_hint')</small>
                            <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none" id="btnCopyShareCaption" style="font-size: 12px;">
                                <i class="ti ti-copy me-1"></i><span id="copyCaptionText">@lang('admin.posts.copy_caption')</span>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="#" id="btnPublishFacebook" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-2 d-flex align-items-center justify-content-center btn-social-share" data-platform="facebook" style="background-color: #1877F2; border-color: #1877F2; font-weight: 500;">
                            <i class="fab fa-facebook-f me-2 fs-6"></i> @lang('admin.posts.open_facebook')
                        </a>
                        <a href="#" id="btnPublishLinkedin" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white py-2 d-flex align-items-center justify-content-center btn-social-share" data-platform="linkedin" style="background-color: #0A66C2; border-color: #0A66C2; font-weight: 500;">
                            <i class="fab fa-linkedin-in me-2 fs-6"></i> @lang('admin.posts.open_linkedin')
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

        // Helper for opening social popup window centered
        function openSocialPopup(url, title, w = 600, h = 650) {
            const left = (window.innerWidth / 2) - (w / 2) + window.screenLeft;
            const top = (window.innerHeight / 2) - (h / 2) + window.screenTop;
            const popup = window.open(url, title, `scrollbars=yes,width=${w},height=${h},top=${top},left=${left}`);
            if (popup && window.focus) {
                popup.focus();
            }
        }

        // 1-Click Social Popup trigger from table buttons
        $(document).on('click', '.btn-share-popup, .btn-social-share', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (!url || url === '#' || url === 'javascript:void(0)') return;
            const platform = $(this).data('platform') || 'SocialShare';
            openSocialPopup(url, platform);
        });

        // Open Post Share Modal
        $(document).on('click', '.btn-open-post-share-modal', function() {
            const $btn = $(this);
            const url = $btn.data('url') || '';
            const title = $btn.data('title') || '';
            let caption = $btn.data('caption');

            if (!caption) {
                // Fallback: strip any HTML from summary
                const rawSummary = String($btn.data('summary') || '');
                const tmp = document.createElement('div');
                tmp.innerHTML = rawSummary;
                const cleanSummary = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, ' ').trim();
                const summaryText = cleanSummary ? `\n\n${cleanSummary}` : '';
                caption = `Découvrez notre nouvel article : ${title}.${summaryText}\n\n👉 ${url}\n\n#CITABIC #Blog #Architecture #GénieCivil #Construction #Maroc`;
            }

            const fbUrl = $btn.data('fb') || `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            const liUrl = $btn.data('li') || `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;

            $('#sharePostUrl').val(url);
            $('#shareCaption').val(caption);
            $('#btnPublishFacebook').attr('href', fbUrl);
            $('#btnPublishLinkedin').attr('href', liUrl);

            const modalEl = document.getElementById('socialShareModal');
            if (modalEl && window.bootstrap) {
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            }
        });

        // Copy Caption Button
        $(document).on('click', '#btnCopyShareCaption', function() {
            const text = $('#shareCaption').val();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    const $label = $('#copyCaptionText');
                    const original = $label.text();
                    $label.text('✓ @lang("admin.posts.copied")');
                    setTimeout(() => $label.text(original), 2500);
                });
            }
        });

        // Copy URL Button
        $(document).on('click', '#btnCopyShareUrl', function() {
            const text = $('#sharePostUrl').val();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    const $btn = $(this);
                    $btn.html('<i class="ti ti-check text-success"></i>');
                    setTimeout(() => $btn.html('<i class="ti ti-copy"></i>'), 2000);
                });
            }
        });
    </script>
@endpush
