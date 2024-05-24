@foreach ($tabellaporan as $item)
<tr>
    <td>{{ $item->nama_pelapor }}</td>
    <td>{{ $item->melapor_sebagai }}</td>
    <td>{{ $item->nomor_hp }}</td>
    <td>{{ $item->alamat_email }}</td>
    <td>{{ $item->domisili_pelapor }}</td>
    <td>{{ $item->jenis_kekerasan_seksual }}</td>
    <td>{{ $item->cerita_peristiwa }}</td>
    <td>{{ $item->deskripsi_disabilitas }}</td>
    <td>{{ $item->status_terlapor }}</td>
    <td>{{ $item->alasan_pengaduan }}</td>
    <td>{{ $item->nomor_hp_pihak_lain }}</td>
    <td>{{ $item->kebutuhan_korban }}</td>
    <td>{{ $item->tanggal_pelaporan }}</td>
    <td>{{ $item->tanda_tangan_pelapor }}</td>
</tr>
@endforeach
