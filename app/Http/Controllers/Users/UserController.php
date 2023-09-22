<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\ViewModels\Users\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function edit(Request $request): View
    {
        return view('user.edit', [
            'header' => UserViewModel::header($request->user),
            'view' => UserViewModel::edit($request->user),
        ]);
    }
}
