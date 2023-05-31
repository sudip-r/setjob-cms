@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
  <h3>Jobs</h3>

  <div class="__breadcrumbs">
      <ul>
          <li><a href="{{route('home')}}">Home</a> / </li>
          <li>Jobs</li>
      </ul>
  </div>
</div>


<div class="__main_content container">
  <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="__dashboard_links">
              <ul>
                  <li ><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                  <li><a href="{{route('user.profile')}}">Profile</a></li>
                  <li class="active"><a href="{{route('dashboard.jobs')}}">Jobs</a></li>
                  <li><a href="{{route('dashboard.employee.settings')}}">Settings</a></li>
                  <li><a href="{{route('logout')}}">Logout</a></li>
                </ul>
          </div>
          
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title __relative">
          <h3>Welcome {{$user->name}}!</h3>
          <div class="__post_job_wrapper">
          <a class="__post_job" href="{{route('jobs.list')}}">Find a Job</a>
          </div>
        </div>
        <div class="__about_wrapper">
          <div class="__editor_box">
            <br>
            <p>Here are all the jobs you've saved.</p>
            
          </div>
        </div>
          <div class="__gap_30"></div>
          <div class="__job_list_title">
            <h3>Saved Jobs</h3>
          </div>
          @if($jobs->count() > 0)
          @foreach($jobs as $job)
          <div class="__list_wrapper">
            @if($job->publish == "1")
            <div class="__job_publish_status __btn __unpublish_btn __toggle_btn" alt="{{$job->id}}"  data-bs-toggle="tooltip" data-placement="top" title="This job is currently published and is visible to other users."><i class="far fa-eye-slash"></i> Unpublish Job</div>
            @else 
            <div class="__job_publish_status __btn __publish_btn __toggle_btn" alt="{{$job->id}}"  data-bs-toggle="tooltip" data-placement="top" title="This job is currently not published and is not visible to other users."><i class="far fa-eye"></i> Publish Job</div>
            @endif
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

            <div class="__gap_30"></div>
            <ul class="__job_btns">
              <li><a href="{{route('dashboard.jobs.edit', ['id' => $job->id])}}" class="__btn __publish_btn">Edit Job</a></li>
              <li><a href="" class="__btn __publish_btn">View Job</a></li>
            </ul>
          </div><!-- List Wrapper--> 
          @endforeach

          <div class="__pagination">
            {!! $jobs->appends($_GET)->links() !!}
          </div>

          @else
          <div class="__list_wrapper">
            Looks like you haven't saved any jobs.
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

@section('custom-scripts')
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
@endsection