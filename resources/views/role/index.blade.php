<x-layout>
    @section('title', 'Role')
    <style>
        .permission {
            text-transform: lowercase;
            font-size: small;
            font-weight: normal;
        }
        .permission-divider {
            margin: 0.45rem;
        }
        .role-title {
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    <section class="section">
        <x-modal id="role" size="modal-xl">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="form-role" class="form needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input name="id" type="hidden" id="id">
                                <label for="name" class="col-form-label mandatory">Role</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                                <div id="name_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row permission">
                                    @foreach ($populatePermission as $key => $item)

                                    <div class="col-md-4 mb-3">
                                        <span class="role-title">{{$key}}:<br><hr class="permission-divider"></span>
                                        @foreach ($item as $itemPermission)
                                        <div class="form-check mb-2">
                                                <input class="form-check-input" name="permission[{{$itemPermission['id']}}]" type="checkbox" value="{{$itemPermission['id']}}" id="{{$itemPermission['id']}}">
                                                <label class="form-check-label" for="{{$itemPermission['id']}}">
                                                    {{$itemPermission['name']}}
                                                </label>
                                        </div>
                                    @endforeach
                                </div>
                                    @endforeach
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
                                <a data-bs-toggle="modal" data-bs-target="#role" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="role-table" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
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
            let modal = 'role';
            let urlPost = "{{ route('admin.role.store') }}";
            let formMain = 'form-role';
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
                dataTableList = $('#role-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'id',
                            name: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            name: 'action',
                            data: 'id',
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
                    console.log(formData);
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
                    $(`#${options.formMain}`).find('input[name="name"]').val(rowData.name);
                    rowData.permissions.forEach(v => {
                        $('#'+v.id).prop('checked', true);
                    });
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.name;
                    deleteData(rowData.id);
                })
            });
        </script>
    @endpush
</x-layout>
