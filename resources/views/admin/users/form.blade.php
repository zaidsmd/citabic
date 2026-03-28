@extends('admin.layouts.master')

@php($isEdit = $user->exists)

@section('title', $isEdit ? __('admin.users.edit') : __('admin.users.create'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <x-admin.page-header
                    :title="$isEdit ? __('admin.users.edit') : __('admin.users.add')"
                    :subtitle="__('admin.users.form.subtitle')"
                    :back-url="route('admin.users.index')"
                    :back-label="__('admin.common.back_to_list')"/>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="name"
                                    :label="__('admin.users.columns.name')"
                                    :value="old('name', $user->name)"
                                    :required="true"/>
                            </div>
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="email"
                                    type="email"
                                    :label="__('admin.users.columns.email')"
                                    :value="old('email', $user->email)"
                                    :required="true"/>
                            </div>
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="password"
                                    type="password"
                                    :label="$isEdit ? __('admin.users.form.password_optional') : __('admin.users.form.password')"
                                    :required="!$isEdit"/>
                            </div>
                            <div class="col-lg-6">
                                <x-admin.text-input
                                    name="password_confirmation"
                                    type="password"
                                    :label="$isEdit ? __('admin.users.form.password_confirmation_optional') : __('admin.users.form.password_confirmation')"
                                    :required="!$isEdit"/>
                            </div>
                            <div class="col-lg-12">
                                @php($selectedRole = old('role', $user->roles->pluck('name')->first() ?? 'blog editor'))
                                <div class="form-floating mb-3">
                                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="" disabled>{{ __('admin.users.form.select_role') }}</option>
                                        @foreach($availableRoles as $role)
                                            <option value="{{ $role }}" @selected($selectedRole === $role)>
                                                {{ $role === 'admin' ? __('admin.users.roles.admin') : __('admin.users.roles.blog_editor') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="role">{{ __('admin.users.columns.role') }}</label>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('admin.users.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
