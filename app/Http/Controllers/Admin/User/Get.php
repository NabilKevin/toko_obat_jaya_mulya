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
        $from = ($users->currentPage() - 1) * $users->perPage() + 1;
        $roleColors = [
            'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            'kasir' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        ];

        return view('admin.user.index',
            [
                'users' => $users,
                'total' => $users->total(),
                'from' => $from > $users->total() ? $from-1 : $from,
                'to' => $from - 1 + $users->count(),
                'roleColors' => $roleColors,
                'isFirstPage' => $users->onFirstPage(),
                'isLastPage' => $users->onLastPage(),
                'currentPage' => $users->currentPage(),
                'firstPage' => $users->url(1),
                'lastPage' => $users->url($users->lastPage()),
                'nextPage' => $users->nextPageUrl(),
                'prevPage' => $users->previousPageUrl(),
                'search' => $search
            ]
        );
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
