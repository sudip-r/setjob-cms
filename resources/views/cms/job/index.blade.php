@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Jobs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Jobs</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Jobs</h3>

      <div class="card-tools">
        <a href="{!! route('cms::jobs.create') !!}" title="Add News" class="btn top-btn btn-primary">Add Job</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::jobs.search') !!}" id="search_box" placeholder="Search" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::jobs.index') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>

      <table class="table table-head-fixed text-nowrap alter-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Employer / Company</th>
            <th>Published On</th>
            <th>Category</th>
            <th>Status</th>
            <th style="width: 15%;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @if($jobs->count() > 0)
          @foreach($jobs as $job)
          @if($job->publish)
          <tr class="__even" id="row_{{$job->id}}">
            @else
          <tr class="__odd" id="row_{{$job->id}}">
            @endif
            <td id="col_title_{{$job->id}}">
              {!! $job->title !!}
            </td>
            <td>{{ $job->type }}</td>
            <td>{{ getUserName($job->user_id) }}</td>
            <td id="col_published_on_{{$job->id}}">
              {!! $job->published_on !!}
            </td>
            <td id="col_category_{{$job->id}}">
              <div class="category__tag">{{$job->cat()->name}}</div>
            </td>
            <td >
              @if($job->publish)
              <span class="label label-success">Published</span>
              @else
              <span class="label label-danger">Unpublished</span>
              @endif
            </td>
            <td>
              <a href="{!! route('cms::jobs.edit',['job' => $job]) !!}" class="btn btn-warning" title="Edit"><span class="fa fa-edit"></span></a>

              @if($user->isSuperuser() || $user->hasPermission('cms::jobs.status'))
                @if($job->publish)
                <a href="{!! route('cms::jobs.status',['job' => $job]) !!}" class="btn btn-danger" title="Unpublish"><span class="fa fa-low-vision"></span></a>
                @else
                <a href="{!! route('cms::jobs.status',['job' => $job]) !!}" class="btn btn-success" title="Publish"><span class="fa fa-check"></span></a>
                @endif
              @endif

              {!! Form::open(['route' => ['cms::jobs.delete',$job],'method' => 'delete', 'class' => 'action-form delete-form']) !!}
              <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
              {!! Form::close() !!}
            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $jobs->appends($_GET)->links() !!}</td>
          </tr>

          @else
          <tr>
            <td colspan="8">No records found!</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
@endsection

