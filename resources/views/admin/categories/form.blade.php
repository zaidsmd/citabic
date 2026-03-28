@extends('admin.layouts.master')

@php($isEdit = $category->exists)

@section('title', $isEdit ? __('admin.categories.edit') : __('admin.categories.create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.categories.edit') : __('admin.categories.add')"
                    :subtitle="__('admin.categories.form.subtitle')"
                    :back-url="route('admin.categories.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="name"
                                    :label="__('admin.categories.form.name_fr')"
                                    :value="old('name', $category->name)"
                                    :required="true"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.categories.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
