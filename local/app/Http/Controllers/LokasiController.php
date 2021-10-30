<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;
use Illuminate\Database\QueryException;

class LokasiController extends BaseController
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
		return view('tabel-lokasi', $data);
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
				(   LOWER (a.id) LIKE '%".$yangdicari."%'
				 OR LOWER (a.nm_lokasi) LIKE '%".$yangdicari."%'
				 OR LOWER (a.ket_lokasi) LIKE '%".$yangdicari."%'
				)
			";
		}
		
		$rows = DB::select("
			   select a.id, a.nm_lokasi, a.ket_lokasi
			    from r_lokasi a
			   where aktif = 'y' ".$paramcari."
			order by id asc
		");

		$collection = collect($rows);
		
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('kode', function($row){
								return $row->id;
							})
						->addColumn('lokasi', function($row){
								return $row->nm_lokasi;
							})
						->addColumn('keterangan', function($row){
								return $row->ket_lokasi;
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
			select '' AS id, '' AS nm_lokasi, '' AS ket_lokasi
		");
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 1,
		];
		return view('ruh-lokasi', $data);
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
			'nm_lokasi.required' => 'nama lokasi wajib diisi'
		];
		
		$validator = Validator::make($request->all(), [
			'nm_lokasi' => 'required|min:3',
		], $messages);

		if($validator->fails()) {
			
			return redirect('ref/lokasi/create')
				->withErrors($validator)
				->withInput();
				
		} else {

			if($request->is_add == 1) {

				$insert = DB::insert("
					insert into r_lokasi (nm_lokasi, ket_lokasi, aktif) values (?, ?, ?)
				", [
					$request->nm_lokasi,
					$request->ket_lokasi,
					'y',
				]);
				
			} else {
				$update = DB::update("
					update r_lokasi
					   set nm_lokasi = ?
					       ket_lokasi = ?
					 where id = ?
				", [
					$request->nm_lokasi,
					$request->ket_lokasi,
					$request->inp_id
				]);
			}
			return redirect('ref/lokasi/show');
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
			  from r_lokasi
			 where id = ?
		", [$id]);

		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 0,
		];
		
		return view('ruh-lokasi', $data);
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
			update r_lokasi
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
	public function opsi()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$rows = DB::select("
			  select id, nm_lokasi
			    from r_lokasi
			order by id asc
		");

		$data = [
			'rows' => $rows,
		];

		$html_out = '<option value="">Pilih</option>';
		$html_out .= view('opsi-lokasi', $data);

		return $html_out;
	}
}
