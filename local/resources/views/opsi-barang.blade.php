@foreach ($rows as $row)
	<option value="{{ $row->kd_barang }}">{{$row->kd_barang}} - {{ $row->nm_barang }}</option>
@endforeach
