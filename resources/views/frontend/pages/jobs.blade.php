@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>Search jobs</h3>

    <div class="__search_box">
      <div class="__search_icon">
        <img src="{{asset("front/assets/images/search_icon.png")}}" />
      </div>
      <div class="__search_field">
        <input type="text" name="search_text" id="search-text" class="__search_text" value="{{$search == ""?" ":$search}}"
          placeholder="Scenic Artist in London" autocomplete="{{$search == ""?" ":$search}}" />
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
            <p><input type="checkbox" id="filter-workshop" class="__form_checkbox" /> <label
                for="filter-workshop">Workshop</label></p>
            <p><input type="checkbox" id="filter-on-site" class="__form_checkbox" /> <label
                for="filter-on-site">On site</label></p>
            <p><input type="checkbox" id="filter-abroad" class="__form_checkbox" /> <label
                for="filter-abroad">Abroad</label></p>
            <p><input type="checkbox" id="filter-various" class="__form_checkbox" /> <label
                for="filter-various">Various</label></p>
          </div>
          <div class="__filter_type">
            <h4>Salary Range <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
            <label for="salary-range" class="form-label" id="salary-range-label">£{{number_format($min, 0)}} - £{{number_format($max, 0)}}</label>
            </p>
            
            <p>
             <label for="salary-range" class="form-label __hidden" id="salary-selected"></label>
              <input type="range" class="form-range" min="{{$min}}" max="{{$max}}" step="1000" id="salary-range"
                value="10000">
            </p>
          </div>
          <div class="__filter_type">
            <h4>Location <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <select id="filter-location" class="__select_ajax">
                <option value="0">Any</option>
              </select>
            </p>
            <h4>Company <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <select id="filter-company" class="__select_ajax_employers">
                <option value="0">Any</option>
              </select>
            </p>

            <h4>Category <i class="fa fa-spinner fa-spin __filter_loading"></i></h4>
            <p>
              <select id="filter-category" class="__select_category __select_2">
                <option value="0">Job Category</option>
                @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
              </select>
            </p>
          </div>
          <div class="__filter_type">
            <h5>Applied filters</h5>
            <div class="__clear_filter">Clear All</div>
            <div class="__filters">
            </div>
            <div class="__clear"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title">
          <h5>Latest jobs</h5>
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
var firstPage = true;
var firstFilter = true;
var _global_filters = false;
var loadNextPage = true;
var finished = false;
var finishedMessage = 0;
var readyForNextBatch = true;
var search = "{{$search}}";
var filters = {
  type: {
    workshop:false,
    on_site:false,
    abroad:false,
    various:false
  },
  salary:{
    min:{{$min}},
    max:0
  },
  location:{
    id: "",
    name: ""
  },
  company:{
    id:"",
    name:""
  },
  category:{
    id:"",
    name:""
  }
};

