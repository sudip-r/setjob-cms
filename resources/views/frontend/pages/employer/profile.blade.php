@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>Scenic Artist</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="#">Home</a> / </li>
            <li><a href="#">Jobs</a> / </li>
            <li>Scenic Artist</li>
        </ul>
    </div>
</div>


<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__company_wrapper">
            <div class="__company_box">
                <img class="__company_logo __profile_logo" src="{{mpath('front/assets/images/company.png')}}" />
            </div>
            <div class="__company_name">
                HBO
            </div>
            <div class="__company_joined_date">
                Joined Sep 15, 2020
            </div>
            <div class="__company_contact">
                <a href="javascript:void(0);" class="__btn __email_btn"><i class="far fa-envelope __right_10"></i>Email</a>
                <a href="javascript:void(0);" class="__btn __email_btn"><i class="fas fa-phone-alt __right_10"></i>Contact</a>
            </div>
            <div class="__company_social __social">
                <ul>
                    <li><a href=""><img src="{{mpath('front/assets/images/linkedin_bk.png')}}" /></a></li>
                    <li><a href=""><img src="{{mpath('front/assets/images/twitter_bk.png')}}" /></a></li>
                    <li><a href=""><img src="{{mpath('front/assets/images/facebook_bk.png')}}" /></a></li>
                    <li><a href=""><img src="{{mpath('front/assets/images/instagram_bk.png')}}" /></a></li>
                </ul>
            </div>
            </div>
            
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
            <div class="__job_list_title">
                <h5>About us</h5>
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
                    <ul>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac gravida nulla, quis
                        luctus purus. <strong>Praesent nec sodales dolor</strong>. Praesent ut sodales lacus. Aliquam venenatis magna
                        interdum, pellentesque lectus tincidunt, mattis ante.</p>
                    <ol>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                    </ol>
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Projects we've worked on</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
                    <p><strong>Project Manager</strong></p>
                    <ul>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
                        <li>Donec maximus est ut ex ullamcorper pretium</li>
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
                <h3>Open jobs</h3>
              </div>
              <div class="__list_wrapper">
                <div class="__favorite_job"><i class="far fa-heart"></i></div>
                <h2>Scenic Artist</h2>
                <p class="__sub_title">Jan 20 by <strong><a href="">HBO</a></strong></p>
                <ul class="__job_features">
                  <li><i class="fas fa-pound-sign __right_10"></i> £27,000 - £30,000 per annum</li>
                  <li><i class="fas fa-map-marker-alt __right_10"></i> London</li>
                  <li><i class="fas fa-briefcase __right_10"></i>Permanent, Full time</li>
                </ul>
                <p class="__job_summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                  incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Maecenas interdum mi
                  non viverra mollis...</p>
              </div><!-- List Wrapper-->
              <div class="__list_wrapper">
                <div class="__favorite_job"><i class="far fa-heart"></i></div>
                <h2>Scenic Artist</h2>
                <p class="__sub_title">Jan 20 by <strong><a href="">HBO</a></strong></p>
                <ul class="__job_features">
                  <li><i class="fas fa-pound-sign __right_10"></i> £27,000 - £30,000 per annum</li>
                  <li><i class="fas fa-map-marker-alt __right_10"></i> London</li>
                  <li><i class="fas fa-briefcase __right_10"></i>Permanent, Full time</li>
                </ul>
                <p class="__job_summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                  incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Maecenas interdum mi
                  non viverra mollis...</p>
              </div><!-- List Wrapper-->
              <div class="__list_wrapper">
                <div class="__favorite_job"><i class="far fa-heart"></i></div>
                <h2>Scenic Artist</h2>
                <p class="__sub_title">Jan 20 by <strong><a href="">HBO</a></strong></p>
                <ul class="__job_features">
                  <li><i class="fas fa-pound-sign __right_10"></i> £27,000 - £30,000 per annum</li>
                  <li><i class="fas fa-map-marker-alt __right_10"></i> London</li>
                  <li><i class="fas fa-briefcase __right_10"></i>Permanent, Full time</li>
                </ul>
                <p class="__job_summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                  incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Maecenas interdum mi
                  non viverra mollis...</p>
              </div><!-- List Wrapper-->
            <div class="__gap_30"></div>

        </div>
    </div>
</div> <!-- CONTENT -->


@endsection