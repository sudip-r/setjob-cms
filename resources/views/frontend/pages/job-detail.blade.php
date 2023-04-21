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
            <div class="__left_box">
                <div class="__left_box_title">
                    <h3><i class="fa fa-angle-left __right_10"></i> Search results </h3>
                </div>
            </div>

            <div class="__company_box">
                <img class="__company_logo" src="{{mpath("front/assets/images/company.png")}}" />
                <p class="__job_posted">Posted 1 day ago</p>
                <a href="" class="__company_profile_link">View Profile</a>
            </div>

            <div class="__job_info">
                <ul class="__job_features">
                    <li><i class="fas fa-pound-sign __right_10"></i> £27,000 - £30,000 per annum</li>
                    <li><i class="fas fa-map-marker-alt __right_10"></i> London</li>
                    <li><i class="fas fa-briefcase __right_10"></i>Permanent, Full time</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
            <div class="__job_list_title">
                <h5>Job Requirements</h5>
            </div>
            <div class="__job_requirements">
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
                <h5>Skills Required</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
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
        </div>
    </div>
</div> <!-- CONTENT -->
@endsection