@extends('template')

@section('title', 'RUH Simpan')

@section('sidebar')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<div class="well">
	<h3>Simpan Barang</h3>
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
			<h3 class="panel-title">Form RUH Simpan Barang</h3>
		</div>
		<div class="panel-body">
			<form action="{{$baseurl}}/simpan/simpan" method="post" class="form-horizontal" name="form_ruh" id="form_ruh" enctype="multipart/form-data">

				<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				<input type="hidden" name="is_add" id="is_add" value="{{$is_add}}" />
				<input type="hidden" name="inp_id" id="inp_id" value="{{$data->id}}" />
				<input type="hidden" name="baseurl" id="baseurl" value="{{$baseurl}}" />
				
				<div class="form-group">
					<label class="control-label col-sm-2">Barang</label>
					<div class="col-sm-6">
						<select class="form-control chosen" name="kd_barang" id="kd_barang">
							<option value="">Pilih</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Lokasi</label>
					<div class="col-sm-6">
						<select class="form-control chosen" name="kd_lokasi" id="kd_lokasi">
							<option value="">Pilih</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Keterangan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="ket_simpan" name="ket_simpan" placeholder="keterangan simpan" value="{{$data->ket_simpan}}" />
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2">&nbsp;</label>
					<div class="col-sm-3">
						<button class="btn btn-warning" id="simpan" type="submit" name="simpan">Simpan</button>
						<a href="{{$baseurl}}/simpan/show" class="btn btn-default" type="cancel" name="batal">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var baseurl = jQuery('#baseurl').val();
		
		jQuery('.chosen').chosen({width:'100%', search_contains: true});
		
		jQuery.get(baseurl+'/input/opsi', function(result){
			jQuery('#kd_barang').html(result).trigger('chosen:updated');
		});
		jQuery.get(baseurl+'/ref/lokasi/opsi', function(result){
			jQuery('#kd_lokasi').html(result).trigger('chosen:updated');
		});
		jQuery('#kd_barang').change(function(){
			var param = jQuery(this).val();
			jQuery.get(baseurl+'/simpan/cek/'+param, function(result){
				if(result == 'success') {
					jQuery('#simpan').prop('disabled', false);
				} else {
					alert("barang ini sudah pernah direkam sebelumnya");
					jQuery('#kd_barang').val('').trigger('chosen:updated');
					jQuery('#simpan').prop('disabled', true);
				}
			});
		});
	});
</script>

@endsection
