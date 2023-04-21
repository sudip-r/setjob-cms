// .modal-box
$modalBox = $("#modal-box");
$("[data-target=openModal]").each(function() {
  $("[data-target=openModal]").on("click", function() {
    $modalBox
      .fadeIn("slow")
      .find(".modal-box-body")
      .fadeIn("slow")
      .animate({ opacity: "1" }, "500");
  });
});

$(".modal-close").click(function() {
  $modalBox.find(".modal-box-body").fadeOut("slow");
  $modalBox.fadeOut("slow");
});

$(window).click(function() {
  var target = $(event.target);
  if (target.is("#modal-box")) {
    target.find(".modal-box-body").fadeOut("slow");
    target.fadeOut("slow");
  }
});

// preview image in detail image section
function previewImage($x) {
  $(".media-detail-image")
    .html()
    .replace($x);
}

var featuredImageType = true; //true for featured image, false for editor images
var coverImageType = false; //true for cover image, false for editor images
var editorInstance = "editor";
var creditsLogoType = false;
var creditsImageType = false;
//get image in detail-image box
$(document).on("click", ".image-box", function(event) {
  if(featuredImageType || coverImageType)
    $(".image-box").removeClass("image-border");
  $id = $(this)
    .find("img")
    .attr("id");
  $img = $("#" + $id).attr("src");
  $img = $img.replace("585X486_", "");
  $title = $(this)
    .find("img")
    .attr("title");
  $uploaded_on = $(this)
    .find("img")
    .attr("data-uploaded");
  $attributes = $(this)
    .find("img")
    .attr("alt");
  $caption = $(this)
    .find("img")
    .attr("data-caption");
  $image_id = $(this)
    .find("img")
    .attr("data-id");
    var size = $(this)
        .find("img")
        .attr("data-size");

  $(this).addClass("image-border");
  $(".select").show();
  
  var fImgArr = $img.split("/");
  var fImg = fImgArr[fImgArr.length - 1];


  if(featuredImageType || creditsLogoType || creditsImageType)
  {
    $(".detail-box").html(
      `
                      <div class="col-sm-12 col-md-12 col-lg-12 media-detail-image">
                      <img src= "` +
        $img +
        `" alt="#" />
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 image-detail">
                      <div class="select"><a href="javascript:void(0);" class="btn btn-success selectImageBtn">Select</a></div>
                      </div>
                      <div class="col-12 image-update">
                      
                        <div class="form">
                          <div class="form-group">
                            <div class="form-single">
                              <label for="title" class="form-label">Title</label>
                              <input type="text" class="form-control" autocomplete="off" id="caption" name="caption" value ="` +
        $caption +
        `" placeholder="Enter caption">
                            </div>
                          </div>
                          <a href="javascript:void(0);" onclick="updateMedia($image_id)" class="button btn btn-primary green-btn narrow-btn">Update</a>
  
                          <a href="javascript:void(0);" onclick="deleteMedia($image_id)" class="button btn-danger btn narrow-btn delete-img" data-id="` +
                          $image_id +
                          `" >Delete</a>
                        </div>
                      
                      </div>
  
                      <script>
                      $(".selectImageBtn").click(function(){
                        $("#imageLibrary").hide();
                      
                        var image = $(".image-border>img").attr("src");
                        image = image.replace("585X486_", "");
                        if(featuredImageType)
                          $("#featured_image").html("<img src='"+image+"'/>");
                        if(creditsLogoType)
                          $("#credits_logo").html("<img src='"+image+"'/>");
                        if(creditsImageType)
                          $("#credits_image").html("<img src='"+image+"'/>");
                      });
                      </script>
      `
    );
  }else if(coverImageType)
  {
    $(".detail-box").html(
      `
                      <div class="col-sm-12 col-md-12 col-lg-12 media-detail-image">
                      <img src= "` +
        $img +
        `" alt="#" />
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 image-detail">
                      <div class="select"><a href="javascript:void(0);" class="btn btn-success selectImageBtn">Select</a></div>
                      </div>
                      <div class="col-12 image-update">
                      
                        <div class="form">
                          <div class="form-group">
                            <div class="form-single">
                              <label for="title" class="form-label">Title</label>
                              <input type="text" class="form-control" autocomplete="off" id="caption" name="caption" value ="` +
        $caption +
        `" placeholder="Enter caption">
                            </div>
                          </div>
                          <a href="javascript:void(0);" onclick="updateMedia($image_id)" class="button btn btn-primary green-btn narrow-btn">Update</a>
  
                          <a href="javascript:void(0);" onclick="deleteMedia($image_id)" class="button btn-danger btn narrow-btn delete-img" data-id="` +
                          $image_id +
                          `" >Delete</a>
                        </div>
                      
                      </div>
  
                      <script>
                      $(".selectImageBtn").click(function(){
                        $("#imageLibrary").hide();
                      
                        var image = $(".image-border>img").attr("src");
                        image = image.replace("585X486_", "");
                        $("#cover_image").html("<img src='"+image+"'/>");
                      });
                      </script>
      `
    );
  }else{
    $(".detail-box").html(
      `
                      <div class="col-sm-12 col-md-12 col-lg-12 media-detail-image">
                      <img src= "` +
        $img +
        `" alt="#" />
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 image-detail">
                      <div class="select"><a href="javascript:void(0);" class="btn btn-success selectImageBtn">Select</a></div>
                      </div>
                      <div class="col-12 image-update">
                      
                        <div class="form">
                          <div class="form-group">
                            <div class="form-single">
                              <label for="title" class="form-label">Title</label>
                              <input type="text" class="form-control" autocomplete="off" id="caption" name="caption" value ="` +
        $caption +
        `" placeholder="Enter caption">
                            </div>
                          </div>
                          <a href="javascript:void(0);" onclick="updateMedia($image_id)" class="button btn btn-primary green-btn narrow-btn">Update</a>
  
                          <a href="javascript:void(0);" onclick="deleteMedia($image_id)" class="button btn-danger btn narrow-btn delete-img" data-id="` +
                          $image_id +
                          `" >Delete</a>
                        </div>
                      
                      </div>
  
                      <script>
                      $(".selectImageBtn").click(function(){
                        $("#imageLibrary").hide();
                        var image = "";
                        
                        $('.image-border>.media-image-thumbs').each(function(i, obj) {
                          img = $(this).attr("src");
                          console.log(img);

                          img = img.replace("320X320_", "");
                          img = img.replace("585X486_", "");
                          image += "<img src='"+img+"' class='editor-image' />";
                        });
                        // editor.model.change( writer => {
                        //   const insertPosition = editor.model.document.selection.getFirstPosition();
                        //   writer.insertText("[<img src='"+image+"' class='editor-image' />]", insertPosition );
                        // });
                        if(editorInstance == "editor"){
                        const content = image;
                        const viewFragment = editor.data.processor.toView( content );
                        const modelFragment = editor.data.toModel( viewFragment );

                        editor.model.insertContent( modelFragment );
                        }else{
                          const content = image;
                          const viewFragment = editorX.data.processor.toView( content );
                          const modelFragment = editorX.data.toModel( viewFragment );
                          editorX.model.insertContent( modelFragment );
                        }
                      });
                      </script>
      `
    );
  }
 

  $("#addFeaturedImage").click(function() {
    $("#remove-image").remove();
    $("#featured-image").remove();
    $("#banner-image").remove();
    $("#image-caption").remove();
    $(".image-demo").append(
      `<a href="javascrpt:void();" class="image-demo-cancel" id="remove-image" onClick="removeImage()">&#x2715;</a><img id="featured-image" src= "` +
        $img +
        `" alt="` +
        $attributes +
        `" /> <input id="banner-image" name="featured_image" type="hidden" value="` +
        fImg +
        `" /> <input id="image-caption" name="featured_caption" type="hidden" value="` +
         +
        `" />`+
        `<div class="select"><a href="javascript:void(0);" class="btn btn-success selectImageBtn">Select</a></div>`
    );
    $modalBox.find(".modal-box-body").fadeOut("slow");
    $modalBox.fadeOut("slow");
  });
  // $('#featured_caption').val($("#caption").val());
});

