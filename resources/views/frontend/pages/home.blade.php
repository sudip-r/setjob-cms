@extends("frontend.layouts.master")

@section("content")
<div class="__home_search">
    <h1>{{$home->title}}</h1>

    <h3>{{$home->sub_title}}</h3>

    <div class="__search_box">
      <div class="__search_icon">
        <img src="{{asset('front/assets/images/search_icon.png')}}" />
      </div>
      <div class="__search_field">
        <input type="text" name="search_text" id="search-text" class="__search_text" placeholder="" value="Search by Job Title" autocomplete="off" />
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
          <h2>{{$home->left_col_title}}</h2>
          <p>{!! $home->left_col_summary !!}</p>
          <div class="__btn_bg_white_wrapper">
            @if(auth()->user() && auth()->user()->guard == "business")
            <a href="{{route('dashboard.jobs.create')}}" class="__btn_bg_white __btn">{{$home->left_col_btn}}</a>
            @else
            <a href="javascript:void(0);" class="__btn_bg_white __btn" @if(!auth()->user())id="go-to-post"@endif>{{$home->left_col_btn}}</a>
            @endif
          </div>
        </div>
        <div class="col-md-6 __content_dark">
          <h2>{{$home->right_col_title}}</h2>
          <p>{!! $home->right_col_summary !!}</p>
          <div class="__btn_bg_black_wrapper">
            <a href="javascript:void(0);" class="__btn_bg_black" @if(!auth()->user())id="register-popup"@endif>{{$home->right_col_btn}}</a>
          </div>
        </div>
      </div>
    </div>

    @if($partners->count() > 0)
    <div class="__clients">
      <div class="__clients_header">
        <h2>Clients we work with</h2>
      </div>
      <div class="owl-carousel owl-theme __carousel">
        @foreach($partners as $partner)
          @if(strpos($partner->image, "default.png") === false)
            <div class="item">
              @if($partner->partner_link != "")
              <a href="{{$partner->partner_link}}" target="_blank">
              <img src="{{$partner->image}}" alt="{{$partner->partner_name}}" title="{{$partner->partner_name}}" />
              </a>
              @else 
              <img src="{{$partner->image}}" alt="{{$partner->partner_name}}" title="{{$partner->partner_name}}" />
              @endif
            </div>
          @endif
        @endforeach
      </div>
    </div>
    @endif
    
  </div>
@endsection