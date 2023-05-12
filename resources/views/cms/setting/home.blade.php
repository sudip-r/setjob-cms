@extends('cms.layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Home Settings</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Home Settings</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    {!! Form::model($home , ['route' => ['cms::settings.home.update'],'method'=> 'PATCH' ]) !!}
    <div class="row">
      <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card card-primary">
            <div class="card-body">

                <div class="form-group">
                  {!! Form::label('title','Home page title') !!}
                  {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => "Home page title"]) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('sub_title','Sub title') !!}
                  {!! Form::text('sub_title', null, ['class' => 'form-control', 'id' => 'sub_title', 'placeholder' => "Sub title"]) !!}
                </div>
            </div>
        </div>

        <div class="card card-primary">
          <div class="card-body">
              <div class="form-group">
                {!! Form::label('left_col_title','Left column title') !!}
                {!! Form::text('left_col_title', null, ['class' => 'form-control', 'id' => 'left_col_title', 'placeholder' => "Left column title"]) !!}
              </div>

              <div class="form-group">
                {!! Form::label('left_col_summary','Left column summary') !!}
                {!! Form::textarea('left_col_summary', null, ['class' => 'form-control', 'id' => 'left_col_summary', 'placeholder' => "Left column summary"]) !!}
              </div>

              <div class="form-group">
                {!! Form::label('left_col_btn','Left column button text') !!}
                {!! Form::text('left_col_btn', null, ['class' => 'form-control', 'id' => 'left_col_btn', 'placeholder' => "Left column button text"]) !!}
              </div>

              {{-- <div class="form-group">
                {!! Form::label('left_col_btn_link','Left column button url') !!}
                {!! Form::text('left_col_btn_link', null, ['class' => 'form-control', 'id' => 'left_col_btn_link', 'placeholder' => "Left column button url"]) !!}
              </div> --}}
          </div>
        </div>

        <div class="card card-primary">
          <div class="card-body">
              <div class="form-group">
                {!! Form::label('right_col_title','Right column title') !!}
                {!! Form::text('right_col_title', null, ['class' => 'form-control', 'id' => 'right_col_title', 'placeholder' => "Right column title"]) !!}
              </div>

              <div class="form-group">
                {!! Form::label('right_col_summary','Right column summary') !!}
                {!! Form::textarea('right_col_summary', null, ['class' => 'form-control', 'id' => 'right_col_summary', 'placeholder' => "Right column summary"]) !!}
              </div>

              <div class="form-group">
                {!! Form::label('right_col_btn','Right column button text') !!}
                {!! Form::text('right_col_btn', null, ['class' => 'form-control', 'id' => 'right_col_btn', 'placeholder' => "Right column button text"]) !!}
              </div>

              {{-- <div class="form-group">
                {!! Form::label('right_col_btn_link','Right column button url') !!}
                {!! Form::text('right_col_btn_link', null, ['class' => 'form-control', 'id' => 'right_col_btn_link', 'placeholder' => "Right column button url"]) !!}
              </div> --}}
          </div>
        </div>

        

        
    </div>
    <!--</add news>-->
    
    <!--<right side bar>-->
    <div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">
      <div class="card card-default categories-box">
        <div class="card-header">
            <h3 class="card-title">Save</h3>
            <div class="card-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

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