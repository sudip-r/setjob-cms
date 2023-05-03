@extends("frontend.layouts.master")

@section("content")

<div class="__inner_search">
    <h3>Frequently Asked Questions</h3>

    <div class="__breadcrumbs">
        <ul>
            <li><a href="{{route('home')}}">Home</a> / </li>
            <li>FAQs</li>
        </ul>
    </div>
</div>


<div class="__main_content __min_height container">
    <div class="row __job_lists">
        <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
            <div class="__page_description">

                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $faq)
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading-{{$faq->id}}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$faq->id}}" @if($loop->first) aria-expanded="true" @endif aria-controls="collapse-{{$faq->id}}">
                          {{$faq->question}}
                        </button>
                      </h2>
                      <div id="collapse-{{$faq->id}}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading-{{$faq->id}}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body __editor_box">
                            {!! $faq->answer !!}
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>

            </div>
            <div class="__gap_30"></div>
        </div>
    </div>
</div> <!-- CONTENT -->

@endsection
