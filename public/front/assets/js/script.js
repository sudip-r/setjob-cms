var csrf = "";
var baseUrl = "";
function pageRedirect(id) {
    if (id !== "0") window.location.href = "/" + id;
}
$(document).ready(function () {
    csrf = $('meta[name="csrf-token"]').attr("content");
    baseUrl = $('meta[name="base"]').attr("content");

    $(".__hamburger").click(function () {
        $(".__mobile_side_nav").animate({ left: "0" }, "fast");
        $(".__mobile_side_nav_gap").fadeIn(200);
        $(".__mobile_side_nav_wrapper").show();
    });
    $(".__mobile_side_nav_gap").click(function () {
        $(".__mobile_side_nav_gap").fadeOut(200);
        $(".__mobile_side_nav").animate({ left: "-200%" }, "fast", function () {
            $(".__mobile_side_nav_wrapper").hide();
        });
    });
    $(".__post_more").click(function () {
        $(this).find(".__post_more_box").fadeToggle(200);
    });

    $(document).on("click", function (event) {
        if (
            !$(event.target).closest(".__navigation_bar").length &&
            !$(event.target).closest(".__icon_outside").length
        ) {
            $(".__burger_icon").removeClass("clicked");
            $(".__navigation_bar").removeClass("__active");
            $(".__menu").fadeOut(200);
        }
    });

    $(".__icon_outside").click(function () {
        $(".__burger_icon").addClass("clicked");
        $(".__navigation_bar").addClass("__active");
        $(".__menu").fadeIn(1400);
    });

    $(".__icon_inside").click(function () {
        $(".__burger_icon").removeClass("clicked");
        $(".__navigation_bar").removeClass("__active");
        $(".__menu").fadeOut(200);
    });

    $(".owl-carousel").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        center: true,
        loop: true,
        nav: true,
        width: 200,
        stagePadding: 50,
        lazyLoad: true,
        items: 4,
        margin: 50,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
            },
            600: {
                items: 3,
                nav: false,
            },
            1000: {
                items: 4,
                nav: true,
                loop: false,
            },
        },
    });
    $(".__portfolio_carousel").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        center: true,
        loop: true,
        nav: true,
        width: 270,
        stagePadding: 10,
        lazyLoad: true,
        items: 4,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
            },
            600: {
                items: 3,
                nav: false,
            },
            1000: {
                items: 4,
                nav: true,
                loop: false,
            },
        },
    });

    $("#login-pop").click(function () {
        $(".__modal").fadeIn(200);
        $(".__body").addClass("__locked");
        // $('html, body').animate({ scrollTop: 0 }, 200);
        $(".__login_title").trigger("click");
    });
    $("#register-pop").click(function () {
        $(".__modal").fadeIn(200);
        $(".__body").addClass("__locked");
        // $('html, body').animate({ scrollTop: 0 }, 200);
        $(".__register_title").trigger("click");
    });
    $(".__close").click(function () {
        $(".__modal").fadeOut(200);
        $(".__body").removeClass("__locked");
    });
    $(".__modal_background").click(function () {
        $(".__modal").fadeOut(200);
        $(".__body").removeClass("__locked");
    });
    $(".__login_title").click(function () {
        $(".__register_box").fadeOut(0);
        $(".__login_box").fadeIn(200);
        $(".__box_title").html("Sign In");
        $(".__login_title").addClass("__active_title");
        $(".__register_title").removeClass("__active_title");
    });
    $(".__register_title").click(function () {
        $(".__register_box").fadeIn(200);
        $(".__login_box").fadeOut(0);
        $(".__box_title").html("Register");
        $(".__register_title").addClass("__active_title");
        $(".__login_title").removeClass("__active_title");
    });
    $(".__login_link").click(function () {
        $(".__login_title").trigger("click");
    });
    $(".__register_link").click(function () {
        $(".__register_title").trigger("click");
    });
    $("#salary-range")
        .on("input", function () {
            // Handle the input event
            $("#salary-range-label").html(convertToCurrency($(this).val()));
        })
        .on("mouseup touchend", function () {
            $(".__loading").show();
            $(".__list_wrapper").fadeOut(200);
            hideLoading();
        });

    $(".__select_2").select2({
        width: "100%",
        height: "32px",
    });

    $(".__favorite_job").click(function () {
        if ($(this).find("i").hasClass("fas")) {
            $(this).html('<i class="far fa-heart"></i>');
        } else {
            $(this).html('<i class="fas fa-heart"></i>');
        }
    });
    $(".__filter_type input").on("change", function () {
        $(".__loading").show();
        $(".__list_wrapper").fadeOut(200);
        hideLoading();
    });
    $("#filter-location").on("change", function () {
        $(".__loading").show();
        $(".__list_wrapper").fadeOut(200);
        hideLoading();
    });
    $("#filter-company").on("change", function () {
        $(".__loading").show();
        $(".__list_wrapper").fadeOut(200);
        hideLoading();
    });
    var register = true;
    $("#register-btn-one").click(function (e) {
        e.preventDefault();
        var email = $("#register-name").val();
        var password = $("#register-password").val();

        var localReg = true;

        if (password == "") {
            $("#register-password-err").html("Password is requried!");
            localReg = false;
        } else {
            if (validatePassword(password)) {
                $("#register-password-err").html("");
            } else {
                $("#register-password-err").html(
                    "Password should be at least 6 characters and include at least one capital letter and symbol!"
                );
                localReg = false;
            }
        }

        if (!$("#agree-field").prop("checked")) {
            localReg = false;
            $("#terms-err").html(
                "You'll need to agree to the terms and policies to register"
            );
        } else {
            $("#terms-err").html("");
        }

        if (email == "") {
            $("#register-email-err").html("Email is requried!");
            localReg = false;
        } else {
            if (validateEmail(email)) {
                $("#register-email-err").html("");

                var data = {
                    email: email,
                    _token: csrf,
                };
                var checkAPI = baseUrl + "/api/check-email";
                if (localReg) {
                    $.ajax({
                        url: checkAPI,
                        type: "POST",
                        data: data,
                        beforeSend: function () {
                            $(".__loading_box").fadeIn(200);
                        },
                        success: function (response) {
                            if (parseInt(response.success) == 0) {
                                $("#register-email-err").html(response.message);
                                register = false;
                            } else {
                                //Next step
                                if (localReg) {
                                    $(".__register_step_1").hide();
                                    $(".__register_step_2").show();
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            register = false;
                            $(".__loading_box").fadeOut(200);
                        },
                        complete: function () {
                            $(".__loading_box").fadeOut(200);
                        },
                    });
                }
            } else {
                $("#register-email-err").html("Email should be valid!");
                localReg = false;
            }
        }
    });

    $("#register-btn-back").click(function () {
        $(".__register_step_1").show();
        $(".__register_step_2").hide();
    });

    var registered = 0;
    $("#register-btn-final").click(function (e) {
        e.preventDefault();
        var localReg = true;
        var email = $("#register-name").val();
        var password = $("#register-password").val();

        var name = $("#register-full-name").val();

        var address1 = $("#register-street-address-1").val();
        var address2 = $("#register-street-address-2").val();
        var town = $("#register-town-city").val();
        var postalCode = $("#register-post-code").val();
        var contact = $("#register-contact-number").val();
        var type = $('input[name="employee-check"]:checked').val();

        if (name == "") {
            localReg = false;
            $("#register-fullname-err").html("Name is required!");
        } else {
            $("#register-fullname-err").html("");
        }

        if (address1 == "") {
            localReg = false;
            $("#register-address-err").html("Address is required!");
        } else {
            $("#register-address-err").html("");
        }

        if (town == "" || town == "0") {
            localReg = false;
            $("#register-town-err").html("Select your town / city!");
        } else {
            $("#register-town-err").html("");
        }

        if (postalCode == "") {
            localReg = false;
            $("#register-post-code-err").html("Postcode is required!");
        } else {
            $("#register-post-code-err").html("");
        }

        if (contact == "") {
            localReg = false;
            $("#register-contact-number-err").html(
                "Contact number is required!"
            );
        } else {
            $("#register-contact-number-err").html("");
        }

        if (localReg) {
            var data = {
                email: email,
                password: password,
                name: name,
                address1: address1,
                address2: address2,
                town: town,
                postalCode: postalCode,
                contact: contact,
                type: type
            };
            var registerAPI = baseUrl + "/api/register";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf
                }
            });
            if (registered == 0) {
                $.ajax({
                    url: registerAPI,
                    type: "POST",
                    data: data,
                    beforeSend: function () {
                        $(".__loading_box").fadeIn(200);
                    },
                    success: function (response) {
                        registered++;
                        if (parseInt(response.success) == 0) {
                            register = false;
                        } else {
                          var loginUrl = baseUrl + "/api/login";
                          
                          $.ajax({
                            url: loginUrl,
                            type: "POST",
                            data: data,
                            beforeSend: function () {
                                $(".__loading_box").fadeIn(200);
                            },
                            success: function (response) {
                                if (parseInt(response.success) == 0) {
                                    register = false;
                                } else {
                                  var dashboard = baseUrl + "/dashboard";
                                  
                                  window.location.href = dashboard;
                                }
                            },
                            error: function(xhr, status, error) {
                                $(".__loading_box").fadeOut(200);
                            }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        $(".__loading_box").fadeOut(200);


                    },
                    complete: function () {},
                });
            }
        }
    });

    $("#login-btn").click(function(e){
        e.preventDefault();
        var email = $("#login-name").val();
        var password = $("#login-password").val();

        var remember = 0;

        if($("#rememeber-me").prop("checked"))
        {
            remember = 1;
        }

        var localReg = true;

        if (password == "") {
            $("#login-password-err").html("Password is requried!");
            localReg = false;
        } else {
            if (validatePassword(password)) {
                $("#login-password-err").html("");
            } else {
                $("#login-password-err").html(
                    "Password should be at least 6 characters and include at least one capital letter and symbol!"
                );
                localReg = false;
            }
        }
        if (email == "") {
            $("#login-email-err").html("Email is requried!");
            localReg = false;
        } else {
            if (validateEmail(email)) {
                $("#login-email-err").html("");
            } else {
                $("#login-email-err").html("Email should be valid!");
                localReg = false;
            }
        }

        if(localReg)
        {
            var loginUrl = baseUrl + "/api/login";
            var data = {
                email: email,
                password: password,
                remember: remember
            };    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf
                }
            });  
            $.ajax({
            url: loginUrl,
            type: "POST",
            data: data,
            beforeSend: function () {
                $(".__loading_box").fadeIn(200);
            },
            success: function (response) {
                if (parseInt(response.success) == 0) {
                    register = false;
                } else {
                    var dashboard = baseUrl + "/dashboard";
                    
                    window.location.href = dashboard;
                }

            },
            error: function(xhr, status, error) {
                $(".__loading_box").fadeOut(200);
            }
            });
        }
    });

});
function convertToCurrency(currency) {
    currency = parseInt(currency);
    return (
        "£10,000 - " +
        currency.toLocaleString("en-GB", {
            style: "currency",
            currency: "GBP",
            maximumFractionDigits: 0,
        })
    );
}

function hideLoading() {
    setTimeout(function () {
        $(".__loading").hide();
        $(".__list_wrapper").fadeIn(200);
    }, 3000);
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePassword(password) {
    // check if password is at least 6 characters long
    if (password.length < 6) {
        return false;
    }
    // check if password includes at least one capital letter and a symbol character
    const capitalLetterRegex = /[A-Z]/;
    const symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    if (!capitalLetterRegex.test(password) || !symbolRegex.test(password)) {
        return false;
    }
    return true;
}
