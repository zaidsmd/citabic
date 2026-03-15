@php use App\Enums\CompanyInfoKey; @endphp
@extends('admin.layouts.master')

@section('title', __('admin.company_info.title'))

@section('content')

    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Company Profile</h5>
                        <button type="submit" class="btn btn-primary">{{__('admin.common.save')}}</button>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="fr-tab" data-bs-toggle="tab"
                                        data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content"
                                        aria-selected="true">{{__('admin.language.fr')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content"
                                        type="button" role="tab" aria-controls="en-content"
                                        aria-selected="false">{{__('admin.language.en')}}</button>
                            </li>
                        </ul>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                        class="form-label">{{__('admin.company_info.labels.'.CompanyInfoKey::LEGAL_NAME->value)}}</label>
                                    <input type="text" name="{{CompanyInfoKey::LEGAL_NAME->value}}"
                                           class="form-control @error(CompanyInfoKey::LEGAL_NAME->value) is-invalid @enderror"
                                           value="{{ old(CompanyInfoKey::LEGAL_NAME->value, $fr_info[CompanyInfoKey::LEGAL_NAME->value]) }}" required>
                                    @error(CompanyInfoKey::LEGAL_NAME->value)
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
