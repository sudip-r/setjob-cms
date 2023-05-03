<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ URL::to('/'); }}">
  <title>alterCMS v1 | Dashboard</title>

  @include('cms.layouts.partials._links')
</head>
<body class="hold-transition sidebar-mini layout-fixed @if($setting->dark_mode == '1') dark-mode @endif">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="fa-spin" src="{!! asset('cms/dist/img/AdminLTELogo.png') !!}" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('cms.layouts.partials._header', ['dark_mode' => $setting->dark_mode])

  @include('cms.layouts.partials._sidebar', ['dark_mode' => $setting->dark_mode])

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  @include('cms.layouts.partials._messages')


    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('cms.layouts.partials._footer')

</div>
<!-- ./wrapper -->
@include('cms.layouts.partials._scripts')
</body>
</html>
