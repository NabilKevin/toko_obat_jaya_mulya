<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;

class Put extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with("error","User tidak ditemukan!");
        }
        if($data['username'] !== $user->username) {
            $rule = [
                'username'=> 'unique:user,username',
            ];
            $data = $request->validate($rule);
        }

        $filtered = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        if(array_key_exists('password', $filtered)) {
            $filtered['password'] = bcrypt($filtered['password']);
        }

        $user->update($filtered);

        return redirect()->route('user.index')->with('success', 'User berhasil diedit!');
    }
}
