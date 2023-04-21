<div class="col-md-9 col-sm-8 col-xs-12">
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        {!! Form::label('category','Category Name') !!}
        @if(isset($category) && $category->id <= config('cms.locked_category'))
        <div class="form-control">
        {{$category->category}}
        </div>
        {!! Form::hidden('category',$category->category) !!}
        @else 
        {!! Form::text('category',null,['class' => 'form-control', 'id' => 'category-name', 'placeholder' => "Enter Category name" ]) !!}
        @endif
      </div>

      <div class="form-group">
        {!! Form::label('slug','Slug') !!}
        @if(isset($category) && $category->id <= config('cms.locked_category'))
        <div class="form-control">
        {{$category->slug}}
        </div>
        {!! Form::hidden('slug',$category->slug) !!}
        @else
        {!! Form::text('slug',null,['class'=>'form-control', 'placeholder'=>'Enter Category Slug', 'id'=>'slug']) !!}
        @endif
      </div>

      <input type="hidden" name="type" value="Category" />
      @if(isset($category))
      <input type="hidden" name="id" value="{{$category->id}}" />
      @endif
     

      <div class="form-group">
        {!! Form::label('summary','Summary (Optional)') !!}
        {!! Form::textarea('summary',null,['class' => 'form-control', 'id' => 'summary', 'placeholder' => "Enter Summary" ]) !!}
      </div>
    </div>

    <div class="card-footer desktop_submit">
      {!! Form::submit('Submit',['class' => 'btn btn-primary']) !!}

      <a href="{!! route('cms::categories.index') !!}" title="Cancel" class="btn btn-danger cancel-btn">Cancel</a>
    </div>

  </div>
</div>
<!--</add news>-->

<!--<right side bar>-->
<div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">


  <!-- Categories -->
  @if(isset($category) && $category->id <= config('cms.locked_category'))
  <div class="card card-default categories-box">
    <div class="card-header">
      <h3 class="card-title">Parent</h3>
    </div>
    <div class="card-body">
      @if($category->parent > 0)
      {{$category->parent()->category}}
      @else 
      None 
      @endif
    </div>
  </div>
  @else
  <div class="card card-default categories-box">
    <div class="card-header">
      <h3 class="card-title">Parent</h3>
    </div>
    <div class="card-body">
      <!-- Minimal style -->
      <div class="form-group">
        
        <div class="radio">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" name="parent" value="0" id="parent-select"
            @if(isset($category) && $category->parent == 0)
            checked="checked"
            @endif
            >
            <label for="parent-select" class="custom-control-label">Parent</label>
          </div>
        </div>
        @foreach($categories as $k => $cat)
        @if(isset($category) && $k == $category->id)
          @continue
        @endif
          <div class="radio">
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="parent" value="{{$k}}" id="parent-select-{{$k}}"
              @if(isset($category) && $k == $category->parent)
              checked="checked"
              @endif
              >
              <label for="parent-select-{{$k}}" class="custom-control-label">{{$cat}}</label>
            </div>
          </div>
          
        @endforeach
      </div>


    </div>
    <!-- /.box-body -->

  </div>
  @endif

  <div class="card card-default categories-box mt-30">
    <div class="card-header">
      <h3 class="card-title">Icons</h3>
    </div>
    <div class="card-body">
    <div class="form-group">
      <div class="row">
        <div class="col-md-6">
          {!! Form::label('icon-light','Icon light') !!}

          @if(isset($category) && $category->icon_light)
          <div class="widget-image">
            <img id="icon-light-img" class="full__width" src="@if(isUrl($category->icon_light)){{$category->icon_light}}@else{!! mpath('uploads/icons/'.$category->icon_light) !!}@endif" alt="{!! $category->category !!}">
          </div>
          @else
          <img id="icon-light-img" class="full__width" src="{!! mpath('cms/dist/img/icon.png') !!}">
          @endif
          <div class="form-group">
            <div class="custom-file">
             
              <fieldset class="form-group mt-30">
                <label class="custom-file center-block block">
                  <input type="file" name="icon_light" id="icon-light" class="custom-file-input">
                  <span class="custom-file-control"></span> </label>
              </fieldset>
            </div>
          </div>
        </div>

       <div class="col-md-6">
          {!! Form::label('icon-dark','Icon Dark (For dark theme)') !!}

          @if(isset($category) && $category->icon_dark)
          <div class="widget-image">
            <img id="icon-dark-img" class="full__width" src="@if(isUrl($category->icon_dark)){{$category->icon_dark}}@else{!! mpath('uploads/icons/'.$category->icon_dark) !!}@endif" alt="{!! $category->category !!}">
          </div>
          @else
          <img id="icon-dark-img" class="full__width" src="{!! mpath('cms/dist/img/icon.png') !!}">
          @endif
          <div class="form-group">
            <div class="custom-file">
             
              <fieldset class="form-group mt-30">
                <label class="custom-file center-block block">
                  <input type="file" name="icon_dark" id="icon-dark" class="custom-file-input">
                  <span class="custom-file-control"></span> </label>
              </fieldset>
            </div>
          </div>
        </div> 

      </div>
    </div>
    </div>
  </div>
  <!-- /.box-body -->

  <!-- Categories -->
  <div class="card card-default categories-box ">
    <div class="card-header">
      <h3 class="card-title">Status</h3>
    </div>
    <div class="card-body">
      <!-- Minimal style -->

      <!-- radio -->
      @if(isset($category) && $category->id <= config('cms.locked_category'))
      <div class="form-group">
        <span class="switch">Active</span>
        {{ Form::hidden('publish', true) }}
      </div>
      @else 
      <div class="form-group">
        <div class="switch-box">
          <span class="switch-label">Active</span>
  
              <label class="switch">
                  {{ Form::hidden('publish', false) }}
  
                  @if(isset($category) && $category->publish == '1' || old('publish'))
                      <input type="checkbox" name="publish" checked>
                  @else
                      <input type="checkbox" name="publish">
                  @endif
                  <span class="slider round"></span>
              </label>
          </div>
        </div>
      @endif
      
    </div>

   

    <div class="card-footer mobile_submit">
      {!! Form::submit('Submit',['class' => 'btn btn-primary']) !!}

      <a href="{!! route('cms::categories.index') !!}" title="Cancel" class="btn btn-danger cancel-btn">Cancel</a>
    </div>
  </div>
</div>
<!--</right side bar>-->