<?php
namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalsController extends Controller
{
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
                    return view('news.journals', ['journals' => $journals]);
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
    
}
