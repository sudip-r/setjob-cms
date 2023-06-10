@extends("frontend.layouts.master")

@section('content')

<div class="__home_search __reset_box">

  <h3>Reset Password</h3>
  <p>If your email is registered with us, we'll will send you the password reset link.</p>
  <div class="__search_box">
    <form method="POST" action="{{ route('password.email') }}" id="reset-password-form">
      @csrf
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <div class="__search_icon">
      <img src="{{asset('front/assets/images/email_icon.png')}}" id="reset-password" />
    </div>
    <div class="__search_field">
      <input type="email" name="email" id="email" class="__search_text" placeholder="" value="{{ old('email') }}" required autocomplete="email" autofocus />
    </div>
    <div class="__search_btn_wrap">
      <input type="submit" name="reset_btn" id="reset-btn" class="__search_btn" value="Send Link" />
    </div>
    </form>
  </div>

  
</div>


@endsection
