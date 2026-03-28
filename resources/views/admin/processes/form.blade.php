@extends('admin.layouts.master')

@php($isEdit = $process->exists)

@section('title', $isEdit ? __('admin.processes.form.title_edit') : __('admin.processes.form.title_create'))

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.processes.update', $process) : route('admin.processes.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.processes.form.title_edit') : __('admin.processes.form.title_create')"
                    :subtitle="__('admin.processes.form.subtitle')"
                    :back-url="route('admin.processes.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <x-admin.section-title
                                            class="mb-3"
                                            icon="fa fa-language"
                                            :title="__('admin.common.locale.fr')"/>
                                        <x-admin.text-input
                                            name="title"
                                            :label="__('admin.processes.form.fields.title_fr')"
                                            :value="old('title', $form['title'])"
                                            :required="true"/>
                                        <x-admin.textarea
                                            name="description"
                                            :label="__('admin.processes.form.fields.description_fr')"
                                            :value="old('description', $form['description'])"
                                            :rows="5"
                                            :floating="true"
                                            :required="true"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-admin.section-title
                                            class="mb-3"
                                            icon="fa fa-language"
                                            :title="__('admin.common.locale.en')"/>
                                        <x-admin.text-input
                                            name="en[title]"
                                            :label="__('admin.processes.form.fields.title_en')"
                                            :value="old('en.title', $form['en']['title'] ?? '')"/>
                                        <x-admin.textarea
                                            name="en[description]"
                                            :label="__('admin.processes.form.fields.description_en')"
                                            :value="old('en.description', $form['en']['description'] ?? '')"
                                            :rows="5"
                                            :floating="true"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.common.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
