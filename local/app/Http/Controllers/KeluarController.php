<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;

class KeluarController extends BaseController
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
		return view('tabel-keluar', $data);
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
				 OR LOWER (a.keterangan) LIKE '%".$yangdicari."%'
				 OR LOWER (a.hrg_satuan) LIKE '%".$yangdicari."%'
				 OR LOWER (a.kuantitas) LIKE '%".$yangdicari."%'
				 OR LOWER (b.nm_barang) LIKE '%".$yangdicari."%'
				 OR LOWER (a.hrg_satuan * a.kuantitas) LIKE '%".$yangdicari."%'
				)
			";
		}
		
		$rows = DB::select("
			  select a.id, a.kd_barang, a.hrg_satuan, a.kuantitas, (a.hrg_satuan * a.kuantitas) nilai, a.keterangan, b.nm_barang
			    from d_persediaan a
			    left join
				     r_barang b on (a.kd_barang = b.kd_barang)
			   where a.jtrn = 'k' and a.aktif = 'y' ".$paramcari."
			order by a.id 
		");

		$collection = collect($rows);
			
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('barang', function($row){
							$obj = new BarangController();
								return $row->kd_barang." - ".$obj->getBarang($row->kd_barang)->nm_barang;
							})
						->addColumn('satuan', function($row){
							$utl = new UtilitasController();
								return $utl->angka($row->hrg_satuan);
							})
						->addColumn('kuantitas', function($row){
							$utl = new UtilitasController();
								return $utl->angka($row->kuantitas);
							})
						->addColumn('nilai', function($row){
							$utl = new UtilitasController();
								return $utl->angka($row->nilai);
							})
						->addColumn('keterangan', function($row){
								return $row->keterangan;
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
			select '' AS id, '' AS kd_barang, '' AS hrg_satuan, '' AS kuantitas, '' AS keterangan
		");
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 1,
		];
		return view('ruh-keluar', $data);
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
			'hrg_satuan.required' => 'harga satuan wajib diisi',
			'hrg_satuan.numeric' => 'harga satuan harus numeric',
			'kuantitas.required' => 'kuantitas wajib diisi',
			'kuantitas.numeric' => 'kuantitas harus numeric',
		];
		
		$validator = Validator::make($request->all(), [
			'kd_barang' => 'required',
			'hrg_satuan' => 'required|numeric',
			'kuantitas' => 'required|numeric',
		], $messages);

		if($validator->fails()) {
			
			return redirect('keluar/create')
				->withErrors($validator)
				->withInput();
				
		} else {
			//insert or update
			if($request->is_add == 1) {

				$insert = DB::insert("
					insert into d_persediaan (kd_barang, hrg_satuan, kuantitas, keterangan, jtrn) values (?, ?, ?, ?, ?)
				", [
					$request->kd_barang,
					$request->hrg_satuan,
					$request->kuantitas,
					$request->keterangan,
					'k'
				]);
				
			} else {
				
				$update = DB::update("
					update d_persediaan
					   set kd_barang = ?,
					       hrg_satuan = ?,
					       kuantitas = ?,
					       keterangan = ?
					 where id = ?
				", [
					$request->kd_barang,
					$request->hrg_satuan,
					$request->kuantitas,
					$request->keterangan,
					$request->inp_id
				]);
				
			}
		}
		
		return redirect('/keluar/show');
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
			  from d_persediaan
			 where aktif = 'y' and id = ?
		", [$id]);

		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 0,
		];
		
		return view('ruh-keluar', $data);
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
			update d_persediaan
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
	public function saldo($kdbarang)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		}
		
		DB::select("
			SELECT a.kd_barang,
				   b.nm_barang,
				   a.jml_masuk,
				   a.jml_keluar,
				   a.jml_saldo
			FROM   (SELECT kd_barang,
						   SUM(IF(jtrn = 'm', kuantitas, 0))
								  jml_masuk,
						   SUM(IF(jtrn = 'k', kuantitas, 0))
								  jml_keluar,
						   SUM(IF(jtrn = 'm', kuantitas, 0) - IF(jtrn = 'k', kuantitas, 0))
								  jml_saldo
					FROM   d_persediaan
					WHERE  kd_barang = ? AND aktif = 'y'
					GROUP  BY kd_barang) a
				   left join r_barang b
						  ON a.kd_barang = b.kd_barang
			WHERE 
			ORDER  BY kd_barang ASC
		", [$kdbarang]);
	}
}

