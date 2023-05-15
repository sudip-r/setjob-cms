@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
  <h3>Dashboard</h3>

  <div class="__breadcrumbs">
      <ul>
          <li><a href="{{route('home')}}">Home</a> / </li>
          <li>Dashboard</li>
      </ul>
  </div>
</div>


<div class="__main_content container">
  <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="__dashboard_links">
              <ul>
                  <li class="active">Dashboard</li>
                  <li><a href="{{route('user.profile')}}">Profile</a></li>
                  <li><a href="{{route('dashboard.jobs')}}">Jobs</a></li>
                  <li><a href="{{route('logout')}}">Logout</a></li>
              </ul>
          </div>
          
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="__job_list_title __relative">
          <h3>Welcome {{$user->name}}!</h3>
          <div class="__post_job_wrapper">
          <a class="__post_job" href="{{route('jobs.list')}}">Find Jobs</a>
          </div>
        </div>
        <div class="__about_wrapper">
          <div class="__editor_box">
            <br>
            @if($payment == false && $expired == false)
            <div id="payment-method">
            <p>You are running on trial period with {{30 - $days}} days remaining. Please add your card to verify your account. The membership fee of £ 1.00 will be deducted every month from this card. </p>
            <br>

            
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="card-element" class="__border">
                  <!-- A Stripe Element will be inserted here. -->
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="__add_card __hidden">
                  <a id="add-card" href="javascript:void(0);" class="__post_job">Add Card</a>
                </div>
              </div>
            </div>
            <br />
              <p>or pay from your wallet</p>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="payment-request-button">
                  <!-- A Stripe Element will be inserted here if the browser supports this type of payment method. -->
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                
              </div>
            </div>
            </div>
            @elseif($expired == true)
            <div id="payment-method">
              <p>Your trial period has expired. Please add your card to verify your account and subscribe to our website. The membership fee of £ 1.00 will be deducted every month from this card. </p>
              <br>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div id="card-element" class="__border">
                    <!-- A Stripe Element will be inserted here. -->
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="__add_card __hidden">
                    <a id="add-card" href="javascript:void(0);" class="__post_job">Add Card</a>
                  </div>
                </div>
              </div>
              <br />
              <p>or pay from your wallet</p>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div id="payment-request-button">
                    <!-- A Stripe Element will be inserted here if the browser supports this type of payment method. -->
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  
                </div>
              </div>
              </div>
            @else
            <p>Ready to find your next perfect job? </p>
            <br>
            <p>To get started, simply edit your profile. Provide as much relevant information as you can for 
              the employer to see so you stand out from the rest of the crowd!</p>
            @endif
          </div>
        </div>
          <div class="__gap_30"></div>
          <div class="__job_list_title">
            <h3>Saved Jobs</h3>
          </div>
          @if($jobs->count() > 0)
          @foreach($jobs as $job)
          <div class="__list_wrapper">
            {{-- <div class="__favorite_job"><i class="far fa-heart"></i></div> --}}
            <h2>{{$job->title}}</h2>
            <p class="__sub_title">{{date('M d, Y', strtotime($job->published_on))}} by <strong><a href="">{{$job->user()->name}}</a></strong></p>
            <ul class="__job_features">
              @if($job->salary_max == "")
              <li><i class="fas fa-pound-sign __right_10"></i> £{{$job->salary_min}} per annum</li>
              @else 
              <li><i class="fas fa-pound-sign __right_10"></i> £{{$job->salary_min}} - £{{$job->salary_max}} per annum</li>
              @endif
              <li><i class="fas fa-map-marker-alt __right_10"></i> {{$job->city()->name}}</li>
              <li><i class="fas fa-briefcase __right_10"></i>{{$job->type}}</li>
            </ul>
            <p class="__job_summary">{{$job->summary}}</p>
          </div><!-- List Wrapper--> 
          @endforeach

          <div class="__pagination">
            {!! $jobs->appends($_GET)->links() !!}
          </div>

          @else
          <div class="__list_wrapper">
            Looks like you haven't saved any jobs yet.
          </div>
          @endif

          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
          
      </div>
  </div>
</div> <!-- CONTENT -->
<div class="__modal __loading_wrapper" id="loading-box">
  <div class="__gap_30"></div>
  <div class="__loading __float_mid"></div>
  <div class="__gap_30"></div>
</div>
@endsection

@section('custom-scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>

</script>
@endsection