@extends('template')

@section('title', 'RUH Barang')

@section('sidebar')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<div class="well">
	<h3>Referensi Barang</h3>
	<div>
		<ul>
		<?php
			foreach ($errors->all() as $message) {
				echo '<li><span class="label label-danger">'.$message.'</span></li>';
			}
		?>
		</ul>
	</div>

	<div class="panel panel-warning" id="div_form">
		<div class="panel-heading">
			<h3 class="panel-title">Form RUH Referensi Barang</h3>
		</div>
		<div class="panel-body">
			<form action="{{$baseurl}}/ref/barang/simpan" method="post" class="form-horizontal" name="form_ruh" id="form_ruh" enctype="multipart/form-data">

				<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				<input type="hidden" name="is_add" id="is_add" value="{{$is_add}}" />
				<input type="hidden" name="inp_id" id="inp_id" value="{{$data->id}}" />
				
				<div class="form-group">
					<label class="control-label col-sm-2">Kode Barang</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="kd_barang" name="kd_barang" placeholder="kode barang" value="{{$data->kd_barang}}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Nama Barang</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="nm_barang" name="nm_barang" placeholder="nama barang" value="{{$data->nm_barang}}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Deskripsi Barang</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="deskripsi barang" value="{{$data->deskripsi}}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Ukuran</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="ukuran" name="ukuran" placeholder="ukuran" value="{{$data->ukuran}}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Berat</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="berat" name="berat" placeholder="berat" value="{{$data->berat}}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Skema</label>
					<div class="col-sm-3">
						<input type="file" class="form-control" id="nm_file_skema" name="nm_file_skema" placeholder="skema" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Gambar</label>
					<div class="col-sm-3">
						<input type="file" class="form-control" id="nm_file_gambar" name="nm_file_gambar" placeholder="gambar" />
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2">&nbsp;</label>
					<div class="col-sm-3">
						<button class="btn btn-warning" type="submit" name="simpan">Simpan</button>
						<a href="{{$baseurl}}/ref/barang/show" class="btn btn-default" type="cancel" name="batal">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.chosen').chosen().trigger('chosen:updated');
		jQuery('#kd_barang').focusout(function(){
			var param = jQuery(this).val();
			if(param != ''){
				jQuery.get('./../barang/cek/'+param, function(result){
					if(result == 'success') {
						jQuery('#simpan').prop('disabled', false);
					} else {
						alert("kode barang ini sudah pernah direkam sebelumnya");
						jQuery('#kd_barang').val('');
						jQuery('#kd_barang').focus();
						jQuery('#simpan').prop('disabled', true);
					}
				});
			}
		});
	})
</script>

@endsection
