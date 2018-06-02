<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
	public function index()
	{
		return view('welcome')->with('news', News::latest()->take(5)->get());
	}
}
