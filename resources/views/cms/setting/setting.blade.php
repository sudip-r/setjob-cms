@extends('cms.layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>My Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    {!! Form::model([$setting, $user],['route' => ['cms::settings.profile.update',$setting->id],'method'=> 'PATCH','files'=>true ]) !!}
    <div class="row">
      @include('cms.setting.form',['button' => 'Update'])
    </div>
    {!! Form::close() !!}
  </section>

@endsection