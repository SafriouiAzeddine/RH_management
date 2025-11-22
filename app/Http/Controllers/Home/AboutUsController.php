<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('about.index');
    }

    public function provinceRhamna()
    {
        return view('about.provinceRhamna');
    }

    public function directeurRH()
    {
        return view('about.directeurRH');
    }

    public function divisionRH()
    {
        return view('about.divisionRH');
    }
}
