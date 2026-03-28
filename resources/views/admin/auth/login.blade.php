@extends('admin.layouts.master-auth')

@section('title', 'Login')

@section('content')

    @include('admin.layouts/loader')
    <div class="auth-main">
      <div class="auth-wrapper v1">
        <div class="auth-form">
          <div class="card my-5">
            <div class="card-body">
            <form method="POST" action="{{ route('admin.login') }}">
              @csrf
              <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
              <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror"  id="floatingInput" name="email" placeholder="admin@citabic.com" />
                @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              </div>
              <div class="mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingInput1" placeholder="Password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" {{ old('remember') ? 'checked' : '' }} />
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
              </div>
              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
