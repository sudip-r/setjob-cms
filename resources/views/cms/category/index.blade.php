@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Categories</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Categories</h3>

      <div class="card-tools">
        <a href="{!! route('cms::categories.create') !!}" title="Add News" class="btn top-btn btn-primary">Add Category</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::categories.search') !!}" id="search_box" placeholder="Search" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::categories.index') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>

      <table class="table table-head-fixed text-nowrap alter-table">
        <thead>
          <tr>
            <th scope="col">Category</th>
            <th scope="col">Parent</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @if($categories->count() > 0)
          @foreach($categories as $category)
          <tr>
            <td scope="row">
              {!! $category->category !!}
            </td>
            <td>
              {!! $category->parent()->category ?? 'None' !!}
            </td>
           
            <td>
              @if($category->publish)
              <span class="label label-success">Published</span>
              @else
              <span class="label label-danger">Unpublished</span>
              @endif
            </td>
            <td> 
              
              <a href="{!! route('cms::categories.edit',['category' => $category->id]) !!}" class="btn btn-default" title="Edit"><span class="fa fa-edit"></span></a>
              @if($category->id <= config('cms.locked_category'))
              <a href="javascript:void(0);" class="btn btn-warning" title="This category cannot be deleted">Delete Locked</a>
              
              @else
              {!! Form::open(['route' => ['cms::categories.delete',$category->id],'method' => 'delete', 'id' => 'delete-form', 'class' => 'action-form delete-form']) !!}
                <button class="btn btn-default"><span class="fa fa-trash"></span></button>
              {!! Form::close() !!}
              @endif
            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $categories->appends($_GET)->links() !!}</td>
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

