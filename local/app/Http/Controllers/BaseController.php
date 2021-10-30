<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use Session;

class BaseController extends Controller
{
	public function __construct()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
	}
}
