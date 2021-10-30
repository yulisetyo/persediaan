@extends('template')

@section('title', 'RUH Lokasi')

@section('sidebar')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<div class="well">
	<h3>Referensi Lokasi</h3>
	<div>
		<ul>
		<?php
			foreach ($errors->all() as $message) {
				echo '<li><span class="label label-danger">'.$message.'</span></li>';
			}
		?>
		</ul>
	</div>
	
	<div>
		<?php
			if(isset($psn_error)) {
				echo '<span class="label label-danger">'.$psn_error.'</span>';
			} 
		?>
	</div>

	<div class="panel panel-warning" id="div_form">
		<div class="panel-heading">
			<h3 class="panel-title">Form RUH Lokasi Barang</h3>
		</div>
		<div class="panel-body">
			<form action="{{$baseurl}}/ref/lokasi/simpan" method="post" class="form-horizontal" name="form_ruh" id="form_ruh" enctype="multipart/form-data">

				<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				<input type="hidden" name="is_add" id="is_add" value="{{$is_add}}" />
				<input type="hidden" name="inp_id" id="inp_id" value="{{$data->id}}" />
				<input type="hidden" name="baseurl" id="baseurl" value="{{$baseurl}}" />
				
				<div class="form-group">
					<label class="control-label col-sm-2">Nama Lokasi</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="nm_lokasi" name="nm_lokasi" placeholder="nama lokasi" value="{{$data->nm_lokasi}}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Keterangan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="ket_lokasi" name="ket_lokasi" placeholder="keterangan lokasi" value="{{$data->ket_lokasi}}" />
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2">&nbsp;</label>
					<div class="col-sm-3">
						<button class="btn btn-warning" id="simpan" type="submit" name="simpan">Simpan</button>
						<a href="{{$baseurl}}/ref/lokasi/show" class="btn btn-default" type="cancel" name="batal">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var baseurl = jQuery('#baseurl').val();
		
	});
</script>

@endsection
