function pageRedirect(id) {
  if(id !== "0")
    window.location.href = "/"+id;
} 
$(document).ready(function(){
  $(".__hamburger").click(function(){
    $(".__mobile_side_nav").animate({"left":"0"}, "fast");
    $(".__mobile_side_nav_gap").fadeIn(200);
    $(".__mobile_side_nav_wrapper").show();
  });
  $(".__mobile_side_nav_gap").click(function(){
    $(".__mobile_side_nav_gap").fadeOut(200);
    $(".__mobile_side_nav").animate({"left":"-200%"}, "fast", function(){
      $(".__mobile_side_nav_wrapper").hide();
    });
  });
  $(".__post_more").click(function(){
    $(this).find(".__post_more_box").fadeToggle(200);
  });

  $(document).on('click', function(event) {
    if (!$(event.target).closest('.__navigation_bar').length && !$(event.target).closest('.__icon_outside').length) {
      $(".__burger_icon").removeClass("clicked");
      $(".__navigation_bar").removeClass("__active");
      $(".__menu").fadeOut(200);
    }
  });

  $(".__icon_outside").click(function(){
    $(".__burger_icon").addClass("clicked");
    $(".__navigation_bar").addClass("__active");
    $(".__menu").fadeIn(1400);
  });

  $(".__icon_inside").click(function(){
    $(".__burger_icon").removeClass("clicked");
      $(".__navigation_bar").removeClass("__active");
      $(".__menu").fadeOut(200);
  });
 
  $('.owl-carousel').owlCarousel({
    autoPlay: 3000, //Set AutoPlay to 3 seconds
    center: true,
    loop:true,
    nav:true,
    width:200,
    stagePadding: 50,
    lazyLoad:true,
    items : 4,
    margin:50,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:4,
            nav:true,
            loop:false
        }
    }
  });
  $('.__portfolio_carousel').owlCarousel({
    autoPlay: 3000, //Set AutoPlay to 3 seconds
    center: true,
    loop:true,
    nav:true,
    width:270,
    stagePadding: 10,
    lazyLoad:true,
    items : 4,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:4,
            nav:true,
            loop:false
        }
    }
  });

  $("#login-pop").click(function(){
    $(".__modal").fadeIn(200);
    $(".__body").addClass("__locked");
    // $('html, body').animate({ scrollTop: 0 }, 200);
    $(".__login_title").trigger("click");
  });
  $("#register-pop").click(function(){
    $(".__modal").fadeIn(200);
    $(".__body").addClass("__locked");
    // $('html, body').animate({ scrollTop: 0 }, 200);
    $(".__register_title").trigger("click");
  });
  $(".__close").click(function(){
    $(".__modal").fadeOut(200);
    $(".__body").removeClass("__locked");
  });
  $(".__modal_background").click(function(){
    $(".__modal").fadeOut(200);
    $(".__body").removeClass("__locked");
  });
  $(".__login_title").click(function(){
    $(".__register_box").fadeOut(0);
    $(".__login_box").fadeIn(200);
    $(".__box_title").html("Sign In");
    $(".__login_title").addClass("__active_title");
    $(".__register_title").removeClass("__active_title");
  });
  $(".__register_title").click(function(){
    $(".__register_box").fadeIn(200);
    $(".__login_box").fadeOut(0);
    $(".__box_title").html("Register");
    $(".__register_title").addClass("__active_title");
    $(".__login_title").removeClass("__active_title");
  });
  $(".__login_link").click(function(){
    $(".__login_title").trigger("click");
  });
  $(".__register_link").click(function(){
    $(".__register_title").trigger("click");
  });
  $('#salary-range')
    .on('input', function() {
      // Handle the input event
      $("#salary-range-label").html(convertToCurrency($(this).val()))
    })
    .on("mouseup touchend", function(){
      console.log("Salary filter updated "+ $(this).val());
      $(".__loading").show();
      $(".__list_wrapper").fadeOut(200);
      hideLoading();
    });

    $(".__select_2").select2({
      width:"100%",
      height:"32px"
    });

    $(".__favorite_job").click(function(){
      if ($(this).find('i').hasClass('fas')) {
        $(this).html('<i class="far fa-heart"></i>');
      }else{
        $(this).html('<i class="fas fa-heart"></i>');
      }
    });
    $(".__filter_type input").on("change", function(){
      $(".__loading").show();
      $(".__list_wrapper").fadeOut(200);
      hideLoading();
    });
    $("#filter-location").on("change", function(){
      $(".__loading").show();
      $(".__list_wrapper").fadeOut(200);
      hideLoading();
    });
    $("#filter-company").on("change", function(){
      $(".__loading").show();
      $(".__list_wrapper").fadeOut(200);
      hideLoading();
    });
});
function convertToCurrency(currency)
{
  currency = parseInt(currency);
  return "£10,000 - " + currency.toLocaleString('en-GB', { style: 'currency', currency: 'GBP', maximumFractionDigits: 0});
}

function hideLoading()
{
  setTimeout(function() {
    $(".__loading").hide();
    $(".__list_wrapper").fadeIn(200);
  }, 3000);
}