<x-layout>
    <section class="section">
        <x-modal id="bidang-type-modal">
            <x-slot name="title">Form Bidang</x-slot>
            <x-slot name="body">
                <form id="bidang-type-form" class="form needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="type-name" class="col-form-label">Nama Bidang:</label>
                        <input type="text" name="bidang_category_name" class="form-control" id="type-name" required>
                        <div class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="type-name" class="col-form-label">Singkatan:</label>
                        <input type="text" name="bidang_category_singkatan" class="form-control" id="type-name" required>
                        <div class="invalid-feedback">
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
                            <div>Bidang</div>
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#bidang-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                        </div>
                        <table id="bidang-category-table" class="table table-striped table-hover table-bordered"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bidang</th>
                                    <th>Singkatan</th>
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
    </section>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    @push('scripts')
        <script type="text/javascript">
            let modal = 'bidang-type-modal';
            let urlPost = "{{ route('admin.bidang-category.store') }}";
            var dataTableList;
            let options = {
                modal: modal,
                id: null,
                url: urlPost,
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
                dataTableList = $('#bidang-category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'bidang_category_id',
                            name: 'bidang_category_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'bidang_category_name',
                            name: 'bidang_category_name'
                        },
                        {
                            data: 'bidang_category_singkatan',
                            name: 'bidang_category_singkatan'
                        },
                        {
                            name: 'action',
                            data: 'bidang_category_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `<div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-success">Edit</button>
                                    <button type="button" data-id="${data}" class="btn btn-sm btn-delete btn-warning">Delete</button>
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

                let forms = $('#bidang-type-form');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                        } else {
                            let formData = $('#bidang-type-form').serialize();
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
                    forms.find('input[name="bidang_category_name"]').val(rowData.bidang_category_name);
                    forms.find('input[name="bidang_category_id"]').val(rowData.bidang_category_id);
                    forms.find('input[name="bidang_category_singkatan"]').val(rowData.bidang_category_singkatan);
                    $('#'+options.modal).modal('show');
                    $('#'+options.modal).find('#save').text('Ubah');
                    options.id = rowData.bidang_category_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.bidang_category_name;
                    deleteData(rowData.bidang_category_id);
                })

                $(window).on('hide.bs.modal', function() {
                    $('#'+options.modal).find('#save').text('Simpan');
                    forms.trigger('reset');
                    options.id = null;
                });
            });
        </script>
    @endpush
</x-layout>
