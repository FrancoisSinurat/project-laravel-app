<x-layout>
    @push('styles')
    <link href="{{asset('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css')}}" rel="stylesheet">
    @endpush
    @section('title', 'Kategori')
    <section class="section">
        <x-modal id="item-type-modal" size="modal-lg">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="item-type-form" class="form needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="asset_category_id" class="col-form-label mandatory">Pilih Jenis Aset</label>
                        <select class="form-control" name="asset_category_id" id="asset_category_id" required>
                            <option value="">Pilih Jenis Aset</option>
                            @foreach ($assetCategory as $v)
                                <option value="{{ $v->asset_category_id }}">{{ $v->asset_category_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_category_name" class="col-form-label mandatory">Nama @yield('title')</label>
                                <input type="text" name="item_category_name" class="form-control" id="item_category_name" required>
                                <div id="item_category_name_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_category_code" class="col-form-label mandatory">Kode @yield('title')</label>
                                <input type="text" name="item_category_code" class="form-control text-uppercase" id="item_category_code" required>
                                <div id="item_category_code_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_category_icon" class="col-form-label mandatory">Ikon @yield('title')</label>
                                <select class="form-control select2" name="item_category_icon" id="item_category_icon" required>
                                    @foreach($icons as $icon)
                                        <option value="{{ $icon }}">{{ $icon }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_category_text" class="col-form-label mandatory">Text @yield('title')</label>
                                <select class="form-control" name="item_category_text" id="item_category_text" required>
                                    <option value="">Pilih Text</option>
                                    @foreach($texts as $text)
                                        <option value="{{ $text }}">{{ $text }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="item_category_color" class="col-form-label mandatory">Warna @yield('title')</label>
                        <select class="form-control" name="item_category_color" id="item_category_color" required>
                            <option value="">Pilih Warna</option>
                            @foreach($colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="item_category_color_bg" class="col-form-label mandatory">Background @yield('title')</label>
                        <select class="form-control" name="item_category_color_bg" id="item_category_color_bg" required>
                            <option value="">Pilih Background</option>
                            @foreach($colorsBg as $colorBg)
                                <option value="{{ $colorBg }}">{{ $colorBg }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Wajib diisi.
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
                </form>
            </x-slot>
        </x-modal>
        <div class="row">
            <div class="col-md-12 h-100">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <div>@yield('title')</div>
                            @if(auth()->user()->hasPermissionTo('kategori-barang-create'))
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#item-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="item-category-table" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Aset</th>
                                        <th>Kategori</th>
                                        <th>Kode Kategori</th>
                                        <th>Warna Kategori</th>
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
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Pilih",
                    dropdownParent: $('#item-type-modal .modal-content'),
                    theme: 'bootstrap-5',
                    width: '100%',
                    allowClear: true,
                });
            });
        </script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script type="text/javascript">
            let modal = 'item-type-modal';
            let urlPost = "{{ route('admin.item-category.store') }}";
            let formMain = 'item-type-form';
            let dataTableList;
            let options = {
                modal: modal,
                id: null,
                url: urlPost,
                data: null,
                dataTable: null,
                formMain: formMain,
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
                dataTableList = $('#item-category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'item_category_id',
                            name: 'item_category_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'asset_category.asset_category_name',
                            name: 'asset_category.asset_category_name',
                        },
                        {
                            data: 'item_category_name',
                            name: 'item_category_name'
                        },
                        {
                            data: 'item_category_code',
                            name: 'item_category_code'
                        },
                        {
                            data: 'item_category_color',
                            name: 'item_category_color'
                        },
                        {
                            name: 'action',
                            data: 'item_category_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                @if(auth()->user()->hasPermissionTo('kategori-barang-edit') || auth()->user()->hasPermissionTo('kategori-barang-delete'))
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group">
                                            @if(auth()->user()->hasPermissionTo('kategori-barang-edit'))
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('kategori-barang-delete'))
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
                    $(`#${options.formMain}`).find('input[name="item_category_name"]').val(rowData.item_category_name);
                    $(`#${options.formMain}`).find('input[name="item_category_code"]').val(rowData.item_category_code);
                    $(`#${options.formMain}`).find('select[name="item_category_icon"]').val(rowData.item_category_icon).trigger('change');
                    $(`#${options.formMain}`).find('select[name="item_category_color"]').val(rowData.item_category_color).trigger('change');
                    $(`#${options.formMain}`).find('select[name="item_category_text"]').val(rowData.item_category_text).trigger('change');
                    $(`#${options.formMain}`).find('select[name="item_category_color_bg"]').val(rowData.item_category_color_bg).trigger('change');
                    $("#asset_category_id").val(rowData.asset_category?.asset_category_id).change();
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.item_category_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.item_category_name;
                    deleteData(rowData.item_category_id);
                })
            });
        </script>
    @endpush
</x-layout>

