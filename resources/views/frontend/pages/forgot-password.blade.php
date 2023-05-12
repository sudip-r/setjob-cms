@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>Forgot Password</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li>Forgot Password</li>
        </ul>
    </div>
</div>


<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('password.email') }}">
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
                 
                    <div class="row">
                      <!-- /.col -->
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
                      </div>
                      <!-- /.col -->
                    </div>
            </form>
            <div class="__gap_30"></div>
        </div>
    </div>
</div> <!-- CONTENT -->

@endsection