@extends('admin.layouts.master')

@php($isEdit = $figure->exists)

@section('title', $isEdit ? 'Edit Figure' : 'Create Figure')

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Figure' : 'Create Figure' }}"/>

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.figures.update', $figure) : route('admin.figures.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $isEdit ? 'Edit Figure' : 'Add New Figure' }}</h5>
                        <div>
                            <a href="{{ route('admin.figures.index') }}" class="btn btn-sm btn-light-secondary me-1">Back to List</a>
                            <button type="submit" class="btn btn-sm btn-primary">Save Figure</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs mb-3" id="figureTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="figureTabsContent">
                                    <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Label (FR)</label>
                                            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $form['label']) }}" required>
                                            @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Label (EN)</label>
                                            <input type="text" name="en[label]" class="form-control" value="{{ old('en.label', $form['en']['label'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $form['value']) }}" required>
                                    <small class="text-muted">Example: 15, 100+, etc. (Same for all languages)</small>
                                    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $form['sort_order']) }}" required>
                                    @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Figure</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
