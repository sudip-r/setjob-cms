@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Category</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{!! route('cms::categories.index') !!}">Categories</a></li>
          <li class="breadcrumb-item active">Add Category</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  {!! Form::open(['route' => 'cms::categories.store','files'=>true]) !!}
    <div class="row">
      @include('cms.category.form')
    </div>
    {!! Form::close() !!}
  <!-- /.row -->
</section>
<!-- /.content -->

@endsection

@section('custom-scripts')
<script>
  $('#category-name').keyup(function() {
    var title = $('#category-name').val();
    slug = title.replace(/\ /g, '-').toLowerCase();
    $('#slug').val(slug);
  });
</script>
@endsection