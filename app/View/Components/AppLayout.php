<?php

namespace App\View\Components;

use App\ViewModels\Layout\LayoutViewModel;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function render(): View
    {
        return view('layouts.app')
            ->with('user', LayoutViewModel::data(auth()->user()));
    }
}
