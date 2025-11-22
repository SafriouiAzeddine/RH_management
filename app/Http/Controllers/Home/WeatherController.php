<?php
namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class WeatherController extends Controller
{
    public function weather()
{
    $apiKey = env('WEATHERSTACK_API_KEY');

    // Vérification de la récupération de la clé API
    if (!$apiKey) {
        return view('news.weather', ['error' => 'Clé API manquante.']);
    }

    // Construction de l'URL de l'API Weatherstack
    $response = Http::get("http://api.weatherstack.com/current?access_key={$apiKey}&query=Marrakech&units=m");

    // Débogage
    dd($response->json());

    if ($response->successful()) {
        $weather = $response->json();
        if (isset($weather['current'])) {
            return view('news.weather', ['weather' => $weather]);
        } else {
            $error = 'La réponse de l\'API n\'est pas au format attendu.';
            return view('news.weather', compact('error'));
        }
    } else {
        $error = 'Erreur lors de la récupération des données météo.';
        return view('news.weather', compact('error'));
    }
}


}

