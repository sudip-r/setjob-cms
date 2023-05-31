@extends("frontend.layouts.master")

@section("content")
<div class="__inner_search">
  <h3>Profile</h3>

  <div class="__breadcrumbs">
      <ul>
          <li><a href="{{route('home')}}">Home</a> / </li>
          <li>Profile</li>
      </ul>
  </div>
</div>


<div class="__main_content container">
  <div class="row __job_lists">
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="__dashboard_links">
              <ul>
                  <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                  <li class="active">Profile</li>
                  <li><a href="{{route('dashboard.jobs')}}">Jobs</a></li>
                  <li><a href="{{route('dashboard.employee.settings')}}">Settings</a></li>
                  <li><a href="{{route('logout')}}">Logout</a></li>
              </ul>
          </div>
      </div>
      <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <form method="post" action="{{route('employee.update.profile')}}" id="employer-profile-update" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <input type="hidden" name="id" value="{{$user->id}}" />
        <div class="__job_list_title __relative">
          <h3>Basic Details</h3>
          <div class="__post_job_wrapper">
          <a class="__post_job" href="{{route('employee.detail', ['user' => $slug])}}" target="_blank"><i class="fa fa-eye"></i> Profile</a>
          </div>
        </div>
        <div class="__about_wrapper">
            <div class="__profile_form __relative">
                <label for="profile-upload">Profile Image <em>[Recommended size: 250x250 px]</em></label>
                <div class="__err_abs __err_abs_left" id="logo-err"></div>
                <img class="__profile_upload_img" id="profile-image-box" src="{{upath('uploads/users/'.$user->profile_image)}}">
                <input type="file" name="profile_image" id="profile-upload" class="__form_input">
            </div>
            <div class="__profile_form __relative">
                <label for="name">Full name</label>
                <div class="__err_abs" id="name-err"></div>
                <input type="text" name="name" id="name" class="__form_input" placeholder="Full name" value="{{$user->name}}">
            </div>

            <div class="__profile_form __relative">
              <label for="title">Title</label>
              <div class="__err_abs" id="title-err"></div>
              <input type="text" name="title" id="title" class="__form_input" placeholder="Your Title" value="{{$user->title}}">
            </div>

            <div class="__profile_form __relative">
                <label for="email">Email</label>
                <div class="__err_abs" id="email-err"></div>
                <input type="text" name="email" id="email" class="__form_input" placeholder="Email" value="{{$user->email}}">
            </div>
            {{-- <div class="__profile_form __relative">
                <label for="address">Address</label>
                <div class="__err_abs" id="address-err"></div>
                <input type="text" name="address" id="address" class="__form_input" placeholder="Address" value="{{$user->profile()->address}}">
            </div> --}}
            <div class="__profile_form __relative">
                <label for="city">City</label>
                <div class="__err_abs" id="city-err"></div>
                <select id="city" class="__select_ajax" name="city_id">
                  @if($user->city()->id != 0 || $user->city()->id != "")
                    <option value="{{$user->city()->id}}">{{$user->city()->name}}</option>
                  @else
                    <option value="0">Choose City</option>
                  @endif
                </select>
            </div>
            <div class="__profile_form __relative">
                <label for="postcode">Post Code</label>
                <div class="__err_abs" id="postcode-err"></div>
                <input type="text" name="postal_code" id="postcode" class="__form_input" placeholder="Postcode" value="{{$user->profile()->postal_code}}">

            </div>
            <div class="__profile_form __relative">
                <label for="contact">Contact</label>
                <div class="__err_abs" id="contact-err"></div>
                <input type="text" name="contact" id="contact" class="__form_input" placeholder="Contact" value="{{$user->profile()->contact}}">
            </div>

            <div class="__profile_form __relative">
                <label for="website">Website</label>
                <div class="__err_abs" id="website-err"></div>
                <input type="text" name="mobile" id="website" class="__form_input" placeholder="Website" value="{{$user->profile()->mobile}}">
            </div>

            <div class="__profile_form __relative">
              <label for="cv">Upload CV</label>
                <div class="__err_abs" id="cv-err"></div>
                @if($user->profile()->contact_person != "")
                <a target="_blank" class="__cv_img" id="cv-box" href="{{fpath('uploads/users/'.$user->profile()->contact_person)}}">
                  <img src="{{mpath('front/assets/images/pdf.png')}}" />
                </a>
                @endif
                <input type="file" name="contact_person" id="cv" class="__form_input">
            </div>

            <div class="__profile_form __relative">
              <label for="portfolio">Portfolio Images <em>(Maximum 8 images)</em></label>
              @if($user->profile()->categories != "")
              @php $portfolios = json_decode($user->profile()->categories) @endphp
                <div class="__portfolio_display">
                  <ul>
                    @foreach($portfolios as $portfolio)
                      <li><img src="{{mpath('uploads/users/'.$user->id.'/'.$portfolio)}}" /></li>
                    @endforeach
                  </ul>
                </div>
                <div class="__clear"></div>
              @endif
                <div class="__err_abs" id="portfolio-err"></div>
                <input type="file" name="categories[]" id="portfolio" class="__form_input" multiple>
            </div>  
                    

        </div>
          <div class="__gap_30"></div>
          <div class="__job_list_title __relative">
            <h3>Socials</h3>
          </div>
          <div class="__about_wrapper">
              <div class="__profile_form">
                  <label for="linkedin">Linkedin</label>
                  <input type="text" name="linkedin" id="linkedin" class="__form_input" placeholder="Linkedin link" value="{{$user->profile()->linkedin}}">
              </div>
              <div class="__profile_form">
                <label for="twitter">Twitter</label>
                <input type="text" name="twitter" id="twitter" class="__form_input" placeholder="Twitter link" value="{{$user->profile()->twitter}}">
            </div>
            <div class="__profile_form">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" id="facebook" class="__form_input" placeholder="Facebook link" value="{{$user->profile()->facebook}}">
            </div>
            <div class="__profile_form">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram" class="__form_input" placeholder="Instagram link" value="{{$user->profile()->instagram}}">
            </div>
              
              
          </div>
          <div class="__gap_30"></div>
          <div class="__job_list_title __relative">
            <h3>About</h3>
          </div>
          <div class="__about_wrapper">
              <div class="__profile_form">
                  <label for="about">About Me</label>
                  <textarea name="summary" id="about" class="__form_input __textarea" placeholder="Write about yourself">{{$user->profile()->summary}}</textarea>
              </div>
             
              {{-- <div class="__profile_form">
                <label for="projects">Experience</label>
                <textarea name="description" id="projects" class="__form_input __textarea" placeholder="Write about your work experiences">{{$user->profile()->description}}</textarea>
              </div> --}}

              <div class="__profile_form">
                <label for="map">Qualifications and Skills</label>
                <textarea name="map" id="map" class="__form_input __textarea" placeholder="Mention your education background, any trainings and skills.">{{$user->profile()->map}}</textarea>
              </div>
              
            <div class="__profile_form">
                <div class="__save_btn_wrapper">
                    <input type="submit" id="profile-save-btn" value="Save" class="__post_job" />
                </div>
                <div class="__gap_30"></div>
            </div>
            
          </div>
          
          <div class="__gap_30"></div>
          <div class="__gap_30"></div>
        </form>
      </div><!--Col 9 -->
  </div>
