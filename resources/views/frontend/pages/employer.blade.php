@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
    <h3>{{$user->name}}</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li><a href="#">Companies</a> / </li>
            <li>{{$user->name}}</li>
        </ul>
    </div>
</div>


<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__company_wrapper">
            <div class="__company_box">
                <img class="__company_logo __profile_logo" src="{{upath('uploads/users/'.$user->profile_image)}}" />
            </div>
            <div class="__company_name">
                {{$user->name}}
            </div>
            <div class="__company_joined_date">
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
                <h5>About us</h5>
            </div>
            <div class="__about_wrapper">
                <div class="__editor_box">
                    {!! $profile->summary !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h5>Projects we've worked on</h5>
            </div>
            <div class="__job_requirements">
                <div class="__editor_box">
                    {!! $profile->description !!}
                </div>
            </div>
            <div class="__gap_30"></div>
            <div class="__job_list_title">
                <h3>Open jobs</h3>
              </div>
              <div id="ajax-job-list">
              </div>
              <div class="__gap_30"></div>
              <div class="__loading"></div>
              <div class="__gap_30"></div>

        </div>
    </div>
</div> <!-- CONTENT -->

@endsection

@section('custom-scripts')
<script>
var currentPage = "{{ request()->input('page', 1) }}";
var nextPage = parseInt(currentPage) + 1;
var totalPage = "0";
var loadNextPage = false;
function listJobs(page = 1){
var csrf = $('meta[name="csrf-token"]').attr("content");
var baseUrl = $('meta[name="base"]').attr("content");
var jobListAPI = baseUrl + "/api/jobs";
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": csrf,
    },
});

var data = {
    user_id: '{{$user->id}}',
    current_page: page,
    paginate: 30
};
if(totalPage == "0" || parseInt(currentPage) <= parseInt(totalPage)){
    $.ajax({
        url: jobListAPI,
        type: "POST",
        data: data,
        beforeSend: function () {
            $(".__loading").fadeIn(200);
        },
        success: function (response) {
            currentPage = response.jobs.current_page;
            totalPage = response.jobs.total;
            nextPage = parseInt(currentPage) + 1;
            if(response.jobs.next_page_url != null)
                loadNextPage = true;
            var jobs = response.jobs.data;

            var html = "";

            $.each(jobs, function(index, value) {
                html += "<div class='__list_wrapper'>"+
                            "<div class='__favorite_job'><i class='far fa-heart'></i></div>"+
                            "<h2>"+value.title+"</h2>" +
                            "<p class='__sub_title'>"+value.published_date+" by <strong><a href='"+baseUrl + "/company/"+ value.user_slug +"' target='_blank'>"+value.user_name+"</a></strong></p>" +
                            "<ul class='__job_features'>";
                if(parseInt(value.salary_max) < parseInt(value.salary_min))  
                {
                  html +=    "<li><i class='fas fa-pound-sign __right_10'></i> £"+value.salary_min_formatted+" per annum</li>";
                } else {
                  html +=    "<li><i class='fas fa-pound-sign __right_10'></i> £"+value.salary_min_formatted+" - £"+value.salary_max_formatted+" per annum</li>";
                } 
                  html +=   "<li><i class='fas fa-map-marker-alt __right_10'></i> "+value.location_name+"</li>" +
                            "<li><i class='fas fa-briefcase __right_10'></i>"+value.type+"</li>" +
                            "</ul>" +
                            "<p class='__job_summary'>"+value.summary+"</p>" +
                        "</div>"+
                        "";
            });


            $("#ajax-job-list").append(html);
        },
        error: function (xhr, status, error) {
            $(".__loading").fadeOut(200);
        },
        complete: function () {
            $(".__loading").fadeOut(200);
        },
    });
}

$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        console.log(currentPage, totalPage);
        if(loadNextPage)
        {
            listJobs(nextPage);
        }
    }
});

}
</script>
@endsection