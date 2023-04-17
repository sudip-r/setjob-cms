@include("frontend.layouts.partials._head")

<body class="__body">
    @include("frontend.layouts.partials._nav")
    @include("frontend.layouts.partials._header")
  
    @yield("content")
  
    @include("frontend.layouts.partials._footer")
    @include("frontend.layouts.partials._login_register")
    @include("frontend.layouts.partials._scripts")
</body>

@include("frontend.layouts.partials._tail")