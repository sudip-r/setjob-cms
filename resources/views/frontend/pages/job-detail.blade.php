@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
    <h3>{{$job->title}}</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li><a href="{{route('jobs.list')}}">Jobs</a> / </li>
            <li>{{$job->title}}</li>
        </ul>
    </div>
</div>


<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__company_wrapper">
                <div class="__company_box">
                    @if($member)
                    <img class="__company_logo __profile_logo" src="{{upath('uploads/users/'.$user->profile_image)}}" />
                    @else 
                    <img class="__company_logo __profile_logo __blur" src="{{upath('uploads/users/default.png')}}" />
                    @endif
                </div>
                <div class="__company_name">
                @if($member)
                    <a href="{{route('employer.detail', ['user' => $user->slug])}}">{{$user->name}}</a>
                    @else 
                    <div class="__blur">****************</div>
                @endif
                </div>

                <div class="__company_joined_date">
                    Joined {{date("M d, Y", strtotime($user->created_at))}}
                </div>

                @if($member)
                <div class="__company_contact">
                    <a href="mailto:{{$user->email}}" class="__btn __email_btn"><i class="far fa-envelope __right_10"></i>Email</a>
                    <a href="tel:{{$user->contact}}" class="__btn __email_btn"><i class="fas fa-phone-alt __right_10"></i>Contact</a>
                </div>
                @endif

                @if($member)
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
                @endif
            </div>
            
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
            @if(!$member)
            <div class="__job_list_title">
                <h5>Become a member to view full detail</h5>
            </div>
            <div class="__gap_30"></div>
            @endif

            @if($job->description != "")
            <div class="__job_list_title">
                <h5>Job Description</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
                    {!! $job->description !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            @endif

            @if($job->required_skills)
            <div class="__job_list_title">
                <h5>Skills Required</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
                    {!! $job->required_skills !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            @endif

            @if($job->responsibilities)
            <div class="__job_list_title">
                <h5>Job Responsibilities</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
                    {!! $job->responsibilities !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            @endif
        </div>
    </div>
</div> <!-- CONTENT -->
@endsection