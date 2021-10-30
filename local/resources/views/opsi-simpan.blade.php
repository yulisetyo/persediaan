@foreach ($rows as $row)
	<option value="{{ $row->kd_barang }}">{{$row->kd_barang}} - {{ $obj->getBarang($row->kd_barang)->nm_barang }}</option>
@endforeach
