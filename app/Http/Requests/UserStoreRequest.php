<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
  public function rules()
  {
    return [
      'nama' => 'required|max:100',
      'username' => 'required|max:50|unique:user,username',
      'password' => 'required|min:8|max:255',
      'role' => 'required|in:admin,kasir'
    ];
  }
}