@extends('admin.layouts.master')

@php($isEdit = $process->exists)

@section('title', $isEdit ? 'Edit Process' : 'Create Process')

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Process' : 'Create Process' }}"/>

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.processes.update', $process) : route('admin.processes.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $isEdit ? 'Edit Process' : 'Add New Process' }}</h5>
                        <div>
                            <a href="{{ route('admin.processes.index') }}" class="btn btn-sm btn-light-secondary me-1">Back to List</a>
                            <button type="submit" class="btn btn-sm btn-primary">Save Process</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs mb-3" id="processTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="processTabsContent">
                                    <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Title (FR)</label>
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $form['title']) }}" required>
                                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description (FR)</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $form['description']) }}</textarea>
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Title (EN)</label>
                                            <input type="text" name="en[title]" class="form-control" value="{{ old('en.title', $form['en']['title'] ?? '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description (EN)</label>
                                            <textarea name="en[description]" class="form-control" rows="5">{{ old('en.description', $form['en']['description'] ?? '') }}</textarea>
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
                        <button type="submit" class="btn btn-primary">Save Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
