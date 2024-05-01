<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
    	$value = json_decode($_COOKIE['user']);
    	$data = $this->getUser($value->uuid);
    	// dd(json_decode($data));
    	$user = json_decode($data);
        return view('dashboard', compact('user'));
    }

	public function getUser($id)
	{
	    $response = Http::withHeaders($this->httpHeaders)
	      ->withOptions(['verify' => false])
	      ->withToken($_COOKIE['access-token'])
	      ->get(config('app.api_url') . "user/$id");

	    return $response;
	}
}
