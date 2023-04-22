@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
  <h3>Dashboard</h3>

  <div class="__breadcrumbs">
      <ul>
          <li><a href="#">Home</a> / </li>
          <li>Dashboard</li>
      </ul>
  </div>
</div>


<div class="__main_content container">
  <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="__dashboard_links">
              <ul>
                  <li class="active">Dashboard</li>
                  <li><a href="{{route('user.profile')}}">Profile</a></li>
                  <li><a href="{{route('dashboard.jobs')}}">Jobs</a></li>
                  <li><a href="{{route('logout')}}">Logout</a></li>
              </ul>
          </div>
          
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title __relative">
          <h3>Welcome {{$user->name}}!</h3>
          <div class="__post_job_wrapper">
          <a class="__post_job" href="{{route('dashboard.jobs.create')}}">Post a Job</a>
          </div>
        </div>
        <div class="__about_wrapper">
          <div class="__editor_box">
            <br>
            <p>Ready to find your next potential employee?</p>
            <br>
            <p>To get started, simply edit your profile. Provide as much relevant information as you can about the job 
              i.e: Rate, how long the job will be, pay, contact info etc.</p>
          </div>
        </div>
          <div class="__gap_30"></div>
          <div class="__job_list_title">
            <h3>Posted Jobs</h3>
          </div>
          @if($jobs->count() > 0)
          @foreach($jobs as $job)
          <div class="__list_wrapper">
            {{-- <div class="__favorite_job"><i class="far fa-heart"></i></div> --}}
            <h2>{{$job->title}}</h2>
            <p class="__sub_title">{{date('M d, Y', strtotime($job->published_on))}} by <strong><a href="">{{$job->user()->name}}</a></strong></p>
            <ul class="__job_features">
              @if($job->salary_max == "")
              <li><i class="fas fa-pound-sign __right_10"></i> £{{$job->salary_min}} per annum</li>
              @else 
              <li><i class="fas fa-pound-sign __right_10"></i> £{{$job->salary_min}} - £{{$job->salary_max}} per annum</li>
              @endif
              <li><i class="fas fa-map-marker-alt __right_10"></i> {{$job->city()->name}}</li>
              <li><i class="fas fa-briefcase __right_10"></i>{{$job->type}}</li>
            </ul>
            <p class="__job_summary">{{$job->summary}}</p>
          </div><!-- List Wrapper--> 
          @endforeach

          <div class="__pagination">
            {!! $jobs->appends($_GET)->links() !!}
          </div>

          @else
          <div class="__list_wrapper">
            Looks like you haven't posted any jobs yet.
          </div>
          @endif

          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          
      </div>
  </div>
</div> <!-- CONTENT -->
@endsection