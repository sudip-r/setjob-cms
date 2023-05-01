@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Job</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{!! route('cms::jobs.index') !!}">Jobs</a></li>
          <li class="breadcrumb-item active">Edit Job</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  {!! Form::model($job,['route' => ['cms::jobs.update', $job->id], 'method' => 'patch','files'=>true, 'id' => 'job_form']) !!}
  <div class="row">
    @include('cms.job.form')
  </div>
  {!! Form::close() !!}
  <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('custom-scripts')
<script src="{!! asset('cms/plugins/flatpicker/flatpicker.min.js') !!}"></script>

<script>
  $('#job-name').keyup(function() {
    var title = $('#job-name').val();
    slug = title.replace(/\ /g, '-').toLowerCase();
    $('#slug').val(slug);
  });
</script>
<script !src="">
var config = {
            enableTime: true,
            enableSeconds: false,
            minDate: "1901-01-01",
            dateFormat: "Y-m-d H:i",
        }
        var deadlineConfig = {
            enableTime: true,
            enableSeconds: false,
            minDate: "{{date('Y-m-d', strtotime('+1 day'))}}",
            dateFormat: "Y-m-d H:i",
        }
    $("#datetimepicker").flatpickr(config);
    $("#deadline").flatpickr(deadlineConfig);
</script>


<script>

$(document).ready(function(){
  $(".select2").select2({
  width: '100%'
});
$("#submit_btn").click(function(event){
  event.preventDefault();
  $("#job_form").submit();
});
$(".__select_ajax").select2({
        width: "100%",
        height: "32px",
        minimumInputLength: 3, // Only load data after typing at least one character
        ajax: {
            url: "{{route('api.list.cities')}}",
            dataType: "json",
            delay: 250, // Wait 250 milliseconds before sending the request (to reduce server load)
            data: function (params) {
                return {
                    q: params.term, // The search term entered by the user
                    page: params.page, // The current page number
                };
            },
            processResults: function (data, params) {
                // Map the server response to the format expected by Select2
                var mappedData = $.map(data.cities.data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: mappedData,
                };
            },
            cache: true, // Cache the results to reduce server load
        },
  });

  $(".__select_ajax_employers").select2({
        width: "100%",
        height: "32px",
        minimumInputLength: 3, // Only load data after typing at least one character
        ajax: {
            url: "{{route('api.list.users')}}",
            dataType: "json",
            delay: 250, // Wait 250 milliseconds before sending the request (to reduce server load)
            data: function (params) {
                return {
                    q: params.term, // The search term entered by the user
                    page: params.page, // The current page number
                };
            },
            processResults: function (data, params) {
                // Map the server response to the format expected by Select2
                var mappedData = $.map(data.users.data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: mappedData,
                };
            },
            cache: true, // Cache the results to reduce server load
        },
    });
});

</script>
<script src="{{asset('cms/plugins/ckeditor5/build/ckeditor.js')}}"></script>

<script>
ClassicEditor.create(document.querySelector('#content'), {

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


ClassicEditor.create(document.querySelector('#required-skills'), {

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

</script>
@endsection

@section('custom-styles')
<link href="{{asset('cms/plugins/ckeditor5/build/style.css')}}" rel="stylesheet" />

<style>
#addMedia{
  margin:20px 0px;
}
#imageLibrary{
  background: #FFFFFF90;
  padding: 20px 60px 20px 60px;
}
#imageLibrary>.content{
  padding: 10px 20px;
  border: #CCC solid 1px;
  background: #FFFFFF;
}
.select{
  margin: 10px 0px 10px 0px;
}
.select>a{
  width:100%;
}
#featured_image>img{
  width:100%;
  margin-bottom: 30px;
}
.modal-header{
  background: #FFF;
  border: solid 1px #CCC;
}
</style>
@endsection