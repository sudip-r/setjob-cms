@extends('cms.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Partners</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Partners</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Partners</h3>

      <div class="card-tools">
        <a href="{!! route('cms::partners.create') !!}" title="Add Partner" class="btn top-btn btn-primary">Add Partner</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::partners.search') !!}" id="search_box" placeholder="Search" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::partners.index') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th></th>
            <th scope="col">Partner Name</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($partners as $partner)
          <tr>
            <td class="__image_col"><img class="table__thumbnail" src="{{$partner->image}}"></td>
            <td scope="row">
              {!! $partner->partner_name !!}
            </td>
            <td>
              @if($partner->publish)
              <span class="label label-success">Published</span>
              @else
              <span class="label label-danger">Unpublished</span>
              @endif
            </td>
            <td>
              <a href="{!! route('cms::partners.edit',['partner' => $partner->id]) !!}" class="btn btn-default" title="Edit"><span class="fa fa-edit"></span></a>

              {!! Form::open(['route' => ['cms::partners.delete',$partner->id],'method' => 'delete','onsubmit' =>'return confirm("Are you sure?")', 'class' => 'action-form']) !!}
                <button class="btn btn-default"><span class="fa fa-trash"></span></button>
              {!! Form::close() !!}
            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $partners->appends($_GET)->links() !!}</td>
          </tr>
        </tbody>
      </table>
    </div>


  </div>
</section>

@endsection

