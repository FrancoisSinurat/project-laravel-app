<x-layout>
    @section('title', 'Aset Group')
    <section class="section">
        <x-modal id="asset-group-type-modal" size="modal-fullscreen">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="asset-group-type-form" class="form needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="p-2">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="mb-2">
                                    <label for="asset_dokumen_number" class="col-form-label mandatory">Nomor Dokumen</label>
                                    <input type="text" name="asset_dokumen_number" class="form-control" id="asset_dokumen_number" required>
                                    <div id="asset_dokumen_number_feedback" class="invalid-feedback">
                                        Wajib diisi.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="mb-2">
                                    <label for="asalpengadaan_category_id" class="col-form-label mandatory">Pilih Asal Pengadaan</label>
                                    <select class="form-control select2assetgroups"
                                    data-action="{{ route('admin.asset-group.ajax') }}"
                                    name="asalpengadaan_category_id" id="asalpengadaan_category_id"
                                                required>
                                            </select>
                                            <div id="asalpengadaan_category_id_feedback" class="invalid-feedback">
                                                Wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                
                                
                        </div>

                        <div class="row">
                                    <div class="col-6 col-md-6">
                                        <div class="mb-2">
                                            <label for="asaloleh_category_id" class="col-form-label mandatory">Pilih
                                                Asal Oleh</label>
                                            <select class="form-control select2asalolehs"
                                                data-action="{{ route('admin.asaloleh.ajax') }}"
                                                name="asaloleh_category_id" id="asaloleh_category_id" required>
                                            </select>
                                            <div id="asaloleh_category_id_feedback" class="invalid-feedback">
                                                Wajib diisi.
                                            </div>
                                        </div>
                                        {{-- <div class="mb-2">
                                                <label for="asaloleh_category_id" class="col-form-label mandatory">Pilih Asal Perolehan</label>
                                                <select class="form-control select2asalolehs"
                                                    data-action="{{ route('admin.asaloleh.ajax') }}"
                                                    name="asaloleh_category_id" id="asaloleh_category_id"
                                                    required>
                                                </select>
                                                <div id="asaloleh_category_id_feedback" class="invalid-feedback">
                                                    Wajib diisi.
                                                </div>
                                        </div>  --}}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="asset_asaloleh_date" class="col-form-label mandatory">Tanggal
                                                Asal Oleh</label>
                                            <input type="text" class="form-control mandatory"
                                                name="asset_asaloleh_date" id="asset_asaloleh_date" required>
                                            <div id="asset_asaloleh_date_feedback" class="invalid-feedback">
                                                Wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="mb-2">
                                            <label for="asset_procurement_year" class="col-form-label mandatory">Tahun Pengadaan</label>
                                            <input type="text" name="asset_procurement_year" class="form-control text-uppercase" id="asset_procurement_year" required>
                                            <div id="asset_procurement_year_feedback" class="invalid-feedback">
                                                Wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="asset_documents" class="col-form-label mandatory">Dokumen Aset</label>
                                    <input type="file" name="asset_documents" class="form-control" id="file" required>
                                    <div id="asset_documents_feedback" class="invalid-feedback">
                                        Wajib diisi.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="asset_group_items" class="col-form-label mandatory">Aset Group Item </label>
                                    <input type="text" name="asset_group_items" class="form-control text-uppercase" id="asset_group_items" required>
                                    <div id="asset_group_items_feedback" class="invalid-feedback">
                                        Wajib diisi.
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
                            @if(auth()->user()->hasPermissionTo('asset-group-create'))
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#asset-group-type-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="asset-group-table" class="table table-hover"
                            width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Dokumen</th>
                                        <th>Tanggal</th>
                                        <th>Tahun Pengadaan</th>
                                        <th>Dokumen Aset</th>
                                        <th>Item Group</th>
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
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2-asset.js') }}"></script>
    <script src="{{ asset('assets/js/asset-event.js') }}"></script>
    <script src="{{ asset('assets/js/file.js') }}"></script>
    <script type="text/javascript">
        let modal = 'asset-group-type-modal';
        let urlPost = "{{ route('admin.asset-group.store') }}";
        let formMain = 'asset-group-type-form';
        var dataTableList;
        let options = {
            modal: modal,
            id: null,
            url: urlPost,
            formMain: formMain,
            data: null,
            dataTable: null,
            file:true,
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
            $('#asset_asaloleh_date').datepicker({
                    uiLibrary: 'bootstrap5',
                    format: 'dd-mm-yyyy'
                });

            dataTableList = $('#asset-group-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'asset_group_id',
                        name: 'asset_group_id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'asset_document_number',
                        name: 'asset_document_number'
                    },
                   
                    {
                        data: 'asset_asaloleh_date',
                        name: 'asset_asaloleh_date'
                    },
                    {
                        data: 'asset_procurement_year',
                        name: 'asset_procurement_year'
                    },
                    {
                        data: 'asset_documents',
                        name: 'asset_documents'
                    },
                    {
                        data: 'asset_group_items',
                        name: 'asset_group_items'
                    },
                    {
                        name: 'action',
                        data: 'asset_group_id',
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
                $(`#${options.formMain}`).find('input[name="asset_document_number"]').val(rowData.asset_document_number);
                $(`#${options.formMain}`).find('input[name="asalpengadaan_category_id"]').val(rowData.asalpengadaan_category_id);
                $(`#${options.formMain}`).find('input[name="asaloleh_category_id"]').val(rowData.asaloleh_category_id);
                $(`#${options.formMain}`).find('input[name="asset_asaloleh_date"]').val(rowData.asset_asaloleh_date);
                $(`#${options.formMain}`).find('input[name="asset_procurement_year"]').val(rowData.asset_procurement_year);
                $(`#${options.formMain}`).find('input[name="asset_documents"]').val(rowData.asset_documents);
                $(`#${options.formMain}`).find('input[name="asset_group_items"]').val(rowData.asset_group_items);
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