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
    @section('title', 'Aset')
    <section class="section">
        <x-modal id="asset-type-modal" size="modal-xl">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="bahan-type-form" class="form needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="asset_category_id" class="col-form-label mandatory">Pilih Jenis Aset</label>
                        <select class="form-control select2assetCategories" data-action="{{route('admin.asset-category.ajax')}}" name="asset_category_id" id="asset_category_id" required>
                        </select>
                        <div id="asset_category_id_feedback" class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_category_id" class="col-form-label mandatory">Pilih Kategori</label>
                                <select class="form-control select2itemCategories" data-action="{{route('admin.item-category.ajax')}}" name="item_category_id" id="item_category_id" required>
                                </select>
                                <div id="item_category_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_id" class="col-form-label mandatory">Pilih Jenis Barang</label>
                                <select class="form-control select2items" data-action="{{route('admin.item.ajax')}}" name="item_id" id="item_id" required>
                                </select>
                                <div id="item_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_brand_id" class="col-form-label mandatory">Pilih Merk</label>
                                <select class="form-control select2brands" data-action="{{route('admin.brand.ajax')}}" name="item_brand_id" id="item_brand_id" required>
                                </select>
                                <div id="item_brand_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_type_id" class="col-form-label mandatory">Pilih Tipe</label>
                                <select class="form-control select2types" data-action="{{route('admin.type.ajax')}}" name="item_type_id" id="item_type_id" required>
                                </select>
                                <div id="item_type_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="bidang_category_id" class="col-form-label mandatory">Pilih Bidang</label>
                                <select class="form-control select2bidangs" data-action="{{route('admin.bidang.ajax')}}" name="bidang_category_id" id="bidang_category_id" required>
                                </select>
                                <div id="bidang_category_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="asset_procurement_year" class="col-form-label mandatory">Pengadaan Tahun</label>
                                <input type="number" class="form-control mandatory" name="asset_procurement_year" id="asset_procurement_year" required>
                                <div id="asset_procurement_year_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="asaloleh_category_id" class="col-form-label mandatory">Pilih Asal Oleh</label>
                                <select class="form-control select2asalolehs" data-action="{{route('admin.asaloleh.ajax')}}" name="asaloleh_category_id" id="asaloleh_category_id" required>
                                </select>
                                <div id="asaloleh_category_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="asset_asaloleh_date" class="col-form-label mandatory">Tanggal Asal Oleh</label>
                                <input type="date" class="form-control mandatory" name="asset_asaloleh_date" id="asset_asaloleh_date" required>
                                <div id="asset_asaloleh_date_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bahan_category_id" class="col-form-label mandatory">Bahan</label>
                                <select class="form-control select2bahans" data-action="{{route('admin.bahan.ajax')}}" name="bahan_category_id" id="bahan_category_id" required>
                                </select>
                                <div id="bahan_category_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="satuan_category_id" class="col-form-label mandatory">Satuan</label>
                                <select class="form-control select2satuans" data-action="{{route('admin.satuan.ajax')}}" name="satuan_category_id" id="satuan_category_id" required>
                                </select>
                                <div id="satuan_category_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="satuan_category_id" class="col-form-label">Spesifikasi</label>
                        <textarea class="form-control" name="asset_specification"></textarea>
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
                            @if(auth()->user()->hasPermissionTo('aset-create'))
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#asset-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            @foreach (Session::get('categories') as $key => $category)
                            <li class="nav-item" role="presentation">
                              <button class="nav-link text-nav {{$key == 0 ? 'active' : ''}}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="{{$key == 0 ? true : false}}">{{$category->item_category_name}}</button>
                            </li>
                            @endforeach
                          </ul>
                          <div class="table-responsive">
                            <table id="asset-table" class="table table-hover"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode KAB</th>
                                    <th>Jenis Barang</th>
                                    <th>Pengguna</th>
                                    <th>Nama Barang</th>
                                    <th>Ukuran</th>
                                    <th>Satuan</th>
                                    <th>Tipe</th>
                                    <th>QR Code</th>
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
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js')}}"></script>
        <script src="{{ asset('assets/js/select2-asset.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script type="text/javascript">
            let modal = 'bahan-type-modal';
            let urlPost = "{{ route('admin.asset.store') }}";
            let formMain = 'bahan-type-form';
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
                dataTableList = $('#asset-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'asset_id',
                            name: 'asset_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            data: 'asset_id',
                            name: 'asset_id',
                        },
                        {
                            name: 'action',
                            data: 'asset_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                @if(auth()->user()->hasPermissionTo('bahan-edit') ||auth()->user()->hasPermissionTo('bahan-delete'))
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group">
                                            @if(auth()->user()->hasPermissionTo('bahan-edit'))
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('bahan-delete'))
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
                    $(`#${options.formMain}`).find('input[name="bahan_category_name"]').val(rowData.bahan_category_name);
                    $(`#${options.formMain}`).find('input[name="asset_id"]').val(rowData.asset_id);
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.asset_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.bahan_category_name;
                    deleteData(rowData.asset_id);
                })
            });
        </script>
    @endpush
</x-layout>
