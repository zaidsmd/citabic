@php use App\Enums\CompanyInfoKey; @endphp
@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{asset('build/css/plugins/datepicker-bs5.min.css')}}">
@endpush
@section('title', __('admin.company_info.title'))

@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-12">
                <x-admin.status-messages :errors="$errors->all()"/>

                <form action="{{ route('admin.company-info.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-admin.page-header
                        :title="__('admin.company_info.title')"
                        :subtitle="__('admin.company_info.subtitle')"
                        :back-url="route('admin.dashboard')"
                        :back-label="__('admin.common.back_to_list')"/>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <x-admin.section-title
                                icon="fa fa-building"
                                :title="__('admin.company_info.sections.basic_info')"/>

                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::FULL_NAME->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::FULL_NAME->value)"
                                        :value="old(CompanyInfoKey::FULL_NAME->value, $info[CompanyInfoKey::FULL_NAME->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::FULL_NAME->value)"
                                        :required="true"/>
                                    <small class="text-muted">{{ __('admin.company_info.help.'.CompanyInfoKey::FULL_NAME->value) }}</small>
                                </div>
                                <div class="col-lg-6">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::LEGAL_NAME->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::LEGAL_NAME->value)"
                                        :value="old(CompanyInfoKey::LEGAL_NAME->value, $info[CompanyInfoKey::LEGAL_NAME->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::LEGAL_NAME->value)"
                                        :required="true"/>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::LEGAL_FORM->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::LEGAL_FORM->value)"
                                        :value="old(CompanyInfoKey::LEGAL_FORM->value, $info[CompanyInfoKey::LEGAL_FORM->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::LEGAL_FORM->value)"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::CAPITAL->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::CAPITAL->value) . ' (MAD)'"
                                        :value="old(CompanyInfoKey::CAPITAL->value, $info[CompanyInfoKey::CAPITAL->value] ?? '')"
                                        placeholder="0.00"
                                        type="number"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::CREATION_DATE->value"
                                        :id="'pc-datepicker-2'"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::CREATION_DATE->value)"
                                        :value="old(CompanyInfoKey::CREATION_DATE->value, $info[CompanyInfoKey::CREATION_DATE->value] ?? '')"
                                        :required="true"/>
                                </div>
                            </div>

                            <x-admin.section-title
                                class="mt-5"
                                icon="fa fa-address-card"
                                :title="__('admin.company_info.sections.contact_info')"/>

                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <x-admin.textarea
                                        :name="CompanyInfoKey::ADDRESS->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::ADDRESS->value)"
                                        :value="old(CompanyInfoKey::ADDRESS->value, $info[CompanyInfoKey::ADDRESS->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::ADDRESS->value)"
                                        :rows="3"
                                        :floating="true"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-3">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::PHONE->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::PHONE->value)"
                                        :value="old(CompanyInfoKey::PHONE->value, $info[CompanyInfoKey::PHONE->value] ?? '')"
                                        placeholder="+212 XXX-XXXXXX"
                                        type="tel"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-3">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::EMAIL->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::EMAIL->value)"
                                        :value="old(CompanyInfoKey::EMAIL->value, $info[CompanyInfoKey::EMAIL->value] ?? '')"
                                        placeholder="company@example.com"
                                        type="email"
                                        :required="true"/>
                                </div>
                            </div>

                            <x-admin.section-title
                                class="mt-5"
                                icon="fa fa-gavel"
                                :title="__('admin.company_info.sections.legal_info')"/>

                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::RC->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::RC->value)"
                                        :value="old(CompanyInfoKey::RC->value, $info[CompanyInfoKey::RC->value] ?? '')"
                                        placeholder="RC-XXXXX"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::ICE->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::ICE->value)"
                                        :value="old(CompanyInfoKey::ICE->value, $info[CompanyInfoKey::ICE->value] ?? '')"
                                        placeholder="ICE-XXXXX"
                                        :required="true"/>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <select name="{{ CompanyInfoKey::STATUS->value }}"
                                                    class="form-select @error(CompanyInfoKey::STATUS->value) is-invalid @enderror"
                                                    id="company-status"
                                                    required>
                                                <option value="active" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value] ?? '') == 'active' ? 'selected' : '' }}>
                                                    {{ __('admin.company_info.status.active') }}
                                                </option>
                                                <option value="inactive" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value] ?? '') == 'inactive' ? 'selected' : '' }}>
                                                    {{ __('admin.company_info.status.inactive') }}
                                                </option>
                                                <option value="pending" {{ old(CompanyInfoKey::STATUS->value, $info[CompanyInfoKey::STATUS->value] ?? '') == 'pending' ? 'selected' : '' }}>
                                                    {{ __('admin.company_info.status.pending') }}
                                                </option>
                                            </select>
                                            <label for="company-status" class="fw-semibold">
                                                {{ __('admin.company_info.labels.'.CompanyInfoKey::STATUS->value) }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            @error(CompanyInfoKey::STATUS->value)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-admin.section-title
                                class="mt-5"
                                icon="fa fa-share-alt"
                                :title="__('admin.company_info.sections.social_media')"/>

                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::LINKEDIN->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::LINKEDIN->value)"
                                        :value="old(CompanyInfoKey::LINKEDIN->value, $info[CompanyInfoKey::LINKEDIN->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::LINKEDIN->value)"
                                        type="url"/>
                                </div>
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::INSTAGRAM->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::INSTAGRAM->value)"
                                        :value="old(CompanyInfoKey::INSTAGRAM->value, $info[CompanyInfoKey::INSTAGRAM->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::INSTAGRAM->value)"
                                        type="url"/>
                                </div>
                                <div class="col-lg-4">
                                    <x-admin.text-input
                                        :name="CompanyInfoKey::FACEBOOK->value"
                                        :label="__('admin.company_info.labels.'.CompanyInfoKey::FACEBOOK->value)"
                                        :value="old(CompanyInfoKey::FACEBOOK->value, $info[CompanyInfoKey::FACEBOOK->value] ?? '')"
                                        :placeholder="__('admin.company_info.placeholders.'.CompanyInfoKey::FACEBOOK->value)"
                                        type="url"/>
                                </div>
                            </div>
                        </div>

                        <x-admin.form-actions
                            :save-label="__('admin.common.save')"
                            :reset-label="__('admin.common.cancel')"/>
                    </div>
                </form>
            </div>
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
