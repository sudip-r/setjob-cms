var csrf = "";
var baseUrl = "";
function pageRedirect(id) {
    if (id !== "0") window.location.href = "/" + id;
}
$(document).ready(function () {
    $("html, body").scrollTop(0);
    csrf = $('meta[name="csrf-token"]').attr("content");
    baseUrl = $('meta[name="base"]').attr("content");

    if (typeof listJobs === "function") {
        listJobs();
    }

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

        if (
            !$(event.target).closest(".__profile_box_drop").length &&
            !$(event.target).closest(".__profile_image").length
        ) {
            $(".__profile_box_drop").fadeOut(200);
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
    $("#register-popup").click(function(){
        $(".__modal").fadeIn(200);
        $(".__body").addClass("__locked");
        // $('html, body').animate({ scrollTop: 0 }, 200);
        $(".__register_title").trigger("click");
    });
    $("#go-to-post").click(function(){
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
    

    $(".__select_2").select2({
        width: "100%",
        height: "32px",
    });

    $(".__select_2").select2({
        width: "100%",
        height: "32px",
    });

    $(".__select_ajax").select2({
        width: "100%",
        height: "32px",
        minimumInputLength: 3, // Only load data after typing at least one character
        ajax: {
            url: baseUrl + "/api/cities",
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
            url: baseUrl + "/api/users",
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



    $(".__favorite_job").click(function () {
        if ($(this).find("i").hasClass("fas")) {
            $(this).html('<i class="far fa-heart"></i>');
        } else {
            $(this).html('<i class="fas fa-heart"></i>');
        }
    });

    $("#filter-workshop").change(function(){
        if(filters.type.workshop == true)
            filters.type.workshop = false;
        else
            filters.type.workshop = true;
            
        listFilters();
    });
    $("#filter-on-site").change(function(){
        if(filters.type.on_site == true)
            filters.type.on_site = false;
        else
            filters.type.on_site = true;
            
        listFilters();
    });
    $("#filter-abroad").change(function(){
        if(filters.type.abroad == true)
            filters.type.abroad = false;
        else
            filters.type.abroad = true;
            
        listFilters();
    });
    $("#filter-various").change(function(){
        if(filters.type.various == true)
            filters.type.various = false;
        else
            filters.type.various = true;
            
        listFilters();
    });
    
    $("#filter-location").on("change", function () {
        var id = $('#filter-location').val();
        var name = $('#filter-location option:selected').text();

        filters.location.id = id;
        filters.location.name = name;

        listFilters();
    });
    $("#filter-company").on("change", function () {
        var id = $('#filter-company').val();
        var name = $('#filter-company option:selected').text();

        filters.company.id = id;
        filters.company.name = name;

        listFilters();
    });

    $("#filter-category").on("change", function () {
        var id = $('#filter-category').val();
        var name = $('#filter-category option:selected').text();

        filters.category.id = id;
        filters.category.name = name;

        listFilters();
    });

    $("#salary-range")
        .on("input", function () {
            // Handle the input event
            $("#salary-selected").fadeIn(200);
            $("#salary-selected").html(convertToCurrency($(this).val()));
        })
        .on("mouseup touchend", function () {
           filters.salary.max = $(this).val();
           listFilters();
        });

    $(".__clear_filter").click(function(){
        window.location.reload();
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

        if (address1 == "" && type == "business") {
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
                type: type,
            };
            var registerAPI = baseUrl + "/api/register";
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
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
                                error: function (xhr, status, error) {
                                    $(".__loading_box").fadeOut(200);
                                },
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

    $("#login-btn").click(function (e) {
        e.preventDefault();
        var email = $("#login-name").val();
        var password = $("#login-password").val();

        var remember = 0;

        if ($("#rememeber-me").prop("checked")) {
            remember = 1;
        }

        var localReg = true;

        if (password == "") {
            $("#login-password-err").html("Password is requried!");
            localReg = false;
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

        if (localReg) {
            var loginUrl = baseUrl + "/api/login";
            var data = {
                email: email,
                password: password,
                remember: remember,
            };
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
            });
            $.ajax({
                url: loginUrl,
                type: "POST",
                data: data,
                beforeSend: function () {
                    $(".__loading_box").fadeIn(200);
                    $("#login-email-err").html("");
                },
                success: function (response) {
                    if (parseInt(response.success) == 0) {
                        $(".__loading_box").fadeOut(200);
                        $("#login-email-err").html(response.message);
                    } else {
                        var dashboard = baseUrl + "/dashboard";

                        window.location.href = dashboard;
                    }
                },
                error: function (xhr, status, error) {
                    $(".__loading_box").fadeOut(200);
                    $("#login-email-err").html(
                        "The provided credentials do not match our records."
                    );
                },
            });
        }
    });

    $("#profile-image").click(function () {
        $("#profile-drop-box").fadeToggle(200);
    });

    $("#login-password").keypress(function (e) {
        if (e.which == 13) {
            $("#login-btn").trigger("click");
        }
    });
    $("#login-name").keypress(function (e) {
        if (e.which == 13) {
            $("#login-btn").trigger("click");
        }
    });

    $("#register-name").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });

    $("#register-password").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });

    $("#register-contact-number").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });
    $("#register-full-name").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });
    $("#register-street-address-1").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });
    $("#register-street-address-2").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });
    $("#register-post-code").keypress(function (e) {
        if (e.which == 13) {
            $("#register-btn-one").trigger("click");
        }
    });

    $("#search-btn").click(function () {
        window.location.href = baseUrl + "/jobs/?search="+$("#search-text").val();
    });
    $('#search-text').on('keypress', function(e) {
        if (e.which === 13) { // check if Enter key pressed
            window.location.href = baseUrl + "/jobs/?search="+$("#search-text").val();
        }
      });

    $("#profile-save-btn").on("click", function (e) {
        e.preventDefault();
        var valid = true;

        var email = $("#email").val();
        var name = $("#name").val();
        var address = $("#address").val();
        var city = $("#city").val();
        var postcode = $("#postcode").val();
        var contact = $("#contact").val();

        if (email == "") {
            valid = false;
            $("#email-err").html("Email cannot be removed");
            scrollToDiv("#email-err");
        } else {
            if (!validateEmail(email)) {
                valid = false;
                $("#email-err").html("Must be valid email address");
                scrollToDiv("#email-err");
            } else {
                $("#email-err").html("");
            }
        }

        if (name == "") {
            valid = false;
            $("#name-err").html("Name cannot be removed");
            scrollToDiv("#name-err");
        } else {
            $("#name-err").html("");
        }

        if (address == "") {
            valid = false;
            $("#address-err").html("Address cannot be removed");
            scrollToDiv("#address-err");
        } else {
            $("#address-err").html("");
        }

        if (city == 0) {
            valid = false;
            $("#city-err").html("Select city from dropdown list");
            scrollToDiv("#city-err");
        } else {
            $("#city-err").html("");
        }

        if (contact == "") {
            valid = false;
            $("#contact-err").html("Contact information cannot be removed");
            scrollToDiv("#contact-err");
        } else {
            $("#contact-err").html("");
        }

        if (valid) {
            $("#employer-profile-update").submit();
        }
    });

    $("#portfolio").on("change", function () {
        // Get the selected files
        var files = $(this).prop("files");

        // Check if the number of files is less than or equal to 8
        if (files.length > 8) {
            $("#portfolio-err").html("Maximum of 8 images are allowed");
            scrollToDiv("#portfolio-err");
            $(this).val("");
            valid = false;
        }

        // Loop through each file and check its type and size
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var fileType = file.type;
            var fileSize = file.size / 1024 / 1024; // Convert to MB

            // Check if the file is an image
            if (fileType.indexOf("image") == -1) {
                $("#portfolio-err").html(
                    "Files must be under 2MB and of image type"
                );
                scrollToDiv("#portfolio-err");
                $(this).val("");
                return false;
            }

            // Check if the file size is less than or equal to 2MB
            if (fileSize > 2) {
                $("#portfolio-err").html(
                    "Files must be under 2MB and of image type"
                );
                scrollToDiv("#portfolio-err");
                $(this).val("");
                return false;
            }
        }
    });

    $("#cv").change(function () {
        var file = this.files[0];
        var fileInput = document.getElementById('cv');
        var filePath = fileInput.value;
        // Check if file is a PDF
        // if (file.type !== "application/pdf") {
        //     $("#cv-err").html("File must be of pdf type");
        //     // Clear file input
        //     $("#cv").val("");
        //     return;
        // }
        var allowedExtensions = /(\.pdf|\.doc|\.docx)$/i;
        if (!allowedExtensions.exec(filePath)) {
            $("#cv-err").html("Invalid file type. Only PDF or Word format files are allowed.");
            fileInput.value = '';
            return false;
        }

        // Check if file size is less than 4MB
        if (file.size > 5 * 1024 * 1024) {
            $("#cv-err").html("File must be under 5MB");
            // Clear file input

            $("#cv").val("");
            return;
        } else {
            $("#cv-err").html("");
        }
    });

    $("#profile-upload").change(function () {
        var file = $("#profile-upload").prop("files")[0];

        if (file.size <= 2097152 && file.type.includes("image/")) {
            readURL(this);
            $("#logo-err").html("");
        } else {
            // File is not valid, show error message
            $("#logo-err").html("File must be under 2MB and of image type");
            scrollToDiv("#logo-err");
            $("#profile-upload").val("");
            return false;
        }
    });

    $("#profile-image-box").click(function () {
        $("#profile-upload").trigger("click");
    });

    $("#create-job-btn").click(function (e) {
        e.preventDefault();
        var valid = true;

        var title = $("#title").val();
        var salary_min = $("#salary-min").val();
        var summary = $("#summary").val();

        if (title == "") {
            valid = false;
            $("#title-err").html("Job title is required");
            scrollToDiv("#title-err");
        } else {
            $("#title-err").html("");
        }

        if (salary_min == "") {
            valid = false;
            $("#salary-min-err").html("Mention the salary");
            scrollToDiv("#salary-min-err");
        } else {
            $("#salary-min-err").html("");
        }

        if (summary.trim() == "") {
            valid = false;
            $("#summary-err").html("Summary is required");
            scrollToDiv("#summary-err");
        } else {
            $("#summary-err").html("");
        }

        if (valid) {
            $("#employer-create-job").submit();
        }
    });

    $(".__toggle_btn").click(function () {
        var id = $(this).attr("alt");
        var jobStatusToggle = baseUrl + "/api/jobStatusToggle";
        var data = {
            id: id,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        });
        $.ajax({
            url: jobStatusToggle,
            type: "POST",
            data: data,
            beforeSend: function () {
                $(".__loading_box").fadeIn(200);
            },
            success: function (response) {
                $(".__loading_box").fadeOut(200);

                if (parseInt(response.success) == 0) {
                    $(".__loading_box").fadeOut(200);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Done",
                        text: response.message,
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                $(".__loading_box").fadeOut(200);
            },
        });
    });

    $('input[type="radio"][name="employee-check"]').change(function() {
        var selectedValue = $(this).val();
        if(selectedValue == "business")
        {
            $("#address-box").fadeIn(200);
        }
        if(selectedValue == "client")
        {
            $("#address-box").fadeOut(200);
        }
      });

});//document ready

function convertToCurrency(currency) {
    currency = parseInt(currency);
    return (
        "Selected - "+currency.toLocaleString("en-GB", {
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

function scrollToDiv(id) {
    $("html, body").animate(
        {
            scrollTop: $(id).offset().top - 30,
        },
        200
    );
}

function readURL(input, divId = "profile-image-box") {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#" + divId).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

