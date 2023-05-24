<header>
    <div class="__logo_bar">
      <div class="__logo">
        <a href="{{route('home')}}"><img src="{{asset('front/assets/images/logo.png')}}?v1.1" /></a>
      </div>
      <div class="__nav_btn __icon_outside">
        <div class="__burger_icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      @if($user == null)
      <div class="__login_register">
        <div class="__login_wrapper">
          <a href="javascript:void(0);" class="__login_btn __btn" id="login-pop">Login</a>
        </div>
        <div class="__register_wrapper">
          <a href="javascript:void(0);" class="__register_btn __btn" id="register-pop">Sign Up</a>
        </div>
        <div class="__clear"></div>
      </div>
      @else 
      <div class="__profile_image">
        <img src="{{upath('uploads/users/'.$user->profile_image)}}" id="profile-image" />
        <div class="__profile_box_drop" id="profile-drop-box">
          <div class="__image_wrapper">
            <img src="{{upath('uploads/users/'.$user->profile_image)}}" />
          </div>

          <div class="__profile_name">
            Hi {{$user->name}}!
          </div>
          <hr />
          <div class="__profile_links">
            <ul>
              <li><a href="{{route('user.dashboard')}}"><i class="fas fa-columns"></i> Dashboard</a></li>
              <li><a href="{{route('user.profile')}}"><i class="fas fa-user"></i> Update Profile</a></li>
              <li><a href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </div>

        </div>
      </div>
      @endif
      <div class="__clear"></div>
    </div>
  </header>