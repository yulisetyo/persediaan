<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilitasController extends BaseController
{
    /**
	 * description 
	 */
	public function angka($angka)
	{
		return number_format($angka,0,',','.');
	}
}
