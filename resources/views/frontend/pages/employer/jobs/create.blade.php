@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
    <h3>Find your next employee!</h3>
  
    <div class="__breadcrumbs">
        <ul>
            <li><a href="#">Home</a> / </li>
            <li>Add Job</li>
        </ul>
    </div>
</div>
  
  
  <div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="__dashboard_links">
                <ul>
                    <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                    <li ><a href="{{route('user.profile')}}">Profile</a></li>
                    <li class="active">Posting Job</li>
                    <li><a href="{{route('logout')}}">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
          <form method="post" action="{{route('dashboard.jobs.store')}}" id="employer-create-job" >
          <input type="hidden" name="_token" value="{{csrf_token()}}" />
          <input type="hidden" name="id" value="{{$user->id}}" />
          <div class="__job_list_title __relative">
            <h3>Job Details</h3>
            <div class="__post_job_wrapper">
            <a class="__post_job" href="{{route('dashboard.jobs')}}">Cancel</a>
            </div>
          </div>
          <div class="__about_wrapper">
              
            <div class="__profile_form __relative">
                <label for="title">Job title</label>
                <div class="__err_abs" id="title-err"></div>
                <input type="text" name="title" id="title" class="__form_input" placeholder="Job title">
            </div>

            <div class="__profile_form __relative">
                <label for="type">Job Type</label>
                <div class="__err_abs" id="type-err"></div>
                <select name="type" id="type" class="__select_2">
                    <option value="Workshop">Workshop</option>
                    <option value="On Site">On Site</option>
                    <option value="Abroad">Abroad</option>
                    <option value="Various">Various</option>
                </select>
            </div>

            <div class="__profile_form __relative">
              <label for="salary-type">Salary Type</label>
              <div class="__err_abs" id="salary-type-err"></div>
              <select name="salary_type" id="salary-type" class="__select_2">
                  <option value="Per Annum">Per Annum</option>
                  <option value="Per Hour">Per Hour</option>
                  <option value="Freelance">Freelance</option>
              </select>
          </div>

          <div class="__profile_form __relative">
            {!! Form::label('categories',"Category") !!}
            {!! Form::select('category_id', $categories, null, ['class' => '__select_2', 'id' => 'categories']) !!}
          </div>

            <div class="__profile_form_half __relative">
            <label for="salary-min">Salary Range (Min)</label>
            <div class="__err_abs" id="salary-min-err"></div>
            <input type="number" name="salary_min" id="salary-min" class="__form_input" placeholder="Min Salary / Fixed Budget / Per Hour" />
            </div>

            <div class="__profile_form_half __ml_2per">
            <label for="salary-max">Salary Range (Max) <em>[Optional if fixed]</em></label>
            <div class="__err_abs" id="salary-max-err"></div>
            <input type="text" name="salary_max" id="salary-max" class="__form_input" placeholder="Not applicable for Fixed / Hourly basis" />
            </div>

            <div class="__clear"></div>

            <div class="__profile_form __relative">
                <label for="city">City <em>[Optional if same location as Company]</em></label>
                <div class="__err_abs" id="city-err"></div>
                <select id="city" class="__select_ajax" name="location">
                    <option value="0">Choose City</option>
                </select>
            </div>

            <div class="__profile_form __relative">
            <label for="summary">Summary</label>
            <div class="__err_abs" id="summary-err"></div>
            <textarea name="summary" id="summary" class="__form_input __textarea" placeholder="Short description of the job"></textarea>
            </div>

            <div class="__profile_form">
            <label for="description">Description <em>(Optional)</em></label>
            <textarea name="description" id="description" class="__form_input __textarea" placeholder="Full description of the job"></textarea>
            </div>
            
            <div class="__profile_form">
                <label for="deadline">Submission Deadline <em>(Optional)</em></label>
                <input type="text" name="deadline" id="deadline" class="__form_input" placeholder="Last apply date">
            </div>

            <div class="__profile_form">
                <label for="responsibilities">Responsibilities <em>(Optional)</em></label>
                <textarea name="responsibilities" id="responsibilities" class="__form_input __textarea" placeholder="Responsibilites of the job"></textarea>
            </div>

            <div class="__profile_form">
                <label for="requirements">Requirements <em>(Optional)</em></label>
                <textarea name="required_skills" id="requirements" class="__form_input __textarea" placeholder="Skills / Education requirements of the job"></textarea>
            </div>

            <div class="__profile_form">
                <div class="__save_btn_wrapper">
                    <input type="submit" id="create-job-btn" value="Save" class="__post_job" />
                </div>
                <div class="__gap_30"></div>
            </div>

            <div class="__gap_30"></div>
            <div class="__gap_30"></div>
          </div><!-- About wrapper -->
          </form>
        </div><!--Col 9 -->
    </div>
  </div> <!-- CONTENT -->


@endsection

@section('custom-scripts')
<script src="{!! asset('cms/plugins/flatpicker/flatpicker.min.js') !!}"></script>

<script !src="">
        var config = {
            enableTime: true,
            enableSeconds: false,
            minDate: "{{date('Y-m-d', strtotime('+1 day'))}}",
            dateFormat: "Y-m-d H:i",
        }
    $("#deadline").flatpickr(config);
</script>
<script src="{{asset('cms/plugins/ckeditor5/build/ckeditor.js')}}"></script>
<script>
ClassicEditor.create(document.querySelector('#responsibilities'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});

ClassicEditor.create(document.querySelector('#requirements'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});

ClassicEditor.create(document.querySelector('#description'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});
</script>
@endsection

@section('custom-styles')
<link href="{{asset('cms/plugins/ckeditor5/build/style.css')}}" rel="stylesheet" />
<link href="{!! asset('cms/plugins/flatpicker/flatpicker.min.css') !!}" rel="stylesheet" />
@endsection