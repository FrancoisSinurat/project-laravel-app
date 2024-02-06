<x-layout>
    @section('title', 'jenis-barang')
    <section class="section">
        <x-modal id="jenisbarang-type-modal">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="jenisbarang-type-form" class="form needs-validation" novalidate>
                    <div class="mb-3">
                        <input name="jenisbarang_category_id" type="hidden" id="jenisbarang_category_id">
                        <label for="item_category_id" class="col-form-label mandatory">Pilih Jenis Aset</label>
                        <select class="form-control" name="item_category_id" id="item_category_id">
                            <option value="" disabled>Pilih Jenis Aset</option>
                            @foreach ($itemCategory as $v)
                                <option value="{{ $v->item_category_id }}">{{ $v->item_category_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jenisbarang_category_name" class="col-form-label mandatory">Nama @yield('title')</label>
                        <input type="text" name="jenisbarang_category_name" class="form-control" id="jenisbarang_category_name" required>
                        <div id="jenisbarang_category_name_feedback" class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jenisbarang_category_code" class="col-form-label mandatory">Kode @yield('title')</label>
                        <input type="text" name="jenisbarang_category_code" class="form-control text-uppercase" id="jenisbarang_category_code" required>
                        <div id="jenisbarang_category_code_feedback" class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2"
                            data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" id="save" type="submit">
                            <span class="loading spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Simpan</button>
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
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#jenisbarang-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="jenisbarang-category-table" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Aset</th>
                                        <th>Kategori</th>
                                        <th>Kode Kategori</th>
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
        <script type="text/javascript">
            let modal = 'jenisbarang-type-modal';
            let urlPost = "{{ route('admin.jenisbarang-category.store') }}";
            let formMain = 'jenisbarang-type-form';
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
                dataTableList = $('#jenisbarang-category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'jenisbarang_category_id',
                            name: 'jenisbarang_category_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'item_category.item_category_name',
                            name: 'item_category.item_category_name',
                        },
                        {
                            data: 'jenisbarang_category_name',
                            name: 'jenisbarang_category_name'
                        },
                        {
                            data: 'jenisbarang_category_code',
                            name: 'jenisbarang_category_code'
                        },
                        {
                            name: 'action',
                            data: 'jenisbarang_category_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            <button type="button" data-id="${data}" class="btn btn-sm btn-delete btn-danger"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </div>`;
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
                    $(`#${options.formMain}`).find('input[name="jenisbarang_category_name"]').val(rowData.jenisbarang_category_name);
                    $(`#${options.formMain}`).find('input[name="jenisbarang_category_code"]').val(rowData.jenisbarang_category_code);
                    $(`#${options.formMain}`).find('input[name="jenisbarang_category_id"]').val(rowData.jenisbarang_category_id);
                    $("#item_category_id").val(rowData.item_category.item_category_id).change();
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('#save').text('Ubah');
                    options.id = rowData.jenisbarang_category_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.jenisbarang_category_name;
                    deleteData(rowData.jenisbarang_category_id);
                })
            });
        </script>
    @endpush
</x-layout>
