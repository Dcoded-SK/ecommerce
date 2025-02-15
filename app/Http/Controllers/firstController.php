<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Genre;
use App\Models\orders;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class firstController extends Controller
{

    // to show home page

    public function home()
    {


        // get the genre whi
        $genres = Genre::with(["getBooks" => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereHas("getBooks")
            ->get();


        // get the most ordered book

        $mostOrderedBook = Books::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->first();






        return view('userFolder.index', compact("genres", "mostOrderedBook"));
    }


    public function temperature()
    {
        return view('temperature');
    }

    public function getTemperature(Request $request)
    {
        $request->validate([
            'place' => 'required|string',
        ]);

        $place = $request->input('place');
        $apiKey = '72708391f04c49cf910e6b4cd5228eda'; // Replace with your NewsAPI key
        $url = "https://newsapi.org/v2/everything?q={$place}&apiKey={$apiKey}";

        try {
            $client = new Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'ok') {
                $articles = $data['articles'];
                return view('temperature', compact('articles', 'place'));
            } else {
                return redirect()->route('home')->withErrors(['error' => 'Failed to fetch news.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
