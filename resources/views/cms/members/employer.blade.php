@extends('cms.layouts.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Employers</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{!! route('cms::dashboard') !!}">Dashboard</a></li>
          <li class="breadcrumb-item active">Employers</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Employers</h3>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-md-6 search__box">
          <div class="input-group">
            <input class="form-control" alt="Category" route="{!! route('cms::members.employer.search') !!}" id="search_box" placeholder="Search (ID, Name or Email)" type="text" value="@if(isset($searchTxt)) {!! $searchTxt !!} @endif">
            <div class="input-group-addon search__icon" id="search-btn"><i class="ti-search"></i></div>
            @if(isset($searchTxt))
            <a href="{!! route('cms::members.employer') !!}" title="Cancel Search"><i class="fa fa-times cancel__search"></i></a>
            @endif
          </div>
        </div>
      </div>
      <table class="table table-striped table-hover alter-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email Address</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $user)
          <tr>
            <td>{!! $user->id !!}</td>
            <td>
              <div class="widget-user-image user-image-circle">
                @php 
                  $profileImage = asset('uploads/users/'.$user->profile_image)
                @endphp

                @if(!file_exists(public_path('uploads/users/'.$user->profile_image)))
                  @php 
                    $profileImage = asset('cms/dist/img/user.png')
                  @endphp
                @endif
                <img class="img-circle user-img" src="{!! $profileImage !!}" alt="{!! $user->name !!}">
              </div><span class="media-heading user-title">{!! $user->name !!}</span>
            </td>
            <td>{!! $user->email !!}</td>
            <td>@if($user->profile() != null) {!! $user->profile()->contact !!} @endif</td>
            <td>
              @if($user->active)
              <span class="bg-success color-palette __p10">Active</span>
              @else
              <span class="bg-danger color-palette __p10">Inactive</span>
              @endif
              @if($user->verified)
              <span class="bg-success color-palette __p10">Verified</span>
              @else
              <span class="bg-warning color-palette __p10">Not Verified</span>
              @endif
            </td>
            <td>
                @if($user->active)
                <a href="{!! route('cms::members.status',['member' => $user]) !!}" class="btn btn-danger" data-bs-toggle="tooltip" data-placement="top" title="You can deactivate user account from here."><span class="fa fa-low-vision"></span></a>
                @else
                <a href="{!! route('cms::members.status',['member' => $user]) !!}" class="btn btn-success" data-bs-toggle="tooltip" data-placement="top" title="You can activate user account from here."><span class="fa fa-check"></span></a>
                @endif

                <a href="{!! route('employer.detail',['slug' => $user->slug]) !!}" class="btn btn-warning" data-bs-toggle="tooltip" data-placement="top" title="View user profile" target="_blank"><span class="fa fa-eye"></span></a>

            </td>

          </tr>
          @endforeach

          <tr>
            <td colspan="8">{!! $members->links() !!}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('custom-scripts')
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
@endsection