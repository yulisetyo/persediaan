<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;

class HomeController extends BaseController
{
    /**
	 * description 
	 */
	public function index()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$data = [
			'baseurl' => URL::to('/'),
		];
		return view('dashboard', $data);
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

	/**
	 * description 
	 */
	public function tabelRUH()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$data = [
			'baseurl' => URL::to('/'),
		];
		return view('ruh-persediaan', $data);
	}

	/**
	 * description 
	 */
	public function dataRUH()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$rows = DB::select("
			select id, kd_barang, nm_barang, deskripsi, hrg_satuan, kuantitas, nm_file_skema, nm_file_gambar
			from d_persediaan
			order by id asc
		");

		$collection = collect($rows);
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('barang', function($row){
								return $row->id." - ".$row->nm_barang;
							})
						->addColumn('satuan', function($row){
								return number_format($row->hrg_satuan, 0, ',', '.');
							})
						->addColumn('satuan', function($row){
								return number_format($row->kuantitas, 0, ',', '.');
							})
						->addColumn('niltrans', function($row){
								$niltrans = (int) $row->hrg_satuan * (int) $row->kuantitas;
								return number_format($niltrans, 0, ',', '.');
							})
						->addColumn('aksi', function($row){
								return '
									<a class="btn btn-xs btn-warning ubah">ubah</a>
									<a class="btn btn-xs btn-default hapus">ubah</a>
								';
							})
						
						->make(true);
		return $datatables;
	}

	/**
	 * description 
	 */
	public function simpanRUH(Request $request)
	{
		
	}

	/**
	 * description 
	 */
	public function uploadSkema(Request $request)
	{
		return $request->file;
	}

	/**
	 * description 
	 */
	public function uploadGambar()
	{
		
	}
}
