@php use App\Enums\CompanyInfoKey; @endphp
@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="/build/css/plugins/datepicker-bs5.min.css">
@endpush
@section('title', __('admin.company_info.title'))

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

            <form action="{{ route('admin.company-info.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h5 class="mb-0">{{ __('admin.company_info.title') }}</h5>
                                <p class="text-muted small mb-0">{{ __('admin.company_info.subtitle') }}</p>
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

                        {{-- Basic Information Section --}}
                        <div class="section-title mb-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-building me-2"></i>
                                {{ __('admin.company_info.sections.basic_info') }}
                            </h6>
                            <hr class="mt-1">
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::FULL_NAME->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="{{ CompanyInfoKey::FULL_NAME->value }}"
                                           class="form-control @error(CompanyInfoKey::FULL_NAME->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::FULL_NAME->value, $info[CompanyInfoKey::FULL_NAME->value]) }}"
                                           placeholder="{{ __('admin.company_info.placeholders.'.CompanyInfoKey::FULL_NAME->value) }}"
                                           required>
                                    @error(CompanyInfoKey::FULL_NAME->value)
                                    <div class="invalid-feedback">
                                        <i class="fa fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <small class="text-muted">{{ __('admin.company_info.help.'.CompanyInfoKey::FULL_NAME->value) }}</small>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::LEGAL_NAME->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="{{ CompanyInfoKey::LEGAL_NAME->value }}"
                                           class="form-control @error(CompanyInfoKey::LEGAL_NAME->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::LEGAL_NAME->value, $info[CompanyInfoKey::LEGAL_NAME->value]) }}"
                                           placeholder="{{ __('admin.company_info.placeholders.'.CompanyInfoKey::LEGAL_NAME->value) }}"
                                           required>
                                    @error(CompanyInfoKey::LEGAL_NAME->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::LEGAL_FORM->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="{{ CompanyInfoKey::LEGAL_FORM->value }}"
                                           class="form-control @error(CompanyInfoKey::LEGAL_FORM->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::LEGAL_FORM->value, $info[CompanyInfoKey::LEGAL_FORM->value]) }}"
                                           placeholder="{{ __('admin.company_info.placeholders.'.CompanyInfoKey::LEGAL_FORM->value) }}"
                                           required>
                                    @error(CompanyInfoKey::LEGAL_FORM->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::CAPITAL->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               step="0.01"
                                               min="0"
                                               name="{{ CompanyInfoKey::CAPITAL->value }}"
                                               class="form-control @error(CompanyInfoKey::CAPITAL->value) is-invalid @enderror"
                                               value="{{ old(CompanyInfoKey::CAPITAL->value, $info[CompanyInfoKey::CAPITAL->value]) }}"
                                               placeholder="0.00"
                                               required>
                                        <span class="input-group-text">MAD</span>
                                        @error(CompanyInfoKey::CAPITAL->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::CREATION_DATE->value) }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="{{ CompanyInfoKey::CREATION_DATE->value }}"
                                           class="form-control @error(CompanyInfoKey::CREATION_DATE->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::CREATION_DATE->value, $info[CompanyInfoKey::CREATION_DATE->value]) }}"
                                           required id="pc-datepicker-2">
                                    @error(CompanyInfoKey::CREATION_DATE->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Contact Information Section --}}
                        <div class="section-title mt-5 mb-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-address-card me-2"></i>
                                {{ __('admin.company_info.sections.contact_info') }}
                            </h6>
                            <hr class="mt-1">
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::ADDRESS->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="{{ CompanyInfoKey::ADDRESS->value }}"
                                              rows="3"
                                              class="form-control @error(CompanyInfoKey::ADDRESS->value) is-invalid @enderror"
                                              placeholder="{{ __('admin.company_info.placeholders.'.CompanyInfoKey::ADDRESS->value) }}"
                                              required>{{ old(CompanyInfoKey::ADDRESS->value, $info[CompanyInfoKey::ADDRESS->value]) }}</textarea>
                                    @error(CompanyInfoKey::ADDRESS->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::PHONE->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        <input type="tel"
                                               name="{{ CompanyInfoKey::PHONE->value }}"
                                               class="form-control @error(CompanyInfoKey::PHONE->value) is-invalid @enderror"
                                               value="{{ old(CompanyInfoKey::PHONE->value, $info[CompanyInfoKey::PHONE->value]) }}"
                                               placeholder="+212 XXX-XXXXXX"
                                               required>
                                        @error(CompanyInfoKey::PHONE->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::EMAIL->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        <input type="email"
                                               name="{{ CompanyInfoKey::EMAIL->value }}"
                                               class="form-control @error(CompanyInfoKey::EMAIL->value) is-invalid @enderror"
                                               value="{{ old(CompanyInfoKey::EMAIL->value, $info[CompanyInfoKey::EMAIL->value]) }}"
                                               placeholder="company@example.com"
                                               required>
                                        @error(CompanyInfoKey::EMAIL->value)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Legal Information Section --}}
                        <div class="section-title mt-5 mb-4">
                            <h6 class="fw-bold text-primary">
                                <i class="fa fa-gavel me-2"></i>
                                {{ __('admin.company_info.sections.legal_info') }}
                            </h6>
                            <hr class="mt-1">
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::RC->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="{{ CompanyInfoKey::RC->value }}"
                                           class="form-control @error(CompanyInfoKey::RC->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::RC->value, $info[CompanyInfoKey::RC->value]) }}"
                                           placeholder="RC-XXXXX"
                                           required>
                                    @error(CompanyInfoKey::RC->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::ICE->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="{{ CompanyInfoKey::ICE->value }}"
                                           class="form-control @error(CompanyInfoKey::ICE->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::ICE->value, $info[CompanyInfoKey::ICE->value]) }}"
                                           placeholder="ICE-XXXXX"
                                           required>
                                    @error(CompanyInfoKey::ICE->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        {{ __('admin.company_info.labels.'.CompanyInfoKey::STATUS->value) }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="{{ CompanyInfoKey::STATUS->value }}"
                                            class="form-select @error(CompanyInfoKey::STATUS->value) is-invalid @enderror"
                                            required>
                                        <option value="active" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value]) == 'active' ? 'selected' : '' }}>
                                            {{ __('admin.company_info.status.active') }}
                                        </option>
                                        <option value="inactive" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value]) == 'inactive' ? 'selected' : '' }}>
                                            {{ __('admin.company_info.status.inactive') }}
                                        </option>
                                        <option value="pending" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value]) == 'pending' ? 'selected' : '' }}>
                                            {{ __('admin.company_info.status.pending') }}
                                        </option>
                                    </select>
                                    @error(CompanyInfoKey::STATUS->value)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-end gap-2">
                            <small class="text-muted me-auto">
                                <i class="fa fa-info-circle me-1"></i>
                                {{ __('admin.company_info.last_updated') }}: {{ now()->format('d/m/Y H:i') }}
                            </small>
                            <button type="reset" class="btn btn-light">
                                <i class="fa fa-undo me-1"></i>
                                {{ __('admin.common.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                {{ __('admin.common.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/build/js/plugins/datepicker-full.min.js" ></script>
    <script>
        (function () {
            const d_week = new Datepicker(document.querySelector('#pc-datepicker-2'), {
                buttonClass: 'btn'
            });
        })();
    </script>
@endpush