$("#img-search").keyup(function() {
  var token = $("meta[name='csrf-token']").attr("content");
  var caption = "";
  caption = $(this).val();
  if(caption.length > 2 || caption.length == 0)
    if(featuredImageType)
      listMedia();
    else if(coverImageType)
      listMedia();
    else
      listMediaEditor();
  
});

// media management tabs
//upload file tab
$("[data-target=upload]").click(function() {
  $(this)
    .addClass("active-btn")
    .siblings()
    .removeClass("active-btn");
  $(".media-manager").hide();
  $(".editor-image").hide();
  $(".upload-manager").show();
});

//media-library tab
$("[data-target=library]").click(function() {
  $(this)
    .addClass("active-btn")
    .siblings()
    .removeClass("active-btn");
  $(".upload-manager").hide();
  $(".editor-image").hide();
  $(".media-manager").show();
});

//editor tab
$("[data-target=editor]").click(function() {
  $(this)
    .addClass("active-btn")
    .siblings()
    .removeClass("active-btn");
  $(".upload-manager").hide();
  $(".media-manager").hide();
  $(".editor-image").show();
});

//to list all the images in media library
function listMedia(page = 1) {
  featuredImageType = true;

  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        fImage = thumb["585X486"];
        base_url = window.location.origin;
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`">
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);

    },
  });
}

function listMediaCover(page = 1) {
  coverImageType = true;

  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        base_url = window.location.origin;
        fImage = thumb["585X486"];
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`">
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);

    },
  });


}

