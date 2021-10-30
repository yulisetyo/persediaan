<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;
use Illuminate\Database\QueryException;

class SimpanController extends BaseController
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
		return view('tabel-simpan', $data);
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
				 OR LOWER (b.nm_barang) LIKE '%".$yangdicari."%'
				 OR LOWER (c.nm_lokasi) LIKE '%".$yangdicari."%'
				 OR LOWER (c.ket_lokasi) LIKE '%".$yangdicari."%'
				 OR LOWER (a.ket_simpan) LIKE '%".$yangdicari."%'
				)
			";
		}
		
		$rows = DB::select("
			  select a.id, a.kd_barang, b.nm_barang, a.kd_lokasi, c.nm_lokasi, c.ket_lokasi, a.ket_simpan
			    from (select * from r_simpan where aktif = 'y') a
			    left join
					 r_barang b on (a.kd_barang = b.kd_barang)
				left join
				     r_lokasi c ON (a.kd_lokasi = c.id)
			   where a.aktif = 'y' ".$paramcari."
			order by a.kd_barang asc
		");

		$collection = collect($rows);
			
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('barang', function($row){
								return $row->kd_barang." - ".$row->nm_barang;
							})
						->addColumn('lokasi', function($row){
								return $row->kd_lokasi." - ".$row->nm_lokasi;
							})
						->addColumn('ketsimpan', function($row){
								return $row->ket_simpan;
							})
						->addColumn('aksi', function($row){
								return '
									<div id="'.$row->id.'" class="btn btn-xs btn-warning ubah"><i class="glyphicon glyphicon-edit"></i> </div>
									<div id="'.$row->id.'" class="btn btn-xs btn-default hapus"><i class="glyphicon glyphicon-trash"></i> </div>
								';
							})
						->make(true);
						
		return $datatables;
	}

	/**
	 * description 
	 */
	public function create()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$rows = DB::select("
			select '' AS id, '' AS kd_barang, '' AS kd_lokasi, '' AS ket_simpan
		");
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 1,
		];
		return view('ruh-simpan', $data);
	}

	/**
	 * description 
	 */
	public function simpan(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$messages = [
			'kd_barang.required' => 'kode barang wajib diisi',
			'kd_lokasi.required' => 'kode lokasi wajib diisi',
			'kd_barang.min:3' => 'wajib diisi setidaknya 3 karakter',
		];
		
		$validator = Validator::make($request->all(), [
			'kd_barang' => 'required|min:3',
			'kd_lokasi' => 'required',
		], $messages);

		$cek = DB::select("SELECT * FROM r_simpan WHERE kd_barang = ?", [$request->kd_barang]);

		if($validator->fails()) {
			
			return redirect('simpan/create')
				->withErrors($validator)
				->withInput();
				
		} else {

			if($request->is_add == 1) {

				$insert = DB::insert("
					insert into r_simpan (kd_barang, kd_lokasi, ket_simpan) values (?, ?, ?)
				", [
					$request->kd_barang,
					$request->kd_lokasi,
					$request->ket_simpan
				]);
				
			} else {
				
				$update = DB::update("
					update r_barang
					   set kd_barang = ?,
					       kd_lokasi = ?,
					       ket_simpan = ?
					 where id = ?
				", [
					$request->kd_barang,
					$request->kd_lokasi,
					$request->ket_simpan,
					$request->inp_id
				]);
				
			}

			return redirect('/simpan/show');
		}
	}

	/**
	 * description 
	 */
	public function pilih($id)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$rows = DB::select("
			select *
			  from r_simpan
			 where aktif = 'y' and id = ?
		", [$id]);

		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 0,
		];
		
		return view('ruh-simpan', $data);
	}

	/**
	 * description 
	 */
	public function hapus(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$delete = DB::update("
			update r_simpan
			   set aktif = 'n'
			 where id = ?
		", [$request->id]);

		if($delete==true) {
			return "success";
		} else {
			return "gagal menghapus data";
		}
	}

	/**
	 * description 
	 */
	public function cek($param)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$rows = DB::select("
			select * from r_simpan
			 where kd_barang = ? and aktif = 'y'
		", [$param]);

		if(count($rows) > 0) {
			return "failed";
		} else {
			return "success";
		}
	}

	/**
	 * description 
	 */
	public function opsi()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		$rows = DB::select("
			  select id, kd_barang
			    from r_simpan
			order by kd_barang asc
		");

		$obj = new BarangController();

		$data = [
			'obj' => $obj,
			'rows' => $rows,
		];

		$html_out = '<option value="">Pilih</option>';
		$html_out .= view('opsi-simpan', $data);

		return $html_out;
	}
}
