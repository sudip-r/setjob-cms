<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /**
   * Login
   * 
   * @param Request $request
   * @return Redirect
   */
  public function alterLogin(Request $request)
  {
    $this->validate($request, [
      'email'   => 'required|email',
      'password' => 'required|min:6'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      return response([
        'success' => 1,
        'message' => 'User logged in',
      ]);
    }

    return response([
      'success' => 0,
      'message' => 'The provided credentials do not match our records.',
    ]);
  }
}
