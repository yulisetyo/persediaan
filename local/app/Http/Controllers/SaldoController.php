<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;

class SaldoController extends Controller
{

    /**
	 * description 
	 */
	public function show()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
		];
		return view('tabel-saldo', $data);
	}

   	/**
	 * description 
	 */
	public function tabel()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$paramcari = "";
		if(isset($_GET['paramcari'])) {
			$yangdicari = htmlentities($_GET['paramcari']);
			$paramcari = "AND
				(   LOWER (a.kd_barang) LIKE '%".$yangdicari."%'
				 OR LOWER (a.jml_masuk) LIKE '%".$yangdicari."%'
				 OR LOWER (a.jml_keluar) LIKE '%".$yangdicari."%'
				 OR LOWER (a.jml_saldo) LIKE '%".$yangdicari."%'
				 OR LOWER (b.nm_barang) LIKE '%".$yangdicari."%'
				)
			";
		}
		
		$rows = DB::select("
			SELECT a.kd_barang,
				   b.nm_barang,
				   a.jml_masuk,
				   a.jml_keluar,
				   a.jml_saldo
			  FROM (SELECT kd_barang,
						   SUM(IF(jtrn = 'm', kuantitas, 0))
								  jml_masuk,
						   SUM(IF(jtrn = 'k', kuantitas, 0))
								  jml_keluar,
						   SUM(IF(jtrn = 'm', kuantitas, 0) - IF(jtrn = 'k', kuantitas, 0))
								  jml_saldo
					FROM   d_persediaan
					WHERE  aktif = 'y'
					GROUP  BY kd_barang) a
				   left join r_barang b
						  ON a.kd_barang = b.kd_barang
			WHERE a.kd_barang IS NOT NULL ".$paramcari."
			ORDER  BY kd_barang ASC
		");

		$collection = collect($rows);		
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('barang', function($row){
								return $row->kd_barang." - ".$row->nm_barang;
							})
						->addColumn('jml_masuk', function($row){
								return number_format($row->jml_masuk, 0, ',', '.');
							})
						->addColumn('jml_keluar', function($row){
								return number_format($row->jml_keluar, 0, ',', '.');
							})
						->addColumn('jml_saldo', function($row){
								return number_format($row->jml_saldo, 0, ',', '.');
							})
						->make(true);
		return $datatables;
	}
}