function listMediaClientImage(page = 1) {
  creditsImageType = true;
  featuredImageType = false;

  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        base_url = window.location.origin;
        fImage = thumb["585X486"];
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`">
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);

    },
  });


}

function listMediaClientLogo(page = 1) {
  creditsLogoType = true;
  featuredImageType = false;

  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        base_url = window.location.origin;
        fImage = thumb["585X486"];
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`">
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);

    },
  });


}

//to list all the images in media library
function listMediaEditor(page = 1) {
  featuredImageType = false;
  editorInstance = "editor";

  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        base_url = window.location.origin;
        fImage = thumb["585X486"];
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`" class='media-image-thumbs'>
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);
    },
  });
}

//to list all the images in media library
function listMediaEditorX(page = 1) {
  featuredImageType = false;
  editorInstance = "editorX";
  $(".select").hide();
  var token = $("meta[name='csrf-token']").attr("content");
  var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

  var search = $("#img-search").val();

  if(search != "" && search != undefined)
    url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".form-box").fadeOut(200);
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {

        thumb = JSON.parse(value.thumbnails);
        fImage = thumb["585X486"];
        base_url = window.location.origin;
        temp +=
          `<div class='image-box col-md-3'>
                      <img src="` +
          fImage +
          `" id="` +
          value.id +
          `" title="` +
          value.file_name +
          `" data-uploaded="` +
          value.created_at +
          `" data-caption = "` +
          value.name +
          `" data-id = "` +
          value.id +
          `" alt="` +
          value.file_name +
            `" data-size="`+value.resolution+`" class='media-image-thumbs'>
                  </div>`;
      });
      $("div#medialist").html(temp);
      $(".form-box").fadeIn(200);
      $(".loader").fadeOut(200);
    },
  });
}

var page = 1;
var lastPage = $("#lastPage").val();
$('.form-box').scroll(function(){

  if($('.form-box').scrollTop() + $('.form-box').innerHeight() >= $('.form-box')[0].scrollHeight - 10) {
    if(page < lastPage)
    {
      page++;
    var token = $("meta[name='csrf-token']").attr("content");
    var url = window.location.origin + "/" + "alter-admin/allMedia?page="+page;

    var search = $("#img-search").val();

    if(search != "" && search != undefined)
      url = window.location.origin + "/" + "alter-admin/allMedia/"+search+"?page="+page;
  $(".loader").fadeIn(200);
  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",

    success: function(response) {
      var temp = "";
      $.each(response.media.data, function(key, value) {
        thumb = JSON.parse(value.thumbnails);
        base_url = window.location.origin;
        temp +=
        `<div class='image-box col-md-3'>
                    <img src="` +
        thumb["585X486"] +
        `" id="` +
        value.id +
        `" title="` +
        value.file_name +
        `" data-uploaded="` +
        value.created_at +
        `" data-caption = "` +
        value.name +
        `" data-id = "` +
        value.id +
        `" alt="` +
        value.file_name +
          `" data-size="`+value.resolution+`">
                </div>`;
      });

      $("div#medialist").append(temp);
      $(".loader").fadeOut(200);

    },
  });
}
  }
});

//to update image
function updateMedia($media) {
  var token = $("meta[name='csrf-token']").attr("content");

  $.ajax({
    url: window.location.origin + "/" + "alter-admin/updateMedia/" + $media,
    method: "POST",
    data: {
      id: $media,
      caption: $("#caption").val(),
      attributes: $("#attributes").val(),
      _token: token,
    },
    success: function(data) {
      if(featuredImageType)
        listMedia();
      else if(coverImageType)
        listMediaCover();
      else
        listMediaEditor();
    },
  });
}

//to delete the media image
function deleteMedia($id) {

  var token = $("meta[name='csrf-token']").attr("content");

  if (confirm("Are you sure?")) {
    $.ajax({
      url: window.location.origin + "/" + "alter-admin/deleteMedia/" + $id,
      type: "DELETE",
      data: {
        id: $id,
        _token: token,
      },
      success: function() {
        if(featuredImageType)
          listMedia();
        else if(coverImageType)
          listMediaCover();
        else
          listMediaEditor();
        $(".detail-box").html(` `);
      },
    });
  }
}

function removeImage() {
  $("#banner-image").removeAttr("value");
  $("#remove-image").remove();
  $("#featured-image").remove();
  $("#image-caption").remove();
}



