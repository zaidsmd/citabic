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
                        <x-admin.language-tabs id-prefix="process" class="mb-3"/>

                        <div class="tab-content" id="processTabsContent">
                            <div class="tab-pane fade show active" id="process-fr-content" role="tabpanel" aria-labelledby="process-fr-tab">
                                <div class="border rounded p-3">
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
                            </div>

                            <div class="tab-pane fade" id="process-en-content" role="tabpanel" aria-labelledby="process-en-tab">
                                <div class="border rounded p-3">
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

                            <div class="tab-pane fade" id="process-ar-content" role="tabpanel" aria-labelledby="process-ar-tab">
                                <div class="border rounded p-3" dir="rtl">
                                    <x-admin.text-input
                                        name="ar[title]"
                                        :label="__('admin.processes.form.fields.title_ar')"
                                        :value="old('ar.title', $form['ar']['title'] ?? '')"/>
                                    <x-admin.textarea
                                        name="ar[description]"
                                        :label="__('admin.processes.form.fields.description_ar')"
                                        :value="old('ar.description', $form['ar']['description'] ?? '')"
                                        :rows="5"
                                        :floating="true"/>
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
