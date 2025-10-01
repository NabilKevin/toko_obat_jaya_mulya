<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Models\User;

class Post extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }       
}
