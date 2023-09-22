<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\CreateProject;
use App\Services\DestroyProject;
use App\Services\UpdateProject;
use App\ViewModels\Projects\ProjectViewModel;
use App\ViewModels\Users\UserViewModel;
use Illuminate\Http\RedirectResponse;
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
