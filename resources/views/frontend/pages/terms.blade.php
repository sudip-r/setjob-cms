@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>{{$page->page}}</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li>{{$page->page}}</li>
        </ul>
    </div>
</div>


<div class="__main_content container">
    <div class="row __job_lists">
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
            <div class="__page_description">
                <div class="__editor_box">
                    {!! $page->description !!}
                </div>
            </div>
            <div class="__gap_30"></div>


        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">

            <div class="__company_box">
                <img class="__company_logo" src="{{mpath($page->image)}}" />
            </div>

            <div class="__job_info">
               
            </div>
        </div>
        
    </div>
</div> <!-- CONTENT -->

@endsection