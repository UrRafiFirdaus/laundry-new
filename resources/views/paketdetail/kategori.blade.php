<div class="modal fade" id="modal-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-kategori">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Tipe Laundry</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-kategori">
                    <thead>
                        <th width="5%">No</th>
                        
                        <th>Kategori Laundry</th>
                        <th>Berat Minimal</th>
                        <th>Harga</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $key => $item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ $item->berat_minimal }}</td>
                                <td>Rp. {{ format_uang($item->harga) }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                        onclick="pilihKategori('{{ $item->id_kategori }}', '{{ $item->nama_kategori }}', '{{$item -> berat_minimal}}', '{{$item -> harga}}' )">
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>