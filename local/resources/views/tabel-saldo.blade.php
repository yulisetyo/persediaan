@extends('template')

@section('title', 'Saldo Barang')

@section('sidebar')
	@parent

	<p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<div class="well">
	<h3>Saldo Barang</h3>
	<div class="panel panel-warning">
		<div class="panel-body">
			<form class="form-horizontal" onsubmit="return false" id="form-ruh" name="form-ruh">
				<div class="box-body">
					{{ csrf_field() }}
					<div class="form-group">
						<!-- <label class="control-label col-sm-1">Cari</label> -->
						<div class="col-sm-6">
							<input type="text" class="form-control" id="paramcari" name="paramcari" placeholder="" value="" /> 
						</div>
						
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<div class="btn btn-default" title="klik Cari untuk mencari data" id="btn_cari"><i class="glyphicon glyphicon-search"></i> </div>
							<div class="btn btn-default" title="klik Refresh untuk menampilkan semua data" id="btn_refresh"><i class="glyphicon glyphicon-refresh"></i> </div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
	<div class="panel panel-warning" id="div_tabel">
		<input type="hidden" id="baseurl" name="baseurl" value="{{$baseurl}}" />
		<div class="panel-heading text-right">
			&nbsp;
			<!--span class="btn btn-sm" id="tambah"><i class="glyphicon glyphicon-plus"></i> Rekam</span>-->
			<!--<a href="{{$baseurl}}/keluar/create" class="btn btn-sm btn-default" id="tambah"><i class="glyphicon glyphicon-plus"></i> Rekam</a>-->
		</div>
		<div class="panel-body">
			<table width="100%" class="table table-condensed" id="tabel_ruh">
				<thead>
					<tr>
						<th>#</th>
						<th>Barang</th>
						<th>Jml. Barang Masuk</th>
						<th>Jml. Barang Keluar</th>
						<th>Jml. Barang Tersedia</th>
					</tr>
				</thead>				
			</table>
		</div>
	</div>
	
</div>

<script>

jQuery(document).ready(function () {

	var baseurl = jQuery('#baseurl').val();
	var baseroute = baseurl+'/saldo';
	var route = baseroute + '/tabel';
	
	jQuery.fn.dataTable.ext.errMode = 'none';
	var table=jQuery('#tabel_ruh').DataTable({
		processing: true,
		searching: false,
		language:{
			"decimal":      	"",
			"emptyTable": 		"Tidak ditemukan data yang sesuai",
			"info":         	"Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
			"infoEmpty":    	"Menampilkan 0 sampai 0 dari 0 entri",
			"infoFiltered": 	"(disaring dari _MAX_ total entri)",
			"infoPostFix":  	"",
			"thousands":    	",",
			"lengthMenu":   	"Tampilkan _MENU_ entri",
			"loadingRecords": 	"Proses Loading...",
			"processing":     	"<center><h3>Sedang proses....</h3></center>",
			"search":         	"Cari (tekan enter) :",
			"zeroRecords":    	"Tidak ditemukan data yang sesuai",
			"paginate": {
				"first": 	"Awal",
				"last":     "Akhir",
				"next":     "Sesudah",
				"previous": "Sebelum"
			},
			"aria": {
				"sortAscending":  ": aktifkan untuk mengurutkan kolom (asc)",
				"sortDescending": ": aktifkan untuk mengurutkan kolom (desc)"
			}
		},
		serverSide: true,
		ajax: route,
		columns: [
			{data: 'DT_Row_Index', name: 'DT_Row_Index', className: 't-center', orderable:false, searchable:false},
			{data: 'barang', name: 'barang', className: 't-left', searchable:true},
			{data: 'jml_masuk', name: 'jml_masuk', className: 'text-right', searchable:true},
			{data: 'jml_keluar', name: 'jml_keluar', className: 'text-right', searchable:true},
			{data: 'jml_saldo', name: 'jml_saldo', className: 'text-right', searchable:true},
		]
	});

	jQuery('#btn_cari').click(function(){
		var paramcari = jQuery('#paramcari').val();
		
		if(paramcari == '') {
			alert('parameter pencarian harus diisi!');
		} else {
			table.ajax.url(baseroute + '/tabel?paramcari='+paramcari).load();
		}
	});
	
	jQuery('#btn_refresh').click(function(){
		table.ajax.url(route).load();
		jQuery('#paramcari').val('');
	});
	
});

</script> 

@endsection

