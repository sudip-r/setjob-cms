@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
  <h3>Profile</h3>

  <div class="__breadcrumbs">
      <ul>
          <li><a href="{{route('home')}}">Home</a> / </li>
          <li>Profile</li>
      </ul>
  </div>
</div>


<div class="__main_content container">
  <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="__dashboard_links">
              <ul>
                  <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                  <li><a href="{{route('user.profile')}}">Profile</a></li>
                  <li><a href="{{route('dashboard.jobs')}}">Jobs</a></li>
                  <li class="active">Settings</li>
                  <li><a href="{{route('logout')}}">Logout</a></li>
              </ul>
          </div>
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title __relative">
            <form method="post" action="{{route('dashboard.employee.email.subscription')}}">
                {{csrf_field()}}
            <input type="hidden" name="user_id" value="{{$user->id}}" />
            <h3>Email Subscription</h3>
            <div class="__gap_30"></div>
            <h5>Job Categories</h5>
            <p>Select categories for which you would like to get job notifications</p>

                @foreach($categories as $category)
                <div class="form-group">
                    <input type="checkbox" class="__form_checkbox" name="category[]" value="{{$category->id}}" id="category-{{$category->id}}"
                    @if(in_array($category->id, $selectedCategory, true))
                    checked=""
                    @endif
                    />
                    <label for="category-{{$category->id}}">{{$category->category}}</label>
                </div>
                @endforeach
                <div class="__gap_30"></div>
                <div class="__gap_30"></div>
            <h5>Job Types</h5>
            <p>Select job types for which you would like to get job notifications</p>

                <div class="form-group">
                    <input type="checkbox" class="__form_checkbox" name="type[]" id="workshop" value="workshop"
                    @if(in_array("workshop", $selectedType))
                    checked=""
                    @endif />
                    <label for="workshop">Workshop</label>
                </div>

                <div class="form-group">
                    <input type="checkbox" class="__form_checkbox" name="type[]" id="on-site" value="on-site"
                    @if(in_array("on-site", $selectedType))
                    checked=""
                    @endif />
                    <label for="on-site">On Site</label>
                </div>

                <div class="form-group">
                    <input type="checkbox" class="__form_checkbox" name="type[]" id="abroad" value="abroad"
                    @if(in_array("abroad", $selectedType))
                    checked=""
                    @endif />
                    <label for="abroad">Abroad</label>
                </div>

                <div class="form-group">
                    <input type="checkbox" class="__form_checkbox" name="type[]" id="various" value="various"
                    @if(in_array("various", $selectedType))
                    checked=""
                    @endif />
                    <label for="various">Various</label>
                </div>
                <div class="__gap_30"></div>
                <div class="__gap_30"></div>
                <div class="__save_btn_wrapper">
                    <input type="submit" id="subscription-save-btn" value="Save" class="__post_job" />
                </div>
                
            </form>
          </div>
          <div class="__gap_30"></div>
                <div class="__gap_30"></div>
      </div>
     
  </div>
</div> <!-- CONTENT -->
@endsection

