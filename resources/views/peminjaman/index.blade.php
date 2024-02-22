<x-layout>
    @push('styles')
    <style>
        .text-nav{
            color:#012970
        }
    </style>
    <link href="{{asset('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css')}}" rel="stylesheet">
    @endpush
    @section('title', 'Peminjaman')
    <section class="section">
    <x-modal id="peminjaman-type-modal" size="modal-xl">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="peminjaman-type-form" class="form needs-validation" novalidate>
                <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Pilih Nama</label>
                                <select class="form-control select2itemCategories" name="" id="" required>
                                <option value="">- Pilih Nama -</option>
                                <option value="">Pegawai 1</option>
                                <option value="">Pegawai 2</option>
                                <option value="">Pegawai 3</option>
                                </select>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label">NIP</label>
                                <input type="text" name="" class="form-control" id="" value="Generate Auto Input Ketika Nama Dipilih (SI-Adik)" readonly>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label">Jabatan</label>
                                <input type="text" name="" class="form-control" id="" value="Generate Auto Input Ketika Nama Dipilih (SI-Adik)" readonly>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label">Bidang</label>
                                <input type="text" name="" class="form-control" id="" value="Generate Auto Input Ketika Nama Dipilih (SI-Adik)" readonly>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Tanggal Peminjaman</label>
                                <input type="text" name="" class="form-control" id="datepicker-peminjaman" required>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Waktu Peminjaman</label>
                                <input type="text" name="" class="form-control" id="timepicker-peminjaman" required>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Tanggal Pengembalian</label>
                                <input type="text" name="" class="form-control" id="datepicker-pengembalian" required>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Waktu Pengembalian</label>
                                <input type="text" name="" class="form-control" id="timepicker-pengembalian" required>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Status</label>
                                <select class="form-control" name="" id="" required>
                                    <option value="">- Pilih Status -</option>
                                    <option value="">Approved Peminjam </option>
                                    <option value="">Approved Pengembalian </option>
                                    <option value="">Approved Penarikan </option>
                                </select>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="col-form-label mandatory">Nama Aset yang Dipinjam</label>
                                <select class="form-control" name="" id="" required>
                                    <option value="">- Pilih Asset ( Generate Data dari Aset )-</option>
                                    <option value="">PC Komputer</option>
                                    <option value="">Mobil</option>
                                    <option value="">Motor</option>
                                </select>
                                <div id="" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2"
                            data-bs-dismiss="modal">Tutup</button>
                        {{-- <button class="btn btn-primary" id="save" type="submit">
                            <span class="loading spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="btn-name">Simpan</span>
                        </button> --}}
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
                            @if(auth()->user()->hasPermissionTo('peminjaman-create')) 
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#peminjaman-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="peminjaman-table" class="table table-hover nowrap"
                            width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nip</th>
                                        <th>Jabatan</th>
                                        <th>Bidang</th>
                                        <th>Waktu Peminjaman</th>
                                        <th>Waktu Pengembalian</th>
                                        <th>Status</th>
                                        <th>Aset</th>
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
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <!-- Datatables -->
        <script type="text/javascript">
            let modal = 'peminjaman-type-modal';
            let urlPost = "{{ route('admin.peminjaman.store') }}";
            let formMain = 'peminjaman-type-form';
            var dataTableList;
            let options = {
                modal: modal,
                id: null,
                url: urlPost,
                formMain: formMain,
                data: null,
                dataTable: null,
                disabledButton: () => {
                    $('#save').addClass('disabled');
                    $('.loading').removeClass('d-none');
                },
                enabledButton: () => {
                    $('#save').removeClass('disabled');
                    $('.loading').addClass('d-none');
                }
            }

            $(document).ready(function() {
                dataTableList = $('#peminjaman-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            data: 'peminjaman_id',
                            name: 'peminjaman_id',
                        },
                        {
                            name: 'action',
                            data: 'peminjaman_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                @if(auth()->user()->hasPermissionTo('peminjaman-edit') || auth()->user()->hasPermissionTo('peminjaman-delete'))
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group">
                                            @if(auth()->user()->hasPermissionTo('peminjaman-edit')) 
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('peminjaman-delete')) 
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-delete btn-danger"><i class="bi bi-trash-fill"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @endif`;
                                return button;
                            }
                        },

                    ]
                });

                const saveData = (formData) => {
                    options.data = formData;
                    options.dataTable = dataTableList;
                    POST_DATA(options);
                }

                const updateData = (formData) => {
                    options.data = formData;
                    options.dataTable = dataTableList;
                    PATCH_DATA(options);
                }

                const deleteData = (id) => {
                    options.id = id;
                    options.dataTable = dataTableList;
                    DELETE_DATA(options);
                }
                Array.prototype.filter.call($(`#${options.formMain}`), function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                        } else {
                            let formData = $(`#${options.formMain}`).serialize();
                            event.preventDefault();
                            event.stopPropagation();
                            options.disabledButton();
                            form.classList.remove('was-validated');
                            if (options.id == null) saveData(formData);
                            if (options.id) updateData(formData);
                        }
                    });
                });


                $(document).on('click','.btn-edit',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.peminjaman_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    deleteData(rowData.peminjaman_id);
                })
            });
        </script>
        <!-- TimepickerScript -->
        <script>
            $('#timepicker-peminjaman').timepicker({
                uiLibrary: 'bootstrap5'
            });
            $('#timepicker-pengembalian').timepicker({
                uiLibrary: 'bootstrap5'
            });
        </script>
        <!-- TimepickerScript -->
        <script>
            $('#datepicker-peminjaman').datepicker({
                uiLibrary: 'bootstrap5'
            });
            $('#datepicker-pengembalian').datepicker({
                uiLibrary: 'bootstrap5'
            });
        </script>
    @endpush
</x-layout>
