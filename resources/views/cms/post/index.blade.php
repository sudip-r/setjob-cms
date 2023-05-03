@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Posts</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Posts</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">News</h3>

      <div class="card-tools">
        <a href="{!! route('cms::posts.create') !!}" title="Add News" class="btn top-btn btn-primary">Add News</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::posts.search') !!}" id="search_box" placeholder="Search" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::posts.index') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>

      <table class="table table-head-fixed text-nowrap alter-table">
        <thead>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Author</th>
            <th>Last Modified</th>
            <th>Published On</th>
            {{-- <th>Category</th> --}}
            <th>Status</th>
            <th style="width: 15%;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @if($posts->count() > 0)
          @foreach($posts as $post)
          @if($post->publish)
          <tr class="__even" id="row_{{$post->id}}">
            @else
          <tr class="__odd" id="row_{{$post->id}}">
            @endif
            <td class="__image_col"><img class="table__thumbnail" src="{{$post->image}}"></td>
            <td id="col_title_{{$post->id}}">
              {!! $post->title !!}
            </td>
            <td>{{ getUserName($post->author) }}</td>
            <td>{{ getUserName($post->last_modified) }}</td>
            <td id="col_published_on_{{$post->id}}">
              {!! $post->published_on !!}
            </td>
            {{-- <td id="col_category_{{$post->id}}">
            @foreach($post->cats as $category)
              <div class="category__tag">{{$category->category}}</div>
            @endforeach
            </td> --}}
            <td >
              @if($post->publish)
              <span class="label label-success">Published</span>
              @else
              <span class="label label-danger">Unpublished</span>
              @endif
            </td>
            <td>
              <a href="{!! route('cms::posts.edit',['post' => $post]) !!}" class="btn btn-warning" title="Edit"><span class="fa fa-edit"></span></a>

              @if($user->isSuperuser() || $user->hasPermission('cms::posts.status'))
                @if($post->publish)
                <a href="{!! route('cms::posts.status',['post' => $post]) !!}" class="btn btn-danger" title="Unpublish"><span class="fa fa-low-vision"></span></a>
                @else
                <a href="{!! route('cms::posts.status',['post' => $post]) !!}" class="btn btn-success" title="Publish"><span class="fa fa-check"></span></a>
                @endif
              @endif

              {!! Form::open(['route' => ['cms::posts.delete',$post],'method' => 'delete', 'class' => 'action-form delete-form']) !!}
              <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
              {!! Form::close() !!}
            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $posts->appends($_GET)->links() !!}</td>
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

