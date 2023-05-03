@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>News</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li>News</li>
        </ul>
    </div>
</div>


<div class="__main_content __min_height container">
    <div class="row __job_lists">
        <div class="col-lg-2 col-md-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="__page_description">

                <div class="__news_detail">
                    <h3>News Title</h3>

                    <div class="__news_image">
                        <img src="{{$news->image}}" />
                    </div>

                    <div class="__news_published">
                        {{date('d M, Y', strtotime($news->published_on))}}
                    </div>

                    <div class="__editor_box __news_description">
                        {!! $news->description !!}
                    </div>

                    <div class="__news_video">{!! $news->video !!}</div>
                </div>
            </div>
            <div class="__gap_30"></div>
        </div>
        <div class="col-lg-2 col-md-2"></div>
    </div>
</div> <!-- CONTENT -->

@endsection
