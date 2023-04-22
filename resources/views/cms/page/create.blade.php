@extends('cms.layouts.master')

@section('content')

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <div class="content-header sty-one">
    <h1>Add Page</h1>
    <ol class="breadcrumb">
      <li><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
      <li><a href="{!! route('cms::pages.index') !!}"><i class="fa fa-angle-right"></i> Pages</a></li>
      <li><i class="fa fa-angle-right"></i> Add Page</li>
    </ol>
  </div>

  <div class="content"> 
    {!! Form::open(['route' => 'cms::pages.store','files'=>true, 'id' => 'post_form']) !!}
    <div class="row">
      @include('cms.page.form')
    </div>
    {!! Form::close() !!}
    <!-- /.row -->
  </div>

</div>

@endsection
@section('custom-styles')
<link href="{{asset('cms/vendors/ckeditor5/build/style.css')}}" rel="stylesheet" />

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

@section('custom-scripts')

<script !src="">
        var config = {
            enableTime: true,
            enableSeconds: false,
            // minDate: "1901-01-01",
            dateFormat: "Y-m-d H:i",
        }
    $("#datetimepicker").flatpickr(config);
</script>

<script src="{{ asset('cms/js/img.js') }}"></script>

<script>

$(document).ready(function(){
  $("#submit_btn").click(function(event){
    event.preventDefault();

    var img = $("#featured_image>img").attr("src");
    if(img != "" && img != undefined)
     img = img.replace("320X320_", "");

    $("#featured_image_field").val(img);

    var cover = $("#cover_image>img").attr("src");
    if(cover != "" && cover != undefined)
      cover = cover.replace("320X320_", "");

    $("#cover_image_field").val(cover);

    $("#post_form").submit();
  });
$(".select2").select2({
  width: '100%'
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


$("#coverImage").click(function() {
$("#imageLibrary").show();
coverImageType = true;
featuredImageType = false;
listMediaCover();
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
<script src="{{asset('cms/vendors/ckeditor5/build/ckeditor.js')}}"></script>

<script>


function AllowLinkTarget( editor ) {
// Allow the "linkTarget" attribute in the editor model.
editor.model.schema.extend( '$text', { allowAttributes: 'linkTarget' } );

// Tell the editor that the model "linkTarget" attribute converts into <a target="..."></a>
editor.conversion.for( 'downcast' ).attributeToElement( {
  model: 'linkTarget',
  view: ( attributeValue, { writer } ) => {
      const linkElement = writer.createAttributeElement( 'a', { target: attributeValue }, { priority: 5 } );
      writer.setCustomProperty( 'link', true, linkElement );

      return linkElement;
  },
  converterPriority: 'low'
} );

// Tell the editor that <a target="..."></a> converts into the "linkTarget" attribute in the model.
editor.conversion.for( 'upcast' ).attributeToAttribute( {
  view: {
      name: 'a',
      key: 'target'
  },
  model: 'linkTarget',
  converterPriority: 'low'
} );
}

function ConvertDivAttributes( editor ) {
// Allow <div> elements in the model.
editor.model.schema.register( 'div', {
  allowWhere: '$block',
  allowContentOf: '$root'
} );

// Allow <div> elements in the model to have all attributes.
editor.model.schema.addAttributeCheck( context => {
  if ( context.endsWith( 'div' ) ) {
      return true;
  }
} );

// The view-to-model converter converting a view <div> with all its attributes to the model.
editor.conversion.for( 'upcast' ).elementToElement( {
  view: 'div',
  model: ( viewElement, { writer: modelWriter } ) => {
      return modelWriter.createElement( 'div', viewElement.getAttributes() );
  }
} );

// The model-to-view converter for the <div> element (attributes are converted separately).
editor.conversion.for( 'downcast' ).elementToElement( {
  model: 'div',
  view: 'div'
} );

// The model-to-view converter for <div> attributes.
// Note that a lower-level, event-based API is used here.
editor.conversion.for( 'downcast' ).add( dispatcher => {
  dispatcher.on( 'attribute', ( evt, data, conversionApi ) => {
      // Convert <div> attributes only.
      if ( data.item.name != 'div' ) {
          return;
      }

      const viewWriter = conversionApi.writer;
      const viewDiv = conversionApi.mapper.toViewElement( data.item );

      // In the model-to-view conversion we convert changes.
      // An attribute can be added or removed or changed.
      // The below code handles all 3 cases.
      if ( data.attributeNewValue ) {
          viewWriter.setAttribute( data.attributeKey, data.attributeNewValue, viewDiv );
      } else {
          viewWriter.removeAttribute( data.attributeKey, viewDiv );
      }
  } );
} );
}

/**
* A plugin that converts custom attributes for elements that are wrapped in <figure> in the view.
*/
class CustomFigureAttributes {
/**
* Plugin's constructor - receives an editor instance on creation.
*/
constructor( editor ) {
  // Save reference to the editor.
  this.editor = editor;
}

/**
* Sets the conversion up and extends the table & image features schema.
*
* Schema extending must be done in the "afterInit()" call because plugins define their schema in "init()".
*/
afterInit() {
  const editor = this.editor;

  // Define on which elements the CSS classes should be preserved:
  setupCustomClassConversion( 'img', 'imageBlock', editor );
  setupCustomClassConversion( 'img', 'imageInline', editor );
  setupCustomClassConversion( 'table', 'table', editor );

  editor.conversion.for( 'upcast' ).add( upcastCustomClasses( 'figure' ), { priority: 'low' } );

}
}

/**
* Sets up a conversion that preserves classes on <img> and <table> elements.
*/
function setupCustomClassConversion( viewElementName, modelElementName, editor ) {
// The 'customClass' attribute stores custom classes from the data in the model so that schema definitions allow this attribute.
editor.model.schema.extend( modelElementName, { allowAttributes: [ 'customClass' ] } );

// Defines upcast converters for the <img> and <table> elements with a "low" priority so they are run after the default converters.
editor.conversion.for( 'upcast' ).add( upcastCustomClasses( viewElementName ), { priority: 'low' } );

// Defines downcast converters for a model element with a "low" priority so they are run after the default converters.
// Use `downcastCustomClassesToFigure` if you want to keep your classes on <figure> element or `downcastCustomClassesToChild`
// if you would like to keep your classes on a <figure> child element, i.e. <img>.
editor.conversion.for( 'downcast' ).add( downcastCustomClassesToFigure( modelElementName ), { priority: 'low' } );
// editor.conversion.for( 'downcast' ).add( downcastCustomClassesToChild( viewElementName, modelElementName ), { priority: 'low' } );
}

/**
* Sets up a conversion for a custom attribute on the view elements contained inside a <figure>.
*
* This method:
* - Adds proper schema rules.
* - Adds an upcast converter.
* - Adds a downcast converter.
*/
function setupCustomAttributeConversion( viewElementName, modelElementName, viewAttribute, editor ) {
// Extends the schema to store an attribute in the model.
const modelAttribute = `custom${ viewAttribute }`;

editor.model.schema.extend( modelElementName, { allowAttributes: [ modelAttribute ] } );

editor.conversion.for( 'upcast' ).add( upcastAttribute( viewElementName, viewAttribute, modelAttribute ) );
editor.conversion.for( 'downcast' ).add( downcastAttribute( modelElementName, viewElementName, viewAttribute, modelAttribute ) );
}

/**
* Creates an upcast converter that will pass all classes from the view element to the model element.
*/
function upcastCustomClasses( elementName ) {
return dispatcher => dispatcher.on( `element:${ elementName }`, ( evt, data, conversionApi ) => {
  const viewItem = data.viewItem;
  const modelRange = data.modelRange;

  const modelElement = modelRange && modelRange.start.nodeAfter;

  if ( !modelElement ) {
      return;
  }

  // The upcast conversion picks up classes from the base element and from the <figure> element so it should be extensible.
  const currentAttributeValue = modelElement.getAttribute( 'customClass' ) || [];

  currentAttributeValue.push( ...viewItem.getClassNames() );

  conversionApi.writer.setAttribute( 'customClass', currentAttributeValue, modelElement );
} );
}

/**
* Creates a downcast converter that adds classes defined in the `customClass` attribute to a <figure> element.
*
* This converter expects that the view element is nested in a <figure> element.
*/
function downcastCustomClassesToFigure( modelElementName ) {
return dispatcher => dispatcher.on( `insert:${ modelElementName }`, ( evt, data, conversionApi ) => {
  const modelElement = data.item;

  const viewFigure = conversionApi.mapper.toViewElement( modelElement );

  if ( !viewFigure ) {
      return;
  }

  // The code below assumes that classes are set on the <figure> element.
  conversionApi.writer.addClass( modelElement.getAttribute( 'customClass' ), viewFigure );
} );
}

/**
* Creates a downcast converter that adds classes defined in the `customClass` attribute to a <figure> child element.
*
* This converter expects that the view element is nested in a <figure> element.
*/
function downcastCustomClassesToChild( viewElementName, modelElementName ) {
return dispatcher => dispatcher.on( `insert:${ modelElementName }`, ( evt, data, conversionApi ) => {
  const modelElement = data.item;

  const viewFigure = conversionApi.mapper.toViewElement( modelElement );

  if ( !viewFigure ) {
      return;
  }

  // The code below assumes that classes are set on the element inside the <figure>.
  const viewElement = findViewChild( viewFigure, viewElementName, conversionApi );

  conversionApi.writer.addClass( modelElement.getAttribute( 'customClass' ), viewElement );
} );
}

/**
* Helper method that searches for a given view element in all children of the model element.
*
* @param {module:engine/view/item~Item} viewElement
* @param {String} viewElementName
* @param {module:engine/conversion/downcastdispatcher~DowncastConversionApi} conversionApi
* @return {module:engine/view/item~Item}
*/
function findViewChild( viewElement, viewElementName, conversionApi ) {
const viewChildren = Array.from( conversionApi.writer.createRangeIn( viewElement ).getItems() );

return viewChildren.find( item => item.is( 'element', viewElementName ) );
}

/**
* Returns the custom attribute upcast converter.
*/
function upcastAttribute( viewElementName, viewAttribute, modelAttribute ) {
return dispatcher => dispatcher.on( `element:${ viewElementName }`, ( evt, data, conversionApi ) => {
  const viewItem = data.viewItem;
  const modelRange = data.modelRange;

  const modelElement = modelRange && modelRange.start.nodeAfter;

  if ( !modelElement ) {
      return;
  }

  conversionApi.writer.setAttribute( modelAttribute, viewItem.getAttribute( viewAttribute ), modelElement );
} );
}

/**
* Returns the custom attribute downcast converter.
*/
function downcastAttribute( modelElementName, viewElementName, viewAttribute, modelAttribute ) {
return dispatcher => dispatcher.on( `insert:${ modelElementName }`, ( evt, data, conversionApi ) => {
  const modelElement = data.item;

  const viewFigure = conversionApi.mapper.toViewElement( modelElement );
  const viewElement = findViewChild( viewFigure, viewElementName, conversionApi );

  if ( !viewElement ) {
      return;
  }

  conversionApi.writer.setAttribute( viewAttribute, modelElement.getAttribute( modelAttribute ), viewElement );
} );
}
</script>
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
},
extraPlugins: [ AllowLinkTarget, ConvertDivAttributes, CustomFigureAttributes  ]
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