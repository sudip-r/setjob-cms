@extends('cms.layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Settings</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Settings</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">

    {!! Form::model($setting , ['route' => ['cms::settings.main.update'],'method'=> 'PATCH' ]) !!}
    <div class="row">
      <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('trial_period','Trial Period (days)') !!}
                    {!! Form::text('trial_period', null, ['class' => 'form-control', 'id' => 'trial_period', 'placeholder' => "Free trial period validation days"]) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('facebook','Facebook link') !!}
                  {!! Form::text('facebook', null, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => "Facebook link"]) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('twitter','Twitter link') !!}
                  {!! Form::text('twitter', null, ['class' => 'form-control', 'id' => 'twitter', 'placeholder' => "Twitter link"]) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('linkedin','Linkedin') !!}
                  {!! Form::text('linkedin', null, ['class' => 'form-control', 'id' => 'linkedin', 'placeholder' => "Linkedin link"]) !!}
                </div>
    
            </div>
    
            <div class="card-footer">
                {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
            </div>
    
        </div>
    </div>
    <!--</add news>-->
    
    <!--<right side bar>-->
    <div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">
    
    </div>
    <!--</right side bar>-->
    </div>
    {!! Form::close() !!}
    
  </section>

@endsection