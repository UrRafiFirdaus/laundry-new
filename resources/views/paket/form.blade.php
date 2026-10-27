<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">

        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('put')

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                    <h4 class="modal-title">Edit Paket</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">
                            Berat Laundry
                        </label>

                        <div class="col-lg-7">
                            <input type="text" name="berat_total" id="berat_total" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">
                            Tipe Pengambilan
                        </label>

                        <div class="col-lg-7">
                            <select name="tipe_pengambilan" id="tipe_pengambilan" class="form-control">
                                <option value="ambil ditempat">
                                    Ambil ditempat
                                </option>

                                <option value="diantar">
                                    Diantar
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">
                            Status Pembayaran
                        </label>

                        <div class="col-lg-7">
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                                <option value="belum dibayar">
                                    Belum Dibayar
                                </option>

                                <option value="sudah dibayar">
                                    Sudah Dibayar
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">
                            Telepon
                        </label>

                        <div class="col-lg-7">
                            <input type="text" name="telepon" id="telepon" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">
                            Alamat
                        </label>

                        <div class="col-lg-7">
                            <textarea name="alamat" id="alamat" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary btn-flat">
                        <i class="fa fa-save"></i> Simpan
                    </button>

                    <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">
                        Batal
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>