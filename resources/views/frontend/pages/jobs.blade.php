@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>Search jobs</h3>

    <div class="__search_box">
      <div class="__search_icon">
        <img src="{{asset("front/assets/images/search_icon.png")}}" />
      </div>
      <div class="__search_field">
        <input type="text" name="search_text" id="search-text" class="__search_text"
          placeholder="Scenic Artist in London" />
      </div>
      <div class="__search_btn_wrap">
        <input type="submit" name="search_btn" id="search-btn" class="__search_btn" value="Search" />
      </div>
    </div>
  </div>


  <div class="__main_content container">
    <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="__filter_box">
          <div class="__filter_box_title">
            <h3>Filter your search </h3>
          </div>
          <div class="__filter_type">
            <h4>Job type <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p><input type="checkbox" id="filter-full-time" class="__form_checkbox" /> <label
                for="filter-full-time">Full time</label></p>
            <p><input type="checkbox" id="filter-part-time" class="__form_checkbox" /> <label
                for="filter-part-time">Part time</label></p>
            <p><input type="checkbox" id="filter-freelance" class="__form_checkbox" /> <label
                for="filter-freelance">Freelance</label></p>
            <p><input type="checkbox" id="filter-contract" class="__form_checkbox" /> <label
                for="filter-contract">Contract</label></p>
          </div>
          <div class="__filter_type">
            <h4>Salary Range <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <label for="salary-range" class="form-label" id="salary-range-label">£10,000 - £10,000</label>
              <input type="range" class="form-range" min="10000" max="100000" step="1000" id="salary-range"
                value="10000">
            </p>
          </div>
          <div class="__filter_type">
            <h4>Location <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <select id="filter-location" class="__select_2">
                <option value="0">Any</option>
                <option value="1">London</option>
              </select>
            </p>
            <h4>Company <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <select id="filter-company" class="__select_2">
                <option value="0">Any</option>
                <option value="1">HBO</option>
              </select>
            </p>
          </div>
          <div class="__filter_type">
            <h5>Applied filters</h5>
            <div class="__clear_filter">Clear All</div>
            <span class="__filter_tags">Full Time <span class="__remove_tag">X</span></span>
            <span class="__filter_tags">Contract <span class="__remove_tag">X</span></span>
            <span class="__filter_tags">£10,000 - £100,000<span class="__remove_tag">X</span></span>
            <span class="__filter_tags">London <span class="__remove_tag">X</span></span>
            <span class="__filter_tags">HBO <span class="__remove_tag">X</span></span>
            <div class="__clear"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title">
          <h5>Lasted jobs</h5>
        </div>

        @if($jobs->count() > 0)
          @foreach($jobs as $job)
          <div class="__list_wrapper">
            <div class="__favorite_job"><i class="far fa-heart"></i></div>
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
        <div class="__loading"></div>
        <div class="__gap_30"></div>

      </div>
    </div>
  </div> <!-- CONTENT -->


@endsection