<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $minutes = 60;
        $forecast = Cache::remember('forecast', $minutes, function () {
            Log::info("Not from cache");
            $app_id = config("here.app_id");
            $app_code = config("here.app_code");
            $lat = config("here.lat_default");
            $lng = config("here.lng_default");
            $url = "https://weather.api.here.com/weather/1.0/report.json?product=forecast_hourly&latitude=${lat}&longitude=${lng}&oneobservation=true&language=it&app_id=${app_id}&app_code=${app_code}";
            Log::info($url);
            $client = new \GuzzleHttp\Client();
            $res = $client->get($url);
            if ($res->getStatusCode() == 200) {
                $j = $res->getBody();
                $obj = json_decode($j);
                $forecast = $obj->hourlyForecasts->forecastLocation;
            }
            return $forecast;
        });
        return view('forecastview', ["forecast" => $forecast]);
    }
}
