<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\ChkLogin;

//~ Route::get('/', function () {
    //~ return view('welcome');
//~ });

Route::get('/token', function() {

	return csrf_token();
	
});

Route::get('/', 'LoginController@index');
Route::post('/login', 'LoginController@authentication');
Route::post('/logout', 'LoginController@logout');
Route::get('/beranda', 'HomeController@index');
Route::get('/baseurl', 'LoginController@baseurl');


Route::group(['prefix' => 'simpan'], function(){
	
	Route::get('show', 'SimpanController@show');
	Route::get('tabel', 'SimpanController@tabel');
	Route::get('create', 'SimpanController@create');
	Route::get('pilih/{id}', 'SimpanController@pilih');
	Route::post('simpan', 'SimpanController@simpan');
	Route::post('hapus', 'SimpanController@hapus');
	Route::get('opsi', 'SimpanController@opsi');
	Route::get('cari', 'SimpanController@cari');
	Route::get('cek/{param}', 'SimpanController@cek');
		
});

Route::group(['prefix' => 'input'], function(){
	
	Route::get('show', 'InputController@show');
	Route::get('tabel', 'InputController@tabel');
	Route::get('create', 'InputController@create');
	Route::get('pilih/{id}', 'InputController@pilih');
	Route::post('simpan', 'InputController@simpan');
	Route::post('hapus', 'InputController@hapus');
	Route::get('opsi', 'InputController@opsi');
	Route::get('cari', 'InputController@cari');
	Route::get('cek/{param}', 'InputController@cek');
	Route::get('getby/{param}', 'InputController@getBy');
	
});

Route::group(['prefix' => 'keluar'], function(){
	
	Route::get('show', 'KeluarController@show');
	Route::get('tabel', 'KeluarController@tabel');
	Route::get('create', 'KeluarController@create');
	Route::get('pilih/{id}', 'KeluarController@pilih');
	Route::post('simpan', 'KeluarController@simpan');
	Route::post('hapus', 'KeluarController@hapus');
	Route::post('cari', 'KeluarController@cari');
	
});

Route::group(['prefix' => 'saldo'], function(){
	
	Route::get('show', 'SaldoController@show');
	Route::get('tabel', 'SaldoController@tabel');
	
});

Route::group(['prefix' => 'ref'], function(){
	
	Route::group(['prefix' => 'barang'], function(){
		
		Route::get('token', 'HomeController@token');
		Route::get('show', 'BarangController@show');
		Route::get('create', 'BarangController@create');
		Route::get('tabel', 'BarangController@tabel');
		Route::get('pilih/{id}', 'BarangController@pilih');
		Route::get('cek/{param}', 'BarangController@cek');
		Route::post('simpan', 'BarangController@simpan');
		Route::post('hapus', 'BarangController@hapus');
		Route::post('upload-skema', 'BarangController@uploadSkema');
		Route::post('upload-gambar', 'BarangController@uploadGambar');
		Route::get('opsi', 'BarangController@opsi');
		Route::get('cari', 'BarangController@cari');
		
	});
	
	Route::group(['prefix' => 'lokasi'], function(){
		
		Route::get('show', 'LokasiController@show');
		Route::get('tabel', 'LokasiController@tabel');
		Route::get('create', 'LokasiController@create');
		Route::get('pilih/{id}', 'LokasiController@pilih');
		Route::post('simpan', 'LokasiController@simpan');
		Route::post('hapus', 'LokasiController@hapus');
		Route::get('opsi', 'LokasiController@opsi');
		
	});
	
});

