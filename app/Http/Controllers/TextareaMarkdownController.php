<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TextareaMarkdownController extends Controller
{
    public function write(Request $request): View
    {
        return view('components.markdown.write', [
            'preview' => $request->input('body'),
        ]);
    }

    public function preview(Request $request): View
    {
        $preview = $request->input('body') ? StringHelper::parse($request->input('body')) : '';

        return view('components.markdown.preview', [
            'preview' => $preview,
        ]);
    }
}
