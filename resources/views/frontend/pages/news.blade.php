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

                @if($posts->count() > 0)
                @foreach($posts as $post)
                <div class="__news">
                    <a href="{{route('news.detail', ['slug' => $post->slug])}}">
                        <h3>{{$post->title}}</h3>

                        <div class="__news_summary">
                            {{$post->summary}}
                        </div>

                        <div class="__news_published">
                            {{date('d M, Y', strtotime($post->published_on))}}
                        </div>
                    </a>
                </div>

                
                @endforeach
                <div class="__pagination">
                    {!! $posts->appends($_GET)->links() !!}
                </div>
                @else 
                <div class="__news">
                    <h3>No news found!</h3>
                </div>
                @endif

            </div>
            <div class="__gap_30"></div>
        </div>
        <div class="col-lg-2 col-md-2"></div>
    </div>
</div> <!-- CONTENT -->

@endsection
