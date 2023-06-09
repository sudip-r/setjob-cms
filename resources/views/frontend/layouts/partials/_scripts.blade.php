<script src="{{asset('front/assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front/assets/vendors/jquery/jquery.min.js')}}"></script>
<script src="{{asset('front/assets/vendors/owl/owl.carousel.min.js')}}"></script>
<script src="{{asset('front/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('front/assets/vendors/sweetalert2/sweetalert2.all.min.js')}}"></script>

@if(Session::has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{!! Session::get('error') !!}'
    });
</script>
@endif

@if(Session::has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Done',
        text: '{!! Session::get('success') !!}'
    });
</script>
@endif
@yield('custom-scripts')

<script src="{{asset('front/assets/js/script.js')}}?v1.11"></script>
