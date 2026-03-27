@extends('admin.layouts.master')
@php($isEdit = $category->exists)
@section('title', $isEdit ? 'Edit Category' : 'Create Category')
@section('content')
    <x-breadcrumb item="CMS" active="{{ $isEdit ? 'Edit Category' : 'Create Category' }}"/>
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif
                <x-admin.page-header
                    :title="$isEdit ? 'Edit Category' : 'Add New Category'"
                    subtitle="Manage category content"
                    :back-url="route('admin.categories.index')"
                    back-label="Back to List"/>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <x-admin.language-tabs :locales="['fr']" id-prefix="category"/>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="category-fr-content" role="tabpanel" aria-labelledby="category-fr-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
