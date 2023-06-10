@extends("frontend.layouts.master")

@section('content')
<div class="__home_search __reset_box">

    <h3>Reset Password</h3>
    <div class="__search_box" style="background:unset; height:auto;">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
 
            <div class="__about_wrapper">
                <div class="__profile_form __relative">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input id="email" type="email" class="__form_input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="__profile_form __relative">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-md-8">
                            <input id="password" type="password" class="__form_input @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="__profile_form __relative">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="cpassword">Confirm Password</label>
                        </div>
                        <div class="col-md-8">
                            <input id="cpassword" type="password" class="__form_input @error('confirm-password') is-invalid @enderror" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="__profile_form __relative">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                        <input type="submit" name="reset_password" class="__search_btn" value="Reset Password" />
                    </div>
                </div>
            </div>
      </form>
    </div>
  
    
  </div>

@endsection
