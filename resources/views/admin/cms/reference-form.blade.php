@extends('admin.layouts.master')

@php($isEdit = isset($reference))

@section('title', $isEdit ? 'Edit Reference' : 'Create Reference')

@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Reference' : 'Create Reference' }}"/>

    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ $isEdit ? route('admin.references.update', $reference) : route('admin.references.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $isEdit ? 'Edit Reference' : 'Add New Reference' }}</h5>
                        <div>
                            <a href="{{ route('admin.references.index') }}" class="btn btn-sm btn-light-secondary me-1">Back to List</a>
                            <button type="submit" class="btn btn-sm btn-primary">Save Reference</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="referenceTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="referenceTabsContent">
                            <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Title (FR)</label>
                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $form['title']) }}" required>
                                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Summary (FR)</label>
                                            <textarea name="summary" class="form-control @error('summary') is-invalid @enderror" rows="3" required>{{ old('summary', $form['summary']) }}</textarea>
                                            @error('summary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description (FR)</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $form['description']) }}</textarea>
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Items (FR - One per line)</label>
                                            <textarea name="items" class="form-control" rows="5">{{ old('items', $form['items']) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Title (EN)</label>
                                            <input type="text" name="en[title]" class="form-control" value="{{ old('en.title', $form['en']['title'] ?? '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Summary (EN)</label>
                                            <textarea name="en[summary]" class="form-control" rows="3">{{ old('en.summary', $form['en']['summary'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description (EN)</label>
                                            <textarea name="en[description]" class="form-control" rows="5">{{ old('en.description', $form['en']['description'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Items (EN - One per line)</label>
                                            <textarea name="en[items]" class="form-control" rows="5">{{ old('en.items', $form['en']['items'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Client</label>
                                    <input type="text" name="client" class="form-control @error('client') is-invalid @enderror" value="{{ old('client', $form['client']) }}" required>
                                    @error('client') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $form['slug']) }}" required>
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image Path</label>
                                    <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $form['image']) }}">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Surface</label>
                                            <input type="text" name="surface" class="form-control @error('surface') is-invalid @enderror" value="{{ old('surface', $form['surface']) }}">
                                            @error('surface') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Budget</label>
                                            <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror" value="{{ old('budget', $form['budget']) }}">
                                            @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $form['sort_order']) }}" required>
                                    @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Reference</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
