<div class="col-md-9 col-sm-8 col-xs-12">
  <div class="card">
    <div class="card-body">
      <div class="form-group">
          {!! Form::label('question','Question') !!}
          {!! Form::text('question',null,['class' => 'form-control', 'id' => 'question', 'placeholder' => "Enter Question" ]) !!}
      </div>
     
      <div class="form-group">
          {!! Form::label('content',"Answer") !!}
          {!! Form::textarea('answer',null,['class'=>'textarea form-control','id'=>'content','placeholder'=>'Enter Answer']) !!}
      </div>
   
    </div>

    <div class="card-footer">
        {!! Form::submit('Submit',['class' => 'btn btn-primary', 'id' => 'submit_btn']) !!}
        <a href="{!! route('cms::faqs.index') !!}" title="Cancel" class="btn btn-danger cancel-btn">Cancel</a>
    </div>

  </div>
</div>
<!--</add news>-->

<!--<right side bar>-->
<div class="col-md-3 col-sm-4 col-xs-12 right-side-bar">
  <div class="card card-default">
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
                @if(isset($faq) && $faq->publish == '1' || old('publish'))
                    <input type="checkbox" name="publish" checked>
                @else
                    <input type="checkbox" name="publish">
                @endif
                <span class="slider round"></span>
            </label>
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('sort-order','Display Order') !!}
        {!! Form::number('sort_order',null,['class' => 'form-control', 'id' => 'sort-order', 'placeholder' => "Lowest number placed first" ]) !!}
      </div>
    </div>
    <!-- /.box-body -->
  </div>

 
</div>
<!--</right side bar>-->
