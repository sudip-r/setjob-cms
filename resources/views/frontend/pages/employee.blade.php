@extends("frontend.layouts.master")

@section("content")
<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__company_wrapper">
            {{-- <div class="__profile_box">
                <img class="__company_logo __profile_img" src="{{upath("uploads/users/".$user->profile_image)}}" />
            </div> --}}
            <div class="__company_name">
                {{$user->name}}
            </div>
            @if($user->title != "")
            <div class="__company_joined_date __no_border">
                {{$user->title}}
            </div>
            @endif
            <div class="__profile_joined_date">
                Joined {{date("M d, Y", strtotime($user->created_at))}}
            </div>
            <div class="__company_contact">
                <a href="mailto:{{$user->email}}" class="__btn __email_btn"><i class="far fa-envelope __right_10"></i>Email</a>
                <a href="tel:{{$user->contact}}" class="__btn __email_btn"><i class="fas fa-phone-alt __right_10"></i>Contact</a>
            </div>
            <div class="__company_social __social">
                <ul>
                @if($profile->linkedin != "")
                    <li><a href="{{$profile->linkedin}}" target="_blank"><img src="{{mpath('front/assets/images/linkedin_bk.png')}}" /></a></li>
                @endif
                @if($profile->twitter != "")
                    <li><a href="{{$profile->twitter}}" target="_blank"><img src="{{mpath('front/assets/images/twitter_bk.png')}}" /></a></li>
                @endif
                @if($profile->facebook != "")
                    <li><a href="{{$profile->facebook}}" target="_blank"><img src="{{mpath('front/assets/images/facebook_bk.png')}}" /></a></li>
                @endif
                @if($profile->instagram != "")
                    <li><a href="{{$profile->instagram}}" target="_blank"><img src="{{mpath('front/assets/images/instagram_bk.png')}}" /></a></li>
                @endif
                </ul>
            </div>
            </div>
            
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
            <div class="__job_list_title">
                <h5>Introduction</h5>
            </div>
            <div class="__about_wrapper">
                <div class="__editor_box">
                    {!! $profile->summary !!}
                </div>
            </div>
            {{-- <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Experience</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    {!! $profile->description !!}                    
                </div>
                <div class="__gap_30"></div>
                <div class="__editor_box __job_wrapper">
                    
                </div>
            </div> --}}
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Qualifications</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    {!! $profile->map !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>CV</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    <span class="__downloads">
                    <a target="_blank" href="{{fpath('uploads/users/'.$profile->contact_person)}}"><img src="{{mpath("front/assets/images/pdf.png")}}" /></a><br>
                    CV
                    </span>
                    <div class="__clear"></div>
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__gap_30"></div>
        </div>
    </div>
    @if($profile->categories != "")
    <div class="row">
        <div class="col-md-12">
            <div class="__portfolio">
                <div class="__portfolio_header">
                    <h2>Portfolio</h2>
                </div>
                <div class="__portfolio_carousel owl-theme __carousel">
                    @foreach(json_decode($profile->categories) as $image)
                    <div class="item"> <img src="{{mpath("uploads/users/".$user->id."/".$image)}}" /> </div>
                    @endforeach
                  </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__gap_30"></div>
        </div>
    </div>
    @endif
</div> <!-- CONTENT -->
@endsection