function listFilters(){
 
  loadNextPage = true;
  finished = false;
  nextPage = currentPage = 1;
  finishedMessage = 0;
  
  $("#ajax-job-list").html("");
  $(".__loading").fadeIn(200);
  firstPage = true;
  
  $(".__filters").html("");
  if(filters.type.workshop)
  {
    $(".__filters").append("<span class='__filter_tags'>Workshop <span class='__remove_tag' alt='workshop'>X</span></span>");
  }
  if(filters.type.on_site)
  {
    $(".__filters").append("<span class='__filter_tags'>On site <span class='__remove_tag' alt='on_site'>X</span></span>");
  }
  if(filters.type.abroad)
  {
    $(".__filters").append("<span class='__filter_tags'>Abroad <span class='__remove_tag' alt='abroad'>X</span></span>");
  }
  if(filters.type.various)
  {
    $(".__filters").append("<span class='__filter_tags'>Various <span class='__remove_tag' alt='various'>X</span></span>");
  }

  if(filters.salary.max != 0)
  {
    $(".__filters").append("<span class='__filter_tags' id='salary'>Salary - £"+filters.salary.max+" <span class='__remove_tag' alt='salary'>X</span></span>");
  }

  if(filters.location.id != "")
  {
    $(".__filters").append("<span class='__filter_tags' id='location'>Location - "+filters.location.name+"<span class='__remove_tag' alt='location'>X</span></span>");
  }

  if(filters.company.id != "")
  {
    $(".__filters").append("<span class='__filter_tags' id='company'>"+filters.company.name+"<span class='__remove_tag' alt='company'>X</span></span>");
  }

  if(filters.category.id != "")
  {
    $(".__filters").append("<span class='__filter_tags' id='category'>"+filters.category.name+"<span class='__remove_tag' alt='category'>X</span></span>");
  }
  //Remove tags
  $(".__remove_tag").click(function(){
        var tag = $(this).attr("alt");
        switch(tag)
        {
            case "workshop":
                filters.type.workshop = false;
                $("#filter-workshop").prop('checked', false);
            break;
            case "on_site":
                filters.type.on_site = false;
                $("#filter-on-site").prop('checked', false);
            break;
            case "various":
                filters.type.various = false;
                $("#filter-various").prop('checked', false);
            break;
            case "abroad":
                filters.type.abroad = false;
                $("#filter-abroad").prop('checked', false);
            break;
            case "salary": 
              filters.salary.max = 0;
              $("#salary-range").val({{$min}});
              $("#salary-selected").html("");
              $("#salary-selected").fadeOut(200);
            break;
            case "location":
              filters.location.id = "";
              filters.location.name = "";
              $("#filter-location").val(0).trigger('change.select2');
              break;
            case "company":
              filters.company.id = "";
              filters.company.name = "";
              $("#filter-company").val(0).trigger('change.select2');
              break;
            case "category": 
              filters.category.id = "";
              filters.category.name = "";
              $("#filter-category").val(0).trigger('change.select2');
              break;

        }
        listFilters();
    });
  _global_filters = true;
  listJobs(true, nextPage);

}

function listJobs(_filters, page = 1){
var csrf = $('meta[name="csrf-token"]').attr("content");
var baseUrl = $('meta[name="base"]').attr("content");
var jobListAPI = baseUrl + "/api/jobs";
var conditions = null;

if(_filters)
{
  conditions = filters;
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": csrf,
    },
});

var data = {
    conditions:conditions,
    current_page: page,
    paginate: 10,
    search: search
};
if(readyForNextBatch && !finished && (totalPage == "0" || parseInt(currentPage) <= parseInt(totalPage))){
    $.ajax({
        url: jobListAPI,
        type: "POST",
        data: data,
        beforeSend: function () {
            $(".__loading").fadeIn(200);
            readyForNextBatch = false;
        },
        success: function (response) {
            if(response.jobs == null)
            {
              if(firstPage)
                $("#ajax-job-list").html("<div class='__list_wrapper'>Sorry! Currently, There are no job postings.</div>");

              if(!firstPage && finished){
                $("#ajax-job-list").append("<div class='__list_wrapper'>No more jobs.</div>");
                finishedMessage++;
              }
              $(".__loading").fadeOut(200);
              loadNextPage = false;
              finished = true;
            }
            else{
            firstPage = false;
            
            var jobs = response.jobs.data;
            currentPage = response.jobs.current_page;
            totalPage = response.jobs.total;
            nextPage = parseInt(currentPage) + 1;
            if(response.jobs.next_page_url != null)
                loadNextPage = true;
            var html = "";
            $.each(jobs, function(index, value) {
                html += "<div class='__list_wrapper __list_wrapper_jobs'>"+
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
                  html +=     "<li><i class='fas fa-map-marker-alt __right_10'></i> "+value.location_name+"</li>" +
                  "<li><i class='fas fa-bars __right_10'></i> "+value.category_name+"</li>" +
                            "<li><i class='fas fa-briefcase __right_10'></i>"+value.type+"</li>" +
                            "</ul>" +
                            "<p class='__job_summary'>"+value.summary+"</p>" +
                        "</div>"+
                        "";
            });
            $("#ajax-job-list").append(html);
          }
        },
        error: function (xhr, status, error) {
            $(".__loading").fadeOut(200);
        },
        complete: function () {
            $(".__loading").fadeOut(200);
            readyForNextBatch = true;
        },
    });
}

$(window).scroll(function() {
  setTimeout(function () {
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        if(loadNextPage)
        {
              console.log(_global_filters);
              listJobs(_global_filters, nextPage);
        }else{
          if(finished && finishedMessage == 0){
            $("#ajax-job-list").append("<div class='__list_wrapper'>No more jobs.</div>");
            finished = true;
            finishedMessage++;
          }
        }
    }
    }, 500);
});

}
</script>
@endsection