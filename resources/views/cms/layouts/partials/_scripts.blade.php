<!-- jQuery -->
<script src="{!! asset('cms/plugins/jquery/jquery.min.js') !!}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('cms/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{!! asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<!-- ChartJS -->
<script src="{!! asset('cms/plugins/chart.js/Chart.min.js') !!}"></script>
<!-- Sparkline -->
<script src="{!! asset('cms/plugins/sparklines/sparkline.js') !!}"></script>
<!-- JQVMap -->
<script src="{!! asset('cms/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
<script src="{!! asset('cms/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script>
<!-- jQuery Knob Chart -->
<script src="{!! asset('cms/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
<!-- daterangepicker -->
<script src="{!! asset('cms/plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('cms/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('cms/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- Summernote -->
<script src="{!! asset('cms/plugins/summernote/summernote-bs4.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script src="{!! asset('cms/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('cms/plugins/sweetalert2/sweetalert2.all.min.js') !!}"></script>

<script src="{!! asset('cms/dist/js/adminlte.js') !!}"></script>

<script src="{!! asset('cms/plugins/fancy-file-uploader/jquery.fileupload.js') !!}"></script>
<script src="{!! asset('cms/plugins/fancy-file-uploader/jquery.iframe-transport.js') !!}"></script>
<script src="{!! asset('cms/plugins/fancy-file-uploader/jquery.fancy-fileupload.js') !!}"></script>
<script src="{!! asset('cms/plugins/select2/js/select2.full.min.js') !!}"></script>

@yield('custom-scripts')

<script>
var formDelete = false;
function areYouSure($this)
{
  Swal.fire({
  title: 'Are you sure?',
  text: "You are trying to delete this record!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if(result.isConfirmed){
      formDelete = true;
      $($this).submit();
    }
    else {
      formDelete = false;
    }
  })
}
function readURL(input, divId = "featured-img-tag") {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#' + divId).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

 
  $(document).ready(function(){
    var dark_mode = '{{$setting->dark_mode}}';
    if(dark_mode == '1')
    {
      turnOffTheLight();
    }else{
      turnOnTheLight();
    }

    $("#featured-image").change(function() {
    readURL(this);
  });
  $("#icon-light").change(function() {
    readURL(this, "icon-light-img");
  });
  $("#icon-dark").change(function() {
    readURL(this, "icon-dark-img");
  });
  $("#banner-image").change(function() {
    readURL(this);
  });

    $('#search_box').keyup(function(e){
    if(e.keyCode == 13)
    {
      var searchTxt = $("#search_box").val();
      var action = $("#search_box").attr("route");
      if(searchTxt !== "")
      {
        var form = document.createElement('form');
        form.setAttribute("method", "GET");
        form.setAttribute("action", action);

        var input = document.createElement("input");
          input.setAttribute("type", "hidden");
          input.setAttribute("name", "search_txt");
          input.setAttribute("value", searchTxt);
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }
    }
    });
    $("#search-btn").click(function(){
      var searchTxt = $("#search_box").val();
      var action = $("#search_box").attr("route");
      if(searchTxt !== "")
      {
        var form = document.createElement('form');
        form.setAttribute("method", "GET");
        form.setAttribute("action", action);

        var input = document.createElement("input");
          input.setAttribute("type", "hidden");
          input.setAttribute("name", "search_txt");
          input.setAttribute("value", searchTxt);
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }
    });

    $("#video").change(function(){
      $("#video-box").html($("#video").val());
      $("#video-box iframe").removeAttr("width");
      $("#video-box iframe").removeAttr("height");
      $("#video").val($("#video-box").html());
    });

    $(".delete-form").submit(function(e) {
      if(!formDelete)
      {
        e.preventDefault();
        areYouSure($(this));
      }
    });
  });

  function turnOffTheLight()
  {
    $('body').addClass('dark-mode');
    $('.main-header').addClass('navbar-dark');
    $('.main-header').removeClass('navbar-white');
    $('.main-sidebar').removeClass('sidebar-light-info');
    $('.main-sidebar').addClass('sidebar-dark-info');
  }

  function turnOnTheLight()
  {
    $('body').removeClass('dark-mode');
    $('.main-header').addClass('navbar-white');
    $('.main-header').removeClass('navbar-dark');
    $('.main-sidebar').addClass('sidebar-light-info');
    $('.main-sidebar').removeClass('sidebar-dark-info');
  }

  function readURL(input, divId = "featured-img-tag") {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#' + divId).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#featured-image").change(function() {
    readURL(this);
  });
  $("#icon-light").change(function() {
    readURL(this, "icon-light-img");
  });
  $("#icon-dark").change(function() {
    readURL(this, "icon-dark-img");
  });

  $(".__lights_toggle").click(function(){
    var dark_mode = 0;
    if($('body').hasClass('dark-mode'))
    {
      $('body').removeClass('dark-mode');
      $('.main-header').addClass('navbar-white');
      $('.main-header').removeClass('navbar-dark');
      $('.main-sidebar').addClass('sidebar-light-info');
      $('.main-sidebar').removeClass('sidebar-dark-info');
      dark_mode = 0;
    }else{
      $('body').addClass('dark-mode');
      $('.main-header').addClass('navbar-dark');
      $('.main-header').removeClass('navbar-white');
      $('.main-sidebar').removeClass('sidebar-light-info');
      $('.main-sidebar').addClass('sidebar-dark-info');
      dark_mode = 1;
    }

    $.ajax({
    type: 'POST',
    url: '{{route("cms::toggle.dark-mode")}}',
    data: { dark_mode: dark_mode, _token: '{{csrf_token()}}' },
    success: function(data) {
        console.log(data);
    }
});
  });
  
</script>
