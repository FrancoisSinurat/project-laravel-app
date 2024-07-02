<x-layout>
    @section('title', 'User')
    <section class="section">
        <x-modal id="user-modal" size="modal-xl">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="user-form" class="form needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <input name="user_id" type="hidden" id="user_id">
                                <label for="user_fullname" class="col-form-label mandatory">Nama</label>
                                <input type="text" name="user_fullname" class="form-control" id="user_fullname" required>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_nrk" class="col-form-label">NRK</label>
                                <input type="text" name="user_nrk" class="form-control" id="user_nrk">
                                <div id="user_nrk_feedback" class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_email" class="col-form-label mandatory">Email</label>
                                <input type="email" name="user_email" class="form-control" id="user_email" required>
                                <div id="user_email_feedback" class="invalid-feedback">
                                    Email wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user-phone" class="col-form-label">No.Telepon</label>
                                <input type="text" name="user_phone" class="form-control" id="user-phone">
                            </div>
                            <div class="mb-3">
                                <label for="user-address" class="col-form-label">Alamat</label>
                                <textarea name="user_address" class="form-control" id="user-address" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_password" class="col-form-label mandatory">Password</label>
                                <input type="password" name="user_password" class="form-control" id="user_password" required>
                                <div id="user_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_confirm_password" class="col-form-label mandatory">Konfirmasi Password</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user_confirm_password" required>
                                <div id="user_confirm_password_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="col-form-label mandatory">Pilih Hak Akses</label>
                                <select class="form-control" name="role_id" id="role_id">
                                    <option value="" disabled>Pilih Role</option>
                                    @foreach ($role as $v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
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
                </form>
            </x-slot>
        </x-modal>
        <div class="row">
            <div class="col-md-12 h-100">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <div>@yield('title')</div>
                            @if(auth()->user()->hasPermissionTo('user-create')) 
                            <div>
                                <a data-bs-toggle="modal" data-bs-target="#user-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="user-table" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NRK</th>
                                        <th>Email</th>
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
            let modal = 'user-modal';
            let urlPost = "{{ route('admin.user.store') }}";
            let formMain = 'user-form';
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
                },
                validation: null,
            }

            $(document).ready(function() {
                dataTableList = $('#user-table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'user_id',
                            name: 'user_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'user_fullname',
                            name: 'user_fullname',
                        },
                        {
                            data: 'user_nrk',
                            name: 'user_nrk',
                        },
                        {
                            data: 'user_email',
                            name: 'user_email'
                        },
                        {
                            data: 'roles',
                            name: 'roles',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return data[0]?.name || '';
                            }
                        },
                        {
                            name: 'action',
                            data: 'user_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                let button = `
                                @if(auth()->user()->hasPermissionTo('user-edit') || auth()->user()->hasPermissionTo('user-delete'))
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if(auth()->user()->hasPermissionTo('user-edit')) 
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('user-delete')) 
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

                options.validation = (err) => {
                    console.log(`error`, err);
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
                    console.log(rowData);
                    $(`#${options.formMain}`).find('input[name="user_name"]').val(rowData.user_name);
                    $(`#${options.formMain}`).find('input[name="user_email"]').val(rowData.user_email);
                    if (rowData.user_nrk) $(`#${options.formMain}`).find('input[name="user_nrk"]').val(rowData.user_nrk);
                    if (rowData.user_address) $(`#${options.formMain}`).find('input[name="user_address"]').val(rowData.user_address);
                    if (rowData.user_phone) $(`#${options.formMain}`).find('input[name="user_phone"]').val(rowData.user_phone);
                    if (rowData.user_fullname) $(`#${options.formMain}`).find('input[name="user_fullname"]').val(rowData.user_fullname);
                    $(`#${options.formMain}`).find('input[name="user_password"]').prop('required',false);
                    $(`#${options.formMain}`).find('input[name="user_confirm_password"]').prop('required',false);
                    $("#role_id").val(rowData.roles[0]?.id || null).change();
                    $(`#${options.modal}`).modal('show');
                    $(`#${options.modal}`).find('.btn-name').text('Ubah');
                    options.id = rowData.user_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.user_name;
                    deleteData(rowData.user_id);
                })
            });
        </script>
    @endpush
</x-layout>
