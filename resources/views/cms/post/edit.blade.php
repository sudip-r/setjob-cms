@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Post</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{!! route('cms::posts.index') !!}">Posts</a></li>
          <li class="breadcrumb-item active">Edit Post</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  {!! Form::model($post,['route' => ['cms::posts.update', $post->id], 'method' => 'patch','files'=>true, 'id' => 'post_form']) !!}
  <div class="row">
    @include('cms.post.form')
  </div>
  {!! Form::close() !!}
  <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('custom-scripts')
<script src="{!! asset('cms/plugins/flatpicker/flatpicker.min.js') !!}"></script>

<script>
  $('#post-name').keyup(function() {
    var title = $('#post-name').val();
    slug = title.replace(/\ /g, '-').toLowerCase();
    $('#slug').val(slug);
  });
</script>
<script !src="">
  var config = {
      enableTime: true,
      enableSeconds: false,
      // minDate: "1901-01-01",
      dateFormat: "Y-m-d H:i",
  }
$("#datetimepicker").flatpickr(config);
</script>

<script src="{{ asset('cms/dist/js/img.js') }}"></script>

<script>

$(document).ready(function(){
  $(".select2").select2({
  width: '100%'
});
$("#submit_btn").click(function(event){
  event.preventDefault();

  var img = $("#featured_image>img").attr("src");
  if(img != "" && img != undefined)
    img = img.replace("320X320_", "");

  $("#featured_image_field").val(img);

  $("#post_form").submit();
});
var video = $("#featured-video").val();
var image = $("#featured_image_field").val();
var featuredImageType = true;
$(".featured_video").html(video);
if(image !== "")
$('#featured_image>img').attr("src", image);
});
$("#featured-video").change(function(){
$(".featured_video").html($(this).val());
});

var data = [{id:''}];

// Set the value, creating a new option if necessary
if ($('#tags').find("option[value='" + data.id + "']").length) {
$('#tags').val(data.id).trigger('change');
} 
$("#addMedia").click(function() {
$("#imageLibrary").show();
featuredImageType = false;
listMediaEditor();

return false;
});

$("#blockquote").click(function(){
$("#blockQuoteModal").show();
return false;
});
$(".close-bq").click(function() {
$("#blockQuoteModal").hide();
});

$("#insert-bq").click(function(){
var content = $("#bq-content").val();
var align = $('input[name="r1"]:checked').val();

if(content !== "")
{
content = "<figure class='table "+align+"'><table><tbody><tr><td><blockquote>"+content+"</blockquote></td></tr></tbody></table></figure>";

const viewFragment = editor.data.processor.toView( content );
const modelFragment = editor.data.toModel( viewFragment );

editor.model.insertContent( modelFragment, editor.model.document.selection, 'end' );

$("#bq-content").val("");
$("#blockQuoteModal").hide();

}
});

$(".selectImageBtn").click(function() {
$("#imageLibrary").hide();
var image = $(".image-border>img").attr("src");
$("#featured_image").html("<img src='" + image + "'/>");
});

$("#featuredImage").click(function() {
$("#imageLibrary").show();
featuredImageType = true;
listMedia();
return false;
});

$(".close-library").click(function() {
$("#imageLibrary").hide();
});

$("#upload-box").click(function() {
$(".library-content").hide();
$(".upload-content").show();

$("#upload-box").addClass("active");
$("#library-box").removeClass("active");
});

$("#library-box").click(function() {
$(".library-content").show();
$(".upload-content").hide();

$("#upload-box").removeClass("active");
$("#library-box").addClass("active");

if(featuredImageType)
  listMedia();
else
  listMediaEditor();
});

$("#upload-all-files").click(function() {
$('#mediaFiles').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
console.log("Upload started");
return false;
});
$(function() {
$('#mediaFiles').FancyFileUpload({
added: function(e, data) {
  // It is okay to simulate clicking the start upload button.
  this.find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
},
url: '{{route("cms::uploadFiles")}}',
edit: false,
params: {
  _token: $("meta[name='csrf-token']").attr("content")
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