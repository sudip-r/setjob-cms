@extends('cms.layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Stripe</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Stripe</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    {!! Form::model($stripe , ['route' => ['cms::settings.stripe.update'],'method'=> 'PATCH' ]) !!}
    <div class="row">
      <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card card-primary">
            <div class="card-body">

                <div class="form-group">
                  {!! Form::label('test_publishable_key','Publishable Key (Test)') !!}
                  {!! Form::text('test_publishable_key', null, ['class' => 'form-control', 'id' => 'test_publishable_key', 'placeholder' => "Publishable Key (Test)"]) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('test_secret_key','Secret Key (Test)') !!}
                  {!! Form::text('test_secret_key', null, ['class' => 'form-control', 'id' => 'test_secret_key', 'placeholder' => "Secret Key (Test)"]) !!}
                </div>
            </div>
        </div>

        <div class="card card-primary">
          <div class="card-body">

              <div class="form-group">
                {!! Form::label('live_publishable_key','Publishable Key (Live)') !!}
                {!! Form::text('live_publishable_key', null, ['class' => 'form-control', 'id' => 'live_publishable_key', 'placeholder' => "Publishable Key (Live)"]) !!}
              </div>

              <div class="form-group">
                {!! Form::label('live_secret_key','Secret Key (Live)') !!}
                {!! Form::text('live_secret_key', null, ['class' => 'form-control', 'id' => 'live_secret_key', 'placeholder' => "Secret Key (Live)"]) !!}
              </div>
          </div>
          
        </div>

        

        
    </div>
    <!--</add news>-->
    
    <!--<right side bar>-->
    <div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">
      <div class="card card-default categories-box">
        <div class="card-header">
            <h3 class="card-title">Mode</h3>
            <div class="card-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div>
        </div>
        <div class="card-body">
            <!-- Minimal style -->
            <div class="form-group">
                <div class="switch-box">
                  <span class="switch-label">Live</span>
          
                      <label class="switch">
                          {{ Form::hidden('live', false) }}
                          @if(isset($stripe) && $stripe->live == '1' || old('live'))
                              <input type="checkbox" name="live" checked>
                          @else
                              <input type="checkbox" name="live">
                          @endif
                          <span class="slider round"></span>
                      </label>
                  </div>
            </div>
        </div>
          <div class="card-footer">
            {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
          </div>
        <!-- /.box-body -->

      </div>
    </div>
    <!--</right side bar>-->
    </div>
    {!! Form::close() !!}
  </section>

@endsection