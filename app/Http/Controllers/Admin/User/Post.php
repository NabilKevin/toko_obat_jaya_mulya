<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;

class Post extends Controller
{
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }       
}
