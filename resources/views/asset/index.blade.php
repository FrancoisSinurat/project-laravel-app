<x-layout>

    @section('title', 'Asset')
    <section class="section">
        <x-modal id="asset-type-modal" size="modal-xl">
            <x-slot name="title">Tambah @yield('title')</x-slot>

            <x-slot name="body">
                <form id="asset-type-form" class="form needs-validation" novalidate>
                <div class="modal-body">    
                    <div class="row">

                        <div class="col-xl">
                        <div class="card col-md-12" >
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="tahun" class="col-form-label mandatory">Tahun</label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option value="" disabled></option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pengguna" class="col-form-label mandatory">Pengguna</label>
                                <input type="text" name="pengguna" class="form-control" id="pengguna" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="bidang" class="col-form-label mandatory">Bidang</label>
                                <input type="text" name="bidang" class="form-control" id="bidang" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_barang" class="col-form-label mandatory">Jenis Barang</label>
                                <input type="text" name="jenis_barang" class="form-control" id="jenis_barang" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_asset" class="col-form-label mandatory">Jenis Asset</label>
                                <input type="text" name="jenis_asset" class="form-control" id="jenis_asset" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="asal_perolehan" class="col-form-label mandatory">Asal Perolehan</label>
                                <input type="text" name="asal_perolehan" class="form-control" id="asal_perolehan" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_perolehan" class="col-form-label mandatory">Tanggal Perolehan</label>
                                <input type="text" name="tanggal_perolehan" class="form-control" id="tanggal_perolehan" required>
                                <div class="invalid-feedback">Wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="serial_number" class="col-form-label">Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" id="serial_number">
                            </div>
                        </div>
                        </div>
                        </div>

                        <div class="col-xl">
                        <div class="card col-md-12">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="user_password" class="col-form-label mandatory">Nama Barang</label>
                                <input type="password" name="user_password" class="form-control" id="user_password" required>
                                <div id="user_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label">Merk</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password">
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="col-form-label">Ukuran</label>
                                <select class="form-control" name="role_id" id="role_id">
                                    <option value="" disabled>Pilih Role</option>
                      
                                </select>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Satuan</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Bahan</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Tipe</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Harga</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Kapitalisasi</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Total</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2"
                            data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" id="save" type="submit">
                            <span class="loading spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="btn-name">Simpan</span>
                        </button>
                    </div>

                </div>
                </form>  
            </x-slot>
        </x-modal>


        <div class="row">
            <div class="col-md-12 h-100">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <div>@yield('title')</div>
                            @if(auth()->user()->hasPermissionTo('bidang-create')) 
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#asset-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                                <table id="asset-category-table" class="table table-hover"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jenis Barang</th>
                                        <th>Tipe Barang</th>
                                        <th>Satuan</th>
                                        <th>Ukuran</th>
                                        <th>Pengguna</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        
    @endpush
</x-layout>
