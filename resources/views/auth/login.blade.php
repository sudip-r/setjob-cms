@extends('cms.login')

@section('content')
<div class="login-box">
  <!-- /.login-logo -->
  <div class="__header_box">
    <div class="__login_box_header text-center">
      <a href="javascript:void(0);" class="h1"><b>Set</b>Jobs</a>
    </div>
      <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>
    <hr>
  </div>
  <div class="__login_box">
      <div class="__login_box_body">
    
      <form method="POST" action="{{ route('post.alter.login') }}">
        @csrf
        <div class="input-group mb-3">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
            @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>
        <div class="input-group mb-3">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="{{route('password.request')}}">{{ __('I forgot my password') }}</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <div class="__footer_box">
    <hr>
    {{-- <p class="__credits">Photo Credit: <a href="https://unsplash.com/@lycansu" target="_blank">unsplash.com/@lycansu</a></p> --}}
    <p class="__credits">Powered by: <a href="" target="_blank">alterCMS</a></p>
  </div>
</div>
<!-- /.login-box -->
@endsection
