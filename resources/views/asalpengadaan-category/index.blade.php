<x-layout>
    @section('title', 'Asal Pengadaan')
    <section class="section">
        <x-modal id="asalpengadaan-type-modal">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="asalpengadaan-type-form" class="form needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="asalpengadaan_category_name" class="col-form-label mandatory">Nama Asal Pengadaan</label>
                        <input type="text" name="asalpengadaan_category_name" class="form-control" id="asalpengadaan_category_name" required>
                        <div id="asalpengadaan_category_name_feedback" class="invalid-feedback">
                            Wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="asalpengadaan_category_code" class="col-form-label mandatory">Singkatan</label>
                        <input type="text" name="asalpengadaan_category_code" class="form-control" id="asalpengadaan_category_code" required>
                        <div id="asalpengadaan_category_code_feedback" class="invalid-feedback">
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
                            @if(auth()->user()->hasPermissionTo('asal-pengadaan-create'))
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#asalpengadaan-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                                <table id="asalpengadaan-category-table" class="table table-hover"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Asal Pengadaan</th>
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
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script type="text/javascript">
            let modal = 'asalpengadaan-type-modal';
            let urlPost = "{{ route('admin.asalpengadaan-category.store') }}";
            let formMain = 'asalpengadaan-type-form';
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
                dataTableList = $('#asalpengadaan-category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'asalpengadaan_category_id',
                            name: 'asalpengadaan_category_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'asalpengadaan_category_name',
                            name: 'asalpengadaan_category_name'
                        },
                        {
                            data: 'asalpengadaan_category_code',
                            name: 'asalpengadaan_category_code'
                        },
                        {
                            name: 'action',
                            data: 'asalpengadaan_category_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                @if(auth()->user()->hasPermissionTo('asal-pengadaan-edit') || auth()->user()->hasPermissionTo('asal-pengadaan-delete'))
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group">
                                            @if(auth()->user()->hasPermissionTo('asal-pengadaan-edit'))
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('asal-pengadaan-delete'))
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
                    $(`#${options.formMain}`).find('input[name="asalpengadaan_category_name"]').val(rowData.asalpengadaan_category_name);
                    $(`#${options.formMain}`).find('input[name="asalpengadaan_category_id"]').val(rowData.asalpengadaan_category_id);
                    $(`#${options.formMain}`).find('input[name="asalpengadaan_category_code"]').val(rowData.asalpengadaan_category_code);
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.asalpengadaan_category_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.asalpengadaan_category_name;
                    deleteData(rowData.asalpengadaan_category_id);
                })
            });
        </script>
    @endpush
</x-layout>

