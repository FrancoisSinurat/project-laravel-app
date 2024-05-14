<div class="detail-asset" id="detail-asset">
    <div class="row">
        <div class="col-md-12">
            <p><b>Informasi Aset</b></p>
            <table class="table table-detail-asset table-responsive table-striped">
                <tr>
                    <td style="width: 20%;">Jenis Asset</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_category_name"></span></td>
                </tr>
                <tr>
                    <td style="width: 20%;">Nomor Registrasi</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_code"></span></td>
                </tr>
                <tr>
                    <td style="width: 20%;">Status Asset</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_status"></span></td>
                </tr>
                <tr>
                    <td style="width: 20%;">Tahun Pengadaan</td>
                    <td style="width:3%;">:</td>
                    <td>
                        <span id="asset_procurement_year"></span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">Asal Oleh</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_asaloleh_category_name"></span></td>
                </tr>
                <tr>
                    <td style="width: 20%;">Asal Pengadaan</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_asalpengadaan_category_name"></span></td>
                </tr>
                <tr>
                    <td style="width: 20%;">Tanggal Asal Oleh</td>
                    <td style="width:3%;">:</td>
                    <td><span id="asset_asaloleh_date"></span></td>
                </tr>
            </table>
            <div class="asset-detail">
                <p><b>Informasi Barang</b></p>
                <table id="asset-detail" class="table table-detail-asset table-responsive table-striped">
                    <tr>
                        <td style="width: 20%;">Nama Barang</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_name"></span></td>
                    </tr>
                    {{-- <tr>
                        <td style="width: 20%;">Jenis Barang</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_item_name"></span></td>
                    </tr> --}}
                    <tr>
                        <td style="width: 20%;">Bahan</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_bahan_name"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Spesifikasi</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_specification"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Nomor Seri</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_serial_number"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Harga</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_price"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Penyusutan</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_shrinkage"></span></td>
                    </tr>
                </table>
            </div>
            <div class="asset-detail-additional d-none">
                <p><b>Informasi Tambahan</b></p>
                <table id="asset-detail-additional" class="table table-detail-asset table-responsive table-striped">
                    <tr>
                        <td style="width: 20%;">Nomor Mesin</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_machine_number"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Nomor Rangka</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_frame_number"></span></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Nomor Plat</td>
                        <td style="width:3%;">:</td>
                        <td><span id="asset_police_number"></span></td>
                    </tr>
                </table>
            </div>
            <div class="asset-history">
                <p><b>Riwayat Aset</b></p>
                <table id="asset-history" class="table table-responsive table-striped">
                    <tr>
                        <td>Tanggal</td>
                        <td>Status</td>
                        <td>Keterangan</td>
                    </tr>
                </table>
            </div>
            <div class="asset-peminjaman">
                <p><b>Riwayat Peminjaman</b></p>
                <table id="asset-peminjaman" class="table table-responsive table-striped">
                    <tr>
                        <td>Tanggal</td>
                        <td>Status</td>
                    </tr>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary me-2"
                data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
