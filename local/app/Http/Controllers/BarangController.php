<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use URL;
use DB;
use Datatables;
use Illuminate\Database\QueryException;

class BarangController extends BaseController
{
	/**
	 * description 
	 */
	public function create()
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$rows = DB::select("
			SELECT '' AS id, '' AS kd_barang, '' AS nm_barang, '' AS deskripsi, '' AS ukuran, '' AS berat, '' AS nm_file_skema, '' AS nm_file_gambar
		");
		
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 1,
		];
		return view('ruh-barang', $data);
	}

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
		return view('tabel-barang', $data);
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
				 OR LOWER (a.nm_barang) LIKE '%".$yangdicari."%'
				 OR LOWER (a.deskripsi) LIKE '%".$yangdicari."%'
				 OR LOWER (a.ukuran) LIKE '%".$yangdicari."%'
				 OR LOWER (a.berat) LIKE '%".$yangdicari."%'
				 OR LOWER (a.nm_file_skema) LIKE '%".$yangdicari."%'
				 OR LOWER (a.nm_file_gambar) LIKE '%".$yangdicari."%'
				)
			";
		}
		
		$rows = DB::select("
			  select id, a.kd_barang, a.nm_barang, a.deskripsi, a.ukuran, a.berat, a.nm_file_skema, a.nm_file_gambar, a.aktif
			    from r_barang a
			   where aktif = 'y' ".$paramcari."
			order by id asc
		");

		$collection = collect($rows);		
		$datatables = Datatables::of($collection)
						->addIndexColumn()
						->addColumn('barang', function($row){
								return $row->kd_barang."<br/>".$row->nm_barang;
							})
						->addColumn('deskripsi', function($row){
								return $row->deskripsi;
							})
						->addColumn('ukuran', function($row){
								return $row->ukuran;
							})
						->addColumn('berat', function($row){
								return $row->berat;
							})
						->addColumn('skema', function($row){
								$dirSkema = URL::to('/').'/img_skema/';
								return '<a href="'.$dirSkema.$row->nm_file_skema.'" target="_blank">'.$row->nm_file_skema.'</a>';
							})
						->addColumn('gambar', function($row){
								$dirGambar = URL::to('/').'/img_gambar/';
								return '<a href="'.$dirGambar.$row->nm_file_gambar.'" target="_blank">'.$row->nm_file_gambar.'</a>';
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
	public function simpan(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$messages = [
			'required' => ':attribute wajib diisi.',
		];
		
		$validator = Validator::make($request->all(), [
			'kd_barang' => 'required|min:3',
			'nm_barang' => 'required|min:2',
			'deskripsi' => 'required|min:6',
		], $messages);

		if($validator->fails()) {
			
			return redirect('ref/barang/create')
				->withErrors($validator)
				->withInput();
				
		} else {

			if($request->is_add == 1) {
				$acak = substr(md5(rand(1, 99)), 0, 6);
				
				$nmFileSkema = $_FILES['nm_file_skema']['name'];
				$nmFileSkemaTmp = $_FILES['nm_file_skema']['tmp_name'];
				$nmFileGambar = $_FILES['nm_file_gambar']['name'];
				$nmFileGambarTmp = $_FILES['nm_file_gambar']['tmp_name'];

				$newNmFileSkema = $request->kd_barang.'_'.$nmFileSkema;
				$newNmFileGambar = $request->kd_barang.'_'.$nmFileGambar;

				$dirSkema = 'img_skema/';
				$dirGambar = 'img_gambar/';

				$upldSkema = move_uploaded_file($nmFileSkemaTmp, $dirSkema.$newNmFileSkema);
				$upldGambar = move_uploaded_file($nmFileGambarTmp, $dirGambar.$newNmFileGambar);
				
				$insert = DB::select("
					insert into r_barang (kd_barang, nm_barang, deskripsi, ukuran, berat, nm_file_skema, nm_file_gambar, aktif)
						 values (?, ?, ?, ?, ?, ?, ?, ?)
				", [
					$request->kd_barang,
					$request->nm_barang,
					$request->deskripsi,
					$request->ukuran,
					$request->berat,
					$newNmFileSkema,
					$newNmFileGambar,
					'y'
				]);
				
			} else {
				
				$update = DB::update("
					update r_barang
					   set kd_barang = ?,
					       nm_barang = ?,
					       deskripsi = ?,
					       ukuran = ?,
					       berat = ?,
					       nm_file_skema = ?,
					       nm_file_gambar = ?
					 where id = ? AND aktif = 'y'
				", [
					$request->kd_barang,
					$request->nm_barang,
					$request->deskripsi,
					$request->ukuran,
					$request->berat,
					$_FILES['nm_file_skema']['name'],
					$_FILES['nm_file_gambar']['name'],
					$request->inp_id
				]);
				
			}

			return redirect('ref/barang/show');
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
			select id, kd_barang, nm_barang, deskripsi, ukuran, berat
			  from r_barang
			 where id = ?
		", [$id]);
		
		$data = [
			'baseurl' => URL::to('/'),
			'token' => csrf_token(),
			'data' => $rows[0],
			'is_add' => 0,
		];
		
		return view('ruh-barang', $data);
	}

	/**
	 * description 
	 */
	public function ubah(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$id = $request->inp_id;
		
		$update = DB::update("
			update r_barang
			   set kd_barang = ?,
			       nm_barang = ?,
			       deskripsi = ?,
			       ukuran = ?,
			       berat = ?,
			 where id = ?
		", [
			$request->kd_barang,
			$request->nm_barang,
			$request->deskripsi,
			$request->ukuran,
			$request->berat,
			$request->id
		]);

		if($update==true) {
			return "success";
		} else {
			return "gagal mengubah data barang";
		}
	}

	/**
	 * description 
	 */
	public function hapus(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		$dirSkema = 'img_skema/';
		$dirGambar = 'img_gambar/';
		
		$rows = DB::select("
			select kd_barang, nm_file_skema, nm_file_gambar
			  from r_barang
			 where id = ?
		", [$request->id])[0];

		if($this->cekHapus($rows->kd_barang) == true){

			unlink($dirSkema.$rows->nm_file_skema);
			unlink($dirGambar.$rows->nm_file_gambar);
		
			$delete = DB::update("
				delete from r_barang
				where id = ?
			", [
				$request->id
			]);

			if($delete==true) {
				return "success";
			} else {
				return "gagal menghapus data barang";
			}
			
		} else {
			
			return "data barang ini tidak dapat dihapus karena masih digunakan dalam persediaan";
			
		}
	}

	/**
	 * description 
	 */
	public function uploadSkema(Request $request)
	{
		if(session('authenticated') !== true){
			return redirect(URL::to('/'));
		} 
		
		return $_FILES['nm_file_skema']['name'];
		$target_dir = "/";
		$target_file = $target_dir . basename($_FILES["nm_file_skema"]["name"]);
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
			  select id, kd_barang, nm_barang
			    from r_barang
			   where aktif = 'y'
			order by kd_barang asc
		");

		$data = [
			'rows' => $rows,
		];

		$html_out = '<option value="">Pilih</option>';
		$html_out .= view('opsi-barang', $data);

		return $html_out;
	}

	/**
	 * description 
	 */
	public function cek($param)
	{
		$rows = DB::select("
			select *
			  from r_barang
			 where lower(kd_barang) = ? and aktif = 'y'
		", [strtolower($param)]);

		if(count($rows) > 0) {
			return "failed";
		} else {
			return "success";
		}
	}

	/**
	 * description 
	 */
	public function getBarang($kd_barang)
	{
		$rows = DB::select("
			  select distinct kd_barang, nm_barang
			    from r_barang
			   where kd_barang = ? and aktif = 'y'
		", [$kd_barang]);

		return $rows[0];
	}

	/**
	 * description 
	 */
	public function cekHapus($kd_barang)
	{
		$rows = DB::select("
			select *
			  from d_persediaan
			 where kd_barang = ?
		", [
			$kd_barang
		]);

		if(count($rows) == 0) {
			return true;
		} else {
			return false;
		}
	}
}