</div> <!-- CONTENT -->
@endsection

@section('custom-scripts')

<script src="{{asset('cms/plugins/ckeditor5/build/ckeditor.js')}}"></script>
<script>
ClassicEditor.create(document.querySelector('#map'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});
ClassicEditor.create(document.querySelector('#about'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});

ClassicEditor.create(document.querySelector('#projects'), {

toolbar: {
  items: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'ImageResize',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    '-',
    'alignment',
    'findAndReplace',
    'fontColor',
    'fontSize',
    'htmlEmbed',
    'sourceEditing'
  ],
  shouldNotGroupWhenFull: true
},
language: 'en',
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:block',
    '|',
    'imageStyle:alignLeft',
    'imageStyle:alignCenter',
    'imageStyle:alignRight',
    '|',
    'resizeImage'
  ],
  styles: [
    'full',
    'alignLeft',
    'alignRight'
  ]
},
table: {
  contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells',
    'tableCellProperties',
    'tableProperties'
  ]
}
})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error('Oops, something went wrong!');
console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
console.warn('Build id: 1wenxz12z32c-nlfnsv4zz7h3');
console.error(error);
});
</script>
@endsection

@section('custom-styles')
<link href="{{asset('cms/plugins/ckeditor5/build/style.css')}}" rel="stylesheet" />
@endsection