<div class="col-md-9 col-sm-8 col-xs-12">
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        {!! Form::label('title','Job Title') !!}
        {!! Form::text('title',null,['class' => 'form-control', 'id' => 'job-name', 'placeholder' => "Enter Job title" ]) !!}
      </div>

      <div class="form-group">
        {!! Form::label('summary',"Summary") !!}
        {!! Form::textarea('summary',null,['class'=>'textarea form-control summary__box','id'=>'summary','placeholder'=>'Enter Summary (Short description)']) !!}
      </div>

      <input type="hidden" name="type" value="Job" />

      <div class="form-group">
        {!! Form::label('content',"Description") !!}

        {!! Form::textarea('description',null,['class'=>'textarea form-control','id'=>'content','placeholder'=>'Enter Description']) !!}
      </div>
    </div>

    <div class="card-body">
      <div class="form-group">
        {!! Form::label('responsibilities',"Responsibilities") !!}

        {!! Form::textarea('responsibilities',null,['class'=>'textarea form-control','id'=>'responsibilities','placeholder'=>'Job responsibilities']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('required-skills',"Requirements") !!}

        {!! Form::textarea('required_skills',null,['class'=>'textarea form-control','id'=>'required-skills','placeholder'=>'Skills / Education requirements of the job']) !!}
      </div>
    </div>

    <div class="card-footer">
      {!! Form::submit('Submit',['class' => 'btn btn-primary', 'id' => 'submit_btn']) !!}

      <a href="{!! route('cms::jobs.index') !!}" title="Cancel" class="btn btn-danger cancel-btn">Cancel</a>
    </div>

  </div>
</div>
<!--</add news>-->

<!--<right side bar>-->
<div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">

  <!-- Jobs -->
  <div class="card card-default jobs-box">
    <div class="card-header">
      <h3 class="card-title">Status</h3>
    </div>
    <div class="card-body">
      <!-- Minimal style -->

      <!-- radio -->
      <div class="form-group">
      <div class="switch-box">
        <span class="switch-label"><strong>Active</strong></span>

            <label class="switch">
                {{ Form::hidden('publish', false) }}

                @if(isset($job) && $job->publish == '1' || old('publish'))
                    <input type="checkbox" name="publish" checked>
                @else
                    <input type="checkbox" name="publish">
                @endif
                <span class="slider round"></span>
            </label>
        </div>
      </div>

      <div class="form-group">
          <div class="form-single">
          {!! Form::label('published_on','Published Date', ['class'=>'form-label']) !!}
          <input type="text" name="published_on" class="form-control" id="datetimepicker"
                          autocomplete="off" value="{!! $job->published_on ?? date('Y-m-d H:i') !!}"/>
          </div>
      </div>

      <div class="form-group">
        <div class="form-single">
        {!! Form::label('deadline','Valid till [Optional]', ['class'=>'form-label']) !!}
        <input type="text" name="deadline" class="form-control" id="deadline"
                        autocomplete="off" value="{!! $job->deadline ?? "" !!}"/>
        </div>
    </div>
      
    </div>
    <!-- /.box-body -->
  </div>


  <div class="card jobs-box mt-30">
    <div class="card-header">
      <h3 class="card-title">Job Type / Category</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        {!! Form::label('type',"Type") !!}
        {!! Form::select('type', ['Workshop' => 'Workshop', 'On Site' => 'On Site', 'Abroad' => 'Abroad', 'Various' => 'Various'], null, ['class' => 'form-control', 'id' => 'type']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('categories',"Category") !!}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'id' => 'categories']) !!}
      </div>
    </div>
  </div>

  <div class="card jobs-box mt-30">
    <div class="card-header">
      <h3 class="card-title">Salary</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        {!! Form::label('salary-min',"Minimum Salary") !!}
        {!! Form::number('salary_min', null, ['class' => 'form-control', 'placeholder' => 'Min Salary (£ per year)', 'id' => 'salary-min']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('salary-max',"Maximum Salary [Optional if fixed salary]") !!}
        {!! Form::number('salary_max', null, ['class' => 'form-control', 'placeholder' => 'Max Salary (£ per year)', 'id' => 'salary-max']) !!}
      </div>
    </div>
  </div>

  <div class="card jobs-box mt-30">
    <div class="card-header">
      <h3 class="card-title">Company and Location</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        {!! Form::label('user-id',"Employer / Company") !!}
        <select id="user-id" class="__select_ajax_employers" name="user_id">
          @if(isset($user))
            @if($user->id != 0 || $user->id != "")
            <option value="{{$user->id}}">{{$user->name}}</option>
            @else
              <option value="0">Choose Emplyer / Company</option>
            @endif
          @else
          <option value="0">Choose Emplyer / Company</option>
          @endif
        </select>
      </div>

      <div class="form-group">
        {!! Form::label('location',"Location [Optional if same location as Company]") !!}
        <select id="location" class="__select_ajax" name="location">
          @if(isset($user))
            @if($user->city()->id != 0 || $user->city()->id != "")
            <option value="{{$user->city()->id}}">{{$user->city()->name}}</option>
            @else
              <option value="0">Choose City</option>
            @endif
          @else
          <option value="0">Choose City</option>
          @endif
        </select>
      </div>
      
    </div>
  </div>

</div>
<!--</right side bar>-->
