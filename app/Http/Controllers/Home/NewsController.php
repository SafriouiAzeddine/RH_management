<?php

namespace App\Http\Controllers\Home;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class NewsController extends Controller
{
    public function index()
    {
        return view('news.index');
    }

    public function events()
    {
        return view('news.events');
    }

    public function journals()
    {
        try {
            // Fetch RSS feed
            $rssFeed = Http::get('https://rss.app/fr/feed/ygkaR8JGJHDHVMah');
    
            // Debugging: Output the raw response body
            dd($rssFeed->body());
    
            if ($rssFeed->successful()) {
                $journals = simplexml_load_string($rssFeed->body());
    
                if ($journals !== false && isset($journals->channel->item)) {
                    return view('news.journals', compact('journals'));
                } else {
                    return view('news.journals')->with('error', 'Le flux RSS ne contient pas les journaux attendus.');
                }
            } else {
                return view('news.journals')->with('error', 'Erreur lors de la récupération des journaux.');
            }
        } catch (\Exception $e) {
            return view('news.journals')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function weather()
    {$apiKey = env('WEATHERSTACK_API_KEY');
        $city = 'Marrakech';

        if (!$apiKey) {
            return view('news.weather', ['error' => 'Clé API manquante.']);
        }

        $response = Http::get("http://api.weatherstack.com/current?access_key={$apiKey}&query={$city}&units=m");
        $weather = $response->json();

        if (isset($weather['current'])) {
            return view('news.weather', compact('weather'));
        } else {
            $error = 'La réponse de l\'API n\'est pas au format attendu.';
            return view('news.weather', compact('error'));
        }
        return view('news.weather');

    }

}

