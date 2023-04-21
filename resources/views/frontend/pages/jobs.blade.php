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
          <h5>Showing 34 jobs for Scenic Artist</h5>
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

        <div  class="__list_wrapper">
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

        <div  class="__list_wrapper">
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

        <div  class="__list_wrapper">
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

        <div  class="__list_wrapper">
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

        <div  class="__list_wrapper">
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
        <div class="__loading"></div>
        <div class="__gap_30"></div>

      </div>
    </div>
  </div> <!-- CONTENT -->


@endsection