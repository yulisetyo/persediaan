@extends('template')

@section('title', 'RUH Keluar')

@section('sidebar')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<div class="well">
	<h3>Keluar Barang</h3>
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
			<h3 class="panel-title">Form RUH Barang Keluar</h3>
		</div>
		<div class="panel-body">
			<form action="{{$baseurl}}/keluar/simpan" method="post" class="form-horizontal" name="form_ruh" id="form_ruh" enctype="multipart/form-data">

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
					<label class="control-label col-sm-2">Harga Satuan</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="hrg_satuan" name="hrg_satuan" placeholder="harga satuan" value="{{$data->hrg_satuan}}" readonly="readonly" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Kuantitas</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="kuantitas" name="kuantitas" placeholder="kuantitas" value="{{$data->kuantitas}}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Keterangan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan" value="{{$data->keterangan}}"/>
					</div>
				</div>
				
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-2">&nbsp;</label>
					<div class="col-sm-3">
						<button class="btn btn-warning" type="submit" name="simpan">Simpan</button>
						<a href="{{$baseurl}}/keluar/show" class="btn btn-default" type="cancel" name="batal">Batal</a>
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
		
		jQuery.get(baseurl+'/simpan/opsi', function(result){
			jQuery('#kd_barang').html(result).trigger('chosen:updated');
		});

		jQuery('#kd_barang').change(function(){
			var param = jQuery(this).val();
			jQuery.get(baseurl+'/input/getby/'+param, function(result){
				if(result) {
					jQuery('#hrg_satuan').val(result.hrg_satuan);
				} 
			});
		});
	});
</script>

@endsection
