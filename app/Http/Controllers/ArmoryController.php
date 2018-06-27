<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArmoryController extends Controller
{
	public function index(Request $request)
	{
		return view('armory');
	}
}
