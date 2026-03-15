@extends('admin.layouts.master')

@php($isEdit = $domain->exists)

@section('title', $isEdit ? 'Edit Domain' : 'Create Domain')

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Domain' : 'Create Domain' }}"/>

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.domains.update', $domain) : route('admin.domains.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $isEdit ? 'Edit Domain' : 'Add New Domain' }}</h5>
                        <div>
                            <a href="{{ route('admin.domains.index') }}" class="btn btn-sm btn-light-secondary me-1">Back to List</a>
                            <button type="submit" class="btn btn-sm btn-primary">Save Domain</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs mb-3" id="domainTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="domainTabsContent">
                                    <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Title (FR)</label>
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $form['title']) }}" required>
                                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Items (FR - One per line)</label>
                                            <textarea name="items_raw" class="form-control" rows="10">{{ old('items_raw', implode(PHP_EOL, $form['items'])) }}</textarea>
                                            <small class="text-muted">Enter each item on a new line.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Title (EN)</label>
                                            <input type="text" name="en[title]" class="form-control" value="{{ old('en.title', $form['en']['title'] ?? '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Items (EN - One per line)</label>
                                            <textarea name="en[items_raw]" class="form-control" rows="10">{{ old('en.items_raw', $form['en']['items_raw'] ?? '') }}</textarea>
                                            <small class="text-muted">Enter each item on a new line.</small>
                                        </div>
                                    </div>
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
                        <button type="submit" class="btn btn-primary">Save Domain</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
