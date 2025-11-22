<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccueilController extends Controller
{
    public function index()
    {
        $images = [
            asset('images/bg1.jpg'),  // Image stockée localement
            asset('images/bg2.jpg'),
            asset('images/bg3.jpg')
        ];

        return view('welcome', compact('images'));
    }

    public function actualites()
    {
        return view('news.index');
    }

    public function actualitesEvenements()
    {
        return view('news.events');
    }

    public function actualitesJournaux()
    {
        return view('news.journals');
    }

    public function actualitesMeteo()
    {
        return view('news.weather');
    }

    public function about()
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

    public function contact()
    {
        return view('contact');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
}
