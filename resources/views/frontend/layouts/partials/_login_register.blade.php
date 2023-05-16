<div class="__modal_background __modal"></div>
<div class="__loading_box"></div>

<div class="__modal __login_register_box">
  <div class="__box_header">
    <div class="__login_title __active_title">Sign in</div>
    <div class="__register_title">Register</div>
    <div class="__close">X</div>
    <div class="__clear"></div>
  </div>

  <div class="__box_title">Sign in</div>

  <div class="__login_box">
    <div class="__gap"></div>
    <div class="__form_group">
      <div class="__err" id="login-email-err"></div>
      <input type="text" name="email" id="login-name" class="__form_input" placeholder="Email" />
    </div>
    <div class="__form_group">
      <div class="__err" id="login-password-err"></div>
      <input type="password" name="password" id="login-password" class="__form_input" placeholder="Password" />
    </div>
    <div class="__form_group __top_10">
        <input type="checkbox" name="remember_me" id="remember-me" class="__form_checkbox __remember_me">
      <label for="remember-me" class="__form_label __remember_label">
        Remember me
      </label>
      <a href="#" class="__forgot_pw"><strong>Forgot password?</strong></a>
    </div>
    <div class="__form_group __top_30 __b_30">
      <input type="submit" name="login_btn" id="login-btn" class="__form_btn" value="Sign in">
    </div>

    <div class="__form_message">
      <p>Don't have an account? <strong><a href="javascript:void(0);" class="__register_link">Register</a></strong></p>
    </div>
  </div>

  <div class="__register_box">
    <div class="__gap"></div>
    <div class="__register_step_1">
      <div class="__form_group">
        <div class="__err" id="register-email-err"></div>
        <input type="text" name="register_name" id="register-name" class="__form_input" placeholder="Email" />
      </div>
      <div class="__form_group">
        <div class="__err" id="register-password-err"></div>
        <input type="password" name="register_password" id="register-password" class="__form_input" placeholder="Password" />
      </div>
      <div class="__form_group __top_10 __mobile_left">
      <div class="__err" id="terms-err"></div>
      <input type="checkbox" name="agree_field" id="agree-field" class="__form_checkbox __remember_me __agree_field">
      <label for="agree-field" class="__form_label __remember_label __agree_label">
        I agree to the <a href="" target="_blank">Terms and Conditions</a> and <a href="" target="_blank">Privacy Policy</a>
      </label>
    </div>
      <div class="__form_group __top_30 __b_30">
        <input type="submit" name="register_btn" id="register-btn-one" class="__form_btn" value="Next">
      </div>
      <div class="__form_message">
        <p>Already with us? <strong><a href="javascript:void(0);" class="__login_link">Sign In</a></strong></p>
      </div>
    </div>
    <div class="__register_step_2">
      <div class="__form_group">
        <label for="register-contact-number">Are you an Employee or Employer?</label>
        <div class="__err" id="register-employee-employer-err"></div>
      </div>
      <div class="__form_half_group __top_10">
        <input type="radio" checked name="employee-check" id="employee-check" class="__form_checkbox __remember_me __agree_field" value="client">
        <label for="employee-check" class="__form_label __remember_label __agree_label">
          Employee
        </label>
      </div>

      <div class="__form_half_group __top_10 __ml_2per" >
        <input type="radio" name="employee-check" id="employer-check" class="__form_checkbox __remember_me __agree_field" value="business">
        <label for="employer-check" class="__form_label __remember_label __agree_label">
          Employer / Company
        </label>
      </div>

      <div class="__clear"></div>

      <div class="__form_group __top_20">
        <label for="register-full-name">Full name (Company name in case of Employer)</label>
        <div class="__err" id="register-fullname-err"></div>
        <input type="text" name="register_full_name" id="register-full-name" class="__form_input" placeholder="Full name" />
      </div>
      <div class="__form_group __top_20 __address_box" id="address-box">
        <label for="register-address-err">Street Address</label>
        <div class="__err" id="register-address-err"></div>
        <input type="text" name="register_street_address_1" id="register-street-address-1" class="__form_input" placeholder="House number and street name" />
        <br>
        <input type="text" name="register_street_address_2" id="register-street-address-2" class="__form_input __top_10" placeholder="Apartment, suit, unit etc." />
      </div>

      <div class="__form_half_group __top_20">
        <label for="register-town-city">Town / City</label>
        <div class="__err" id="register-town-err"></div>
        <select id="register-town-city" class="__select_ajax">
          <option value="0">Any</option>
        </select>
      </div>

      <div class="__form_half_group __ml_2per __top_20">
        <label for="register-post-code">Postcode</label>
        <div class="__err" id="register-post-code-err"></div>
        <input type="text" name="register_postal_code" id="register-post-code" class="__form_input" placeholder="Postcode" />
      </div>

      <div class="__clear"></div>

      <div class="__form_group __top_20">
        <label for="register-contact-number">Contact Number</label>
        <div class="__err" id="register-contact-number-err"></div>
        <input type="text" name="register_contact_number" id="register-contact-number" class="__form_input" placeholder="Contact Number" />
      </div>

      <div class="__form_group __top_20">
        <input type="submit" name="register_btn_final" id="register-btn-final" class="__form_btn" value="Register">
      </div>

      <div class="__form_group __top_20  __b_30">
        <input type="submit" name="register_btn_back" id="register-btn-back" class="__back_btn" value="Back">
      </div>

      

    </div>
  </div>
</div>