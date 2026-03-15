@extends('admin.layouts.master')

@section('title', 'Edit Citabic Profile')

@section('content')

    <x-breadcrumb item="CMS" active="Profile Edit"/>

    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Company Profile</h5>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr-content" type="button" role="tab" aria-controls="fr-content" aria-selected="true">French (Default)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="false">English</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="profileTabsContent">
                            <div class="tab-pane fade show active" id="fr-content" role="tabpanel" aria-labelledby="fr-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tagline (FR)</label>
                                            <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $form['tagline']) }}" required>
                                            @error('tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tagline (EN)</label>
                                            <input type="text" name="en[tagline]" class="form-control" value="{{ old('en.tagline', $form['en']['tagline'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Information System (EN)</label>
                                            <input type="text" name="en[information_system]" class="form-control" value="{{ old('en.information_system', $form['en']['information_system'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $form['name']) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $form['full_name']) }}" required>
                                    @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Legal Name</label>
                                    <input type="text" name="legal_name" class="form-control @error('legal_name') is-invalid @enderror" value="{{ old('legal_name', $form['legal_name']) }}" required>
                                    @error('legal_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $form['email']) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $form['phone']) }}" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Information System</label>
                                    <input type="text" name="information_system" class="form-control @error('information_system') is-invalid @enderror" value="{{ old('information_system', $form['information_system']) }}" required>
                                    @error('information_system') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Legal Form</label>
                                    <input type="text" name="legal_form" class="form-control @error('legal_form') is-invalid @enderror" value="{{ old('legal_form', $form['legal_form']) }}" required>
                                    @error('legal_form') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Capital</label>
                                    <input type="text" name="capital" class="form-control @error('capital') is-invalid @enderror" value="{{ old('capital', $form['capital']) }}" required>
                                    @error('capital') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ICE</label>
                                    <input type="text" name="ice" class="form-control @error('ice') is-invalid @enderror" value="{{ old('ice', $form['ice']) }}" required>
                                    @error('ice') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">RC</label>
                                    <input type="text" name="rc" class="form-control @error('rc') is-invalid @enderror" value="{{ old('rc', $form['rc']) }}" required>
                                    @error('rc') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Created At</label>
                                    <input type="text" name="company_created_at" class="form-control @error('company_created_at') is-invalid @enderror" value="{{ old('company_created_at', $form['company_created_at']) }}" required>
                                    @error('company_created_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $form['status']) }}" required>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Head Office</label>
                            <textarea name="head_office" class="form-control @error('head_office') is-invalid @enderror" rows="2" required>{{ old('head_office', $form['head_office']) }}</textarea>
                            @error('head_office') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hero Video Path</label>
                            <input type="text" name="hero_video_path" class="form-control @error('hero_video_path') is-invalid @enderror" value="{{ old('hero_video_path', $form['hero_video_path']) }}">
                            @error('hero_video_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Content Sections (One per line)</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="contentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="content-fr-tab" data-bs-toggle="tab" data-bs-target="#content-fr-content" type="button" role="tab" aria-controls="content-fr-content" aria-selected="true">French (Default)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="content-en-tab" data-bs-toggle="tab" data-bs-target="#content-en-content" type="button" role="tab" aria-controls="content-en-content" aria-selected="false">English</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="contentTabsContent">
                            <div class="tab-pane fade show active" id="content-fr-content" role="tabpanel" aria-labelledby="content-fr-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Intro</label>
                                            <textarea name="intro" class="form-control" rows="5">{{ old('intro', $form['intro']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mission</label>
                                            <textarea name="mission" class="form-control" rows="5">{{ old('mission', $form['mission']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Why Choose Us</label>
                                            <textarea name="why_choose_us" class="form-control" rows="5">{{ old('why_choose_us', $form['why_choose_us']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Market Context</label>
                                            <textarea name="market_context" class="form-control" rows="5">{{ old('market_context', $form['market_context']) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Certifications</label>
                                            <textarea name="certifications" class="form-control" rows="5">{{ old('certifications', $form['certifications']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Partnerships</label>
                                            <textarea name="partnerships" class="form-control" rows="5">{{ old('partnerships', $form['partnerships']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Compliance</label>
                                            <textarea name="compliance" class="form-control" rows="5">{{ old('compliance', $form['compliance']) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Organization</label>
                                            <textarea name="organization" class="form-control" rows="5">{{ old('organization', $form['organization']) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-en-content" role="tabpanel" aria-labelledby="content-en-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Intro (EN)</label>
                                            <textarea name="en[intro]" class="form-control" rows="5">{{ old('en.intro', $form['en']['intro'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mission (EN)</label>
                                            <textarea name="en[mission]" class="form-control" rows="5">{{ old('en.mission', $form['en']['mission'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Why Choose Us (EN)</label>
                                            <textarea name="en[why_choose_us]" class="form-control" rows="5">{{ old('en.why_choose_us', $form['en']['why_choose_us'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Market Context (EN)</label>
                                            <textarea name="en[market_context]" class="form-control" rows="5">{{ old('en.market_context', $form['en']['market_context'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Certifications (EN)</label>
                                            <textarea name="en[certifications]" class="form-control" rows="5">{{ old('en.certifications', $form['en']['certifications'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Partnerships (EN)</label>
                                            <textarea name="en[partnerships]" class="form-control" rows="5">{{ old('en.partnerships', $form['en']['partnerships'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Compliance (EN)</label>
                                            <textarea name="en[compliance]" class="form-control" rows="5">{{ old('en.compliance', $form['en']['compliance'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Organization (EN)</label>
                                            <textarea name="en[organization]" class="form-control" rows="5">{{ old('en.organization', $form['en']['organization'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
