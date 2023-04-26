@extends("frontend.layouts.master")

@section("content")
<div class="__home_search">
    <h1>We are Set Jobs</h1>

    <h3>Find the perfect job for you</h3>

    <div class="__search_box">
      <div class="__search_icon">
        <img src="{{asset('front/assets/images/search_icon.png')}}" />
      </div>
      <div class="__search_field">
        <input type="text" name="search_text" id="search-text" class="__search_text" placeholder="Scenic Artist in London" autocomplete="off" />
      </div>
      <div class="__search_btn_wrap">
        <input type="submit" name="search_btn" id="search-btn" class="__search_btn" value="Search" />
      </div>
    </div>

    <div class="__browse_jobs">
      <h4><a href="{{route('jobs.list')}}">Browse Jobs</a></h4>
    </div>
  </div>

  <div class="__content container-fluid">
      <div class="row">
        <div class="col-md-6 __white_bg"></div>
        <div class="col-md-6 __dark_bg"></div>
      </div>
  </div>

  <div class="__main_content container">
    <div class="__home_info">
      <div class="row">
        <div class="col-md-6 __content_white">
          <h2>Post jobs for your next potential hire</h2>
          <p>Fusce quis quam et enim porta elementum a eu augue. Nullam sit amet quam id justo congue vulputate at ut metus. Vestibulum 
            lacinia tempor turpis, eget accumsan sem interdum id.</p>
          <div class="__btn_bg_white_wrapper">
            @if(auth()->user() && auth()->user()->guard == "business")
            <a href="{{route('dashboard.jobs.create')}}" class="__btn_bg_white __btn">Post a Job</a>
            @else
            <a href="javascript:void(0);" class="__btn_bg_white __btn" @if(!auth()->user())id="go-to-post"@endif>Post a Job</a>
            @endif
          </div>
        </div>
        <div class="col-md-6 __content_dark">
          <h2>Become a member for only £1 a month!</h2>
          <p>Fusce quis quam et enim porta elementum a eu augue. Nullam sit amet quam id justo congue vulputate at ut metus. Vestibulum 
            lacinia tempor turpis, eget accumsan sem interdum id.</p>
          <div class="__btn_bg_black_wrapper">
            <a href="javascript:void(0);" class="__btn_bg_black" @if(!auth()->user())id="register-popup"@endif>Register Now</a>
          </div>
        </div>
      </div>
    </div>

    <div class="__clients">
      <div class="__clients_header">
        <h2>Clients we work with</h2>
      </div>
      <div class="owl-carousel owl-theme __carousel">
        <div class="item"> <img src="{{asset('front/assets/images/clients/1.png')}}" /> </div>
        <div class="item"> <img src="{{asset('front/assets/images/clients/2.png')}}" /> </div>
        <div class="item"> <img src="{{asset('front/assets/images/clients/3.png')}}" /> </div>
        <div class="item"> <img src="{{asset('front/assets/images/clients/5.png')}}" /> </div>
        <div class="item"> <img src="{{asset('front/assets/images/clients/6.png')}}" /> </div>
      </div>
    </div>
    
  </div>
@endsection