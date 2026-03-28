@extends('admin.layouts.master')

@section('title', __('admin.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <x-admin.status-messages/>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-1">{{ __('admin.dashboard.title') }}</h4>
                            <p class="text-muted mb-0">{{ __('admin.dashboard.subtitle') }}</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus me-1"></i>{{ __('admin.dashboard.actions.new_post') }}
                            </a>
                            <a href="{{ route('admin.references.create') }}" class="btn btn-light-primary btn-sm">
                                <i class="fa fa-plus me-1"></i>{{ __('admin.dashboard.actions.new_reference') }}
                            </a>
                            <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-light-secondary btn-sm">
                                <i class="fa fa-envelope me-1"></i>{{ __('admin.dashboard.actions.view_contacts') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">{{ __('admin.dashboard.metrics.posts_total') }}</p>
                            <h3 class="mb-0">{{ $stats['posts_total'] }}</h3>
                            <small class="text-success">
                                {{ __('admin.dashboard.metrics.posts_published') }}: {{ $stats['posts_published'] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">{{ __('admin.dashboard.metrics.references_total') }}</p>
                            <h3 class="mb-0">{{ $stats['references_total'] }}</h3>
                            <small class="text-muted">
                                {{ __('admin.dashboard.metrics.domains_total') }}: {{ $stats['domains_total'] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">{{ __('admin.dashboard.metrics.comments_total') }}</p>
                            <h3 class="mb-0">{{ $stats['comments_total'] }}</h3>
                            <small class="text-warning">
                                {{ __('admin.dashboard.metrics.pending_comments') }}: {{ $stats['pending_comments'] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">{{ __('admin.dashboard.metrics.contact_submissions_total') }}</p>
                            <h3 class="mb-0">{{ $stats['contact_submissions_total'] }}</h3>
                            <small class="text-primary">
                                {{ __('admin.dashboard.metrics.contact_submissions_today') }}: {{ $stats['contact_submissions_today'] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.missions_total') }}</div>
                            <div class="fw-bold">{{ $stats['missions_total'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.values_total') }}</div>
                            <div class="fw-bold">{{ $stats['values_total'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.certifications_total') }}</div>
                            <div class="fw-bold">{{ $stats['certifications_total'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.categories_total') }}</div>
                            <div class="fw-bold">{{ $stats['categories_total'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.tags_total') }}</div>
                            <div class="fw-bold">{{ $stats['tags_total'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('admin.dashboard.metrics.profile_status') }}</div>
                            <div class="fw-bold">
                                {{ $profile ? __('admin.dashboard.profile_ready') : __('admin.dashboard.profile_missing') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('admin.dashboard.recent_comments.title') }}</h5>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-light-primary btn-sm">
                                {{ __('admin.dashboard.actions.manage_posts') }}
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.dashboard.recent_comments.author') }}</th>
                                            <th>{{ __('admin.dashboard.recent_comments.post') }}</th>
                                            <th>{{ __('admin.dashboard.recent_comments.status') }}</th>
                                            <th>{{ __('admin.dashboard.recent_comments.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentComments as $comment)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $comment->name }}</div>
                                                    <div class="text-muted small">{{ $comment->email }}</div>
                                                </td>
                                                <td>
                                                    <div class="small">{{ \Illuminate\Support\Str::limit($comment->post?->title ?? ('#'.$comment->post_id), 45) }}</div>
                                                    <a href="{{ route('admin.posts.edit', $comment->post_id) }}" class="small">{{ __('admin.dashboard.actions.open') }}</a>
                                                </td>
                                                <td>
                                                    @if($comment->is_approved)
                                                        <span class="badge bg-light-success text-success">{{ __('admin.dashboard.recent_comments.approved') }}</span>
                                                    @else
                                                        <span class="badge bg-light-warning text-warning">{{ __('admin.dashboard.recent_comments.pending') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-muted small">{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">{{ __('admin.dashboard.empty_comments') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('admin.dashboard.recent_contacts.title') }}</h5>
                            <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-light-primary btn-sm">
                                {{ __('admin.dashboard.actions.view_all') }}
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.dashboard.recent_contacts.name') }}</th>
                                            <th>{{ __('admin.dashboard.recent_contacts.subject') }}</th>
                                            <th>{{ __('admin.dashboard.recent_contacts.message') }}</th>
                                            <th>{{ __('admin.dashboard.recent_contacts.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentContacts as $submission)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $submission->name ?: '-' }}</div>
                                                    <div class="text-muted small">{{ $submission->email ?: '-' }}</div>
                                                </td>
                                                <td>{{ \Illuminate\Support\Str::limit((string) ($submission->subject ?: '-'), 35) }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit((string) ($submission->message ?: '-'), 60) }}</td>
                                                <td class="text-muted small">{{ $submission->created_at?->format('d M Y H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">{{ __('admin.dashboard.empty_contacts') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
