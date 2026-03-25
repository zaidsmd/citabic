@extends('admin.layouts.master')

@section('title', __('admin.google_translate_settings.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    {{ __('admin.common.fix_errors') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.settings.google-translate.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h5 class="mb-0">{{ __('admin.google_translate_settings.title') }}</h5>
                                <p class="text-muted small mb-0">{{ __('admin.google_translate_settings.subtitle') }}</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    {{ __('admin.common.back_to_list') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i>
                                    {{ __('admin.common.save') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    {{ __('admin.google_translate_settings.project_id') }}
                                </label>
                                <input type="text"
                                       name="project_id"
                                       class="form-control @error('project_id') is-invalid @enderror"
                                       value="{{ old('project_id', $projectId) }}"
                                       placeholder="{{ __('admin.google_translate_settings.project_id_placeholder') }}"
                                       required>
                                @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    {{ __('admin.google_translate_settings.key_file') }}
                                </label>
                                <input type="file"
                                       name="key_file"
                                       accept=".json,.txt,application/json,text/plain"
                                       class="form-control @error('key_file') is-invalid @enderror">
                                @error('key_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if(!empty($keyFilePath))
                            <div class="mt-3 p-3 border rounded bg-light">
                                <div class="small text-muted mb-2">{{ __('admin.google_translate_settings.current_key_file') }}</div>
                                <div class="fw-semibold">{{ basename($keyFilePath) }}</div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="remove_key_file" name="remove_key_file">
                                    <label class="form-check-label" for="remove_key_file">
                                        {{ __('admin.google_translate_settings.remove_key_file') }}
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

