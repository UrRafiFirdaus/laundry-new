<div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer-title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content cust-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-customer-title"><i class="fa fa-id-card"></i> Pilih Customer Lama</h4>
            </div>

            <div class="modal-body">
                <div class="cust-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="cari-customer" class="form-control" autocomplete="off"
                        placeholder="Cari berdasarkan nama, alamat, atau no telepon...">
                    <button type="button" id="cari-customer-clear" class="cust-search-clear" title="Hapus pencarian"
                        style="display:none;"><i class="fa fa-times-circle"></i></button>
                </div>
                <div class="cust-count"><span id="cust-count-text"></span></div>

                <div class="table-responsive cust-table-wrap">
                    <table class="table table-hover table-customer">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="8%"></th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer as $key => $item)
                                <tr class="cust-row" data-id="{{ $item->id_customer }}"
                                    data-kode="{{ $item->kode_customer }}" data-nama="{{ $item->nama_customer }}"
                                    data-telepon="{{ $item->telepon }}" data-alamat="{{ $item->alamat }}"
                                    data-search="{{ strtolower($item->kode_customer . ' ' . $item->nama_customer . ' ' . $item->telepon . ' ' . $item->alamat) }}">
                                    <td class="cust-no">{{ $key + 1 }}</td>
                                    <td class="text-right">
                                        <button type="button"
                                            class="btn btn-primary btn-xs btn-flat btn-pilih-customer">
                                            <i class="fa fa-check-circle"></i> Pilih
                                        </button>
                                    </td>
                                    <td><span class="label label-success">{{ $item->kode_customer }}</span></td>
                                    <td class="cust-nama"><strong>{{ $item->nama_customer }}</strong></td>
                                    <td class="cust-telepon">{{ $item->telepon ?: '-' }}</td>
                                    <td class="cust-alamat">{{ $item->alamat ?: '-' }}</td>
                                </tr>
                            @endforeach
                            <tr id="cust-empty" style="display:none;">
                                <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                    <i class="fa fa-user-times fa-2x"></i><br>
                                    <span id="cust-empty-text">Customer tidak ditemukan.</span><br>
                                    <button type="button" class="btn btn-success btn-sm btn-flat" id="btn-jadi-baru"
                                        style="margin-top:10px;">
                                        <i class="fa fa-user-plus"></i> Input sebagai customer baru
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
