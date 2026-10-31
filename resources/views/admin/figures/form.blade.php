@extends('admin.layouts.master')

@php($isEdit = $figure->exists)

@section('title', $isEdit ? __('admin.figures.edit') : __('admin.figures.create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.figures.update', $figure) : route('admin.figures.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.figures.edit') : __('admin.figures.add')"
                    :subtitle="__('admin.figures.form.subtitle')"
                    :back-url="route('admin.figures.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <x-admin.text-input
                                    name="label"
                                    :label="__('admin.figures.label_fr')"
                                    :value="old('label', $form['label'])"
                                    :required="true"/>
                            </div>
                            <div class="col-lg-4">
                                <x-admin.text-input
                                    name="en[label]"
                                    :label="__('admin.figures.label_en')"
                                    :value="old('en.label', $form['en']['label'] ?? '')"/>
                            </div>
                            <div class="col-lg-4" dir="rtl">
                                <x-admin.text-input
                                    name="ar[label]"
                                    :label="__('admin.figures.label_ar')"
                                    :value="old('ar.label', $form['ar']['label'] ?? '')"/>
                            </div>
                            <div class="col-lg-12">
                                <x-admin.text-input
                                    name="value"
                                    :label="__('admin.figures.value')"
                                    :value="old('value', $form['value'])"
                                    :required="true"/>
                                <small class="text-muted">{{ __('admin.figures.form.value_help') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.figures.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
