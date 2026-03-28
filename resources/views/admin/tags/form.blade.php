@extends('admin.layouts.master')

@php($isEdit = $tag->exists)

@section('title', $isEdit ? __('admin.tags.edit') : __('admin.tags.create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.tags.update', $tag) : route('admin.tags.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.tags.edit') : __('admin.tags.add')"
                    :subtitle="__('admin.tags.form.subtitle')"
                    :back-url="route('admin.tags.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="name"
                                    :label="__('admin.tags.form.name_fr')"
                                    :value="old('name', $tag->name)"
                                    :required="true"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.tags.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
