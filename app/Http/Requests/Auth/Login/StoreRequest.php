<?php

namespace App\Http\Requests\Auth\Login;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{ 
  public function rules()
  {
    return [
      'username' => 'required',
      'password' => 'required',
    ];
  }
}