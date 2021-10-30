<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Session;

class LoginController extends Controller
{
	/**
	 * write description here
	 */ 
	public function index()
	{
		if(session('authenticated') !== true){
			
			$data = [
				'baseurl' => URL::to('/'),
				'token' => csrf_token(),
			];
			
			return view('page-login', $data);
			
		} else {
			
			return redirect(URL::to('/beranda'));
			
		} 
	}
	
	
	/**
	 * write description here
	 */ 
	public function authentication(Request $request)
	{
		$username = $request->username;
		$password = $request->password;
		
		$chk1 = DB::select("
			select username, password, kd_level, aktif
			  from r_user
			 where username = ?
		",[$username]);

		$cnt = count($chk1);

		if(count($chk1) > 0) {

			if($chk1[0]->password == sha1(md5($password))) {

				if($chk1[0]->aktif == 'y') {

					session([
						'authenticated' => true,
						'username' => $username,
						'kd_level' => $chk1[0]->kd_level,
					]);

					return "success";
					
				} else {
					return "username tidak aktif";
				}
				
			} else {
				return "password tidak cocok";
			}
			
		} else {
			return "username tidak ditemukan";
		}

	}
	
	/**
	 * write description here
	 */ 
	public function logout(Request $request)
	{
		session([
			'authenticated' => false,
			'username' => null,
			'kd_level' => null,
		]);
		
		$request->session()->flush();

		return redirect(URL::to('/'));
	}
	
	/**
	 * description 
	 */
	public function token()
	{
		return csrf_token();
	}

	/**
	 * description 
	 */
	public function baseurl()
	{
		return URL::to('/');
	}
}
