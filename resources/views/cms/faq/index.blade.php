@extends('cms.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Faqs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Faqs</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Faqs</h3>

      <div class="card-tools">
        <a href="{!! route('cms::faqs.create') !!}" title="Add Question" class="btn top-btn btn-primary">Add Question</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::faqs.search') !!}" id="search_box" placeholder="Search" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::faqs.index') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Question</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($faqs as $faq)
          <tr>
            <td scope="row">
              {!! $faq->question !!}
            </td>
            <td>
              @if($faq->publish)
              <span class="label label-success">Published</span>
              @else
              <span class="label label-danger">Unpublished</span>
              @endif
            </td>
            <td>
              <a href="{!! route('cms::faqs.edit',['faq' => $faq->id]) !!}" class="btn btn-default" title="Edit"><span class="fa fa-edit"></span></a>

              {!! Form::open(['route' => ['cms::faqs.delete',$faq->id],'method' => 'delete','onsubmit' =>'return confirm("Are you sure?")', 'class' => 'action-form']) !!}
                <button class="btn btn-default"><span class="fa fa-trash"></span></button>
              {!! Form::close() !!}
            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $faqs->appends($_GET)->links() !!}</td>
          </tr>
        </tbody>
      </table>
    </div>


  </div>
</section>

@endsection

