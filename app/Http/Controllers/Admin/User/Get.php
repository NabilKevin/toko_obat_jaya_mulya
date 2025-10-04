<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? $request->search :"";
        $users = User::whereLike('nama', "%$search%")->orWhereLike('username', "%$search%")->paginate(10);
        $roleColors = [
            'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            'kasir' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        ];
        $users->appends($request->query());

        return view('admin.user.index',compact('users','search','roleColors'));
    }

    public function create()
    {
        return view('admin.user.create');
    }
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with("error","User tidak ditemukan!");
        }
        return view('admin.user.edit', ['user'=> $user]);
    }
}
