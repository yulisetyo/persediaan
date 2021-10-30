@foreach ($rows as $row)
	<option value="{{ $row->id }}">{{ $row->id }} - {{ $row->nm_lokasi }}</option>
@endforeach

