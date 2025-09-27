<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
  public function rules()
  {
    return [
      'nama' => 'max:100',
      'username' => 'max:50',
      'password' => 'nullable|min:8|max:255|confirmed',
      'role' => 'in:admin,kasir'
    ];
  }
}