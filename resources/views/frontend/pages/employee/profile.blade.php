@extends("frontend.layouts.master")

@section("content")
<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__company_wrapper">
            <div class="__profile_box">
                <img class="__company_logo __profile_img" src="{{upath("uploads/users/".$user->profile_image)}}" />
            </div>
            <div class="__company_name">
                {{$user->name}}
            </div>
            <div class="__company_joined_date __no_border">
                {{$user->summary ?? "Interior designer, Project manager"}}
            </div>
            <div class="__profile_joined_date">
                Joined {{date("M d, Y", strtotime($user->created_at))}}
            </div>
            <div class="__company_contact">
                <a href="javascript:void(0);" class="__btn __email_btn"><i class="far fa-envelope __right_10"></i>Email</a>
                <a href="javascript:void(0);" class="__btn __email_btn"><i class="fas fa-phone-alt __right_10"></i>Contact</a>
            </div>
            <div class="__company_social __social">
                <ul>
                    <li><a href=""><img src="{{mpath("front/assets/images/linkedin_bk.png")}}" /></a></li>
                    <li><a href=""><img src="{{mpath("front/assets/images/twitter_bk.png")}}" /></a></li>
                    <li><a href=""><img src="{{mpath("front/assets/images/facebook_bk.png")}}" /></a></li>
                    <li><a href=""><img src="{{mpath("front/assets/images/instagram_bk.png")}}" /></a></li>
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac gravida nulla, quis
                        luctus purus. Praesent nec sodales dolor. Praesent ut sodales lacus. Aliquam venenatis magna
                        interdum, pellentesque lectus tincidunt, mattis ante. Cras eget pellentesque leo. Donec nec
                        est laoreet, porta nibh in, pulvinar eros. Donec maximus est ut ex ullamcorper pretium.
                        Nullam dolor nisl, pharetra sollicitudin eros in, tempus facilisis ex. Pellentesque sit amet
                        metus sapien.
                        Praesent ac ipsum euismod, eleifend ipsum a, vehicula leo. Mauris vulputate purus nec enim
                        condimentum, at lobortis tortor imperdiet. Mauris iaculis leo ornare lacinia posuere.</p>
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Experience</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    <p class="__job_title"><strong><span class="__right_30">Project Manager</span> 2020 - 2022</strong></p>
                    <p class="__exp_company">at <strong>HBO</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                    <ul>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac gravida nulla, quis
                        luctus purus. <strong>Praesent nec sodales dolor</strong>. Praesent ut sodales lacus. Aliquam venenatis magna
                        interdum, pellentesque lectus tincidunt, mattis ante.</p>
                    
                </div>
                <div class="__gap_30"></div>
                <div class="__editor_box __job_wrapper">
                    <p class="__job_title"><strong><span class="__right_30">Interior Designer</span> 2018 - 2020</strong></p>
                    <p class="__exp_company">at <strong>Webifi</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                    <ul>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac gravida nulla, quis
                        luctus purus. <strong>Praesent nec sodales dolor</strong>. Praesent ut sodales lacus. Aliquam venenatis magna
                        interdum, pellentesque lectus tincidunt, mattis ante.</p>
                    
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Qualifications</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    <p class="__job_title"><strong><span class="__right_30">BFA in Interior Design, University of Lincoln</span> 2014 - 2018</strong></p>
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>CV</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box __job_wrapper">
                    <span class="__downloads">
                    <a href="javascript:void(0);"><img src="{{mpath("front/assets/images/pdf.png")}}" /></a><br>
                    CV
                    </span>
                    <span class="__downloads">
                        <a href="javascript:void(0);"><img src="{{mpath("front/assets/images/pdf.png")}}" /></a><br>
                        Cover letter
                    </span>
                    <div class="__clear"></div>
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__gap_30"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="__portfolio">
                <div class="__portfolio_header">
                    <h2>Portfolio</h2>
                </div>
                <div class="__portfolio_carousel owl-theme __carousel">
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/1.png")}}" /> </div>
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/2.png")}}" /> </div>
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/3.png")}}" /> </div>
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/4.png")}}" /> </div>
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/5.png")}}" /> </div>
                    <div class="item"> <img src="{{mpath("front/assets/images/portfolio/6.png")}}" /> </div>
                  </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__gap_30"></div>
        </div>
    </div>
</div> <!-- CONTENT -->
@endsection