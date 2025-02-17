<?php

namespace App\Http\Plugins\Front\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImageController extends Controller
{
    private Request $request;

    public function image(Request $request)
    {
        $this->request = $request;
        $action = $this->request->route('action');

        return match ($action) {
            'generate' => $this->generate(),
            default => $this->show(),
        };
    }

    private function show(): View
    {
        return view('front.pages.generate.main');
    }

    private function generate()
    {
        dd($this->request->all());
    }
}
