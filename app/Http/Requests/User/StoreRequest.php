<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
  public function rules()
  {
    return [
      'nama' => 'required|max:100',
      'username' => 'required|max:50|unique:user,username',
      'password' => 'required|min:8|max:255|confirmed',
      'role' => 'required|in:admin,kasir'
    ];
  }
}