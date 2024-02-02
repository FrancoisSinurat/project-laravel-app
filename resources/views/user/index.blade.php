<x-layout>
    @section('title', 'User')
    <section class="section">
        <x-modal id="user-modal" size="modal-xl">
            <x-slot name="title">Form User</x-slot>
            <x-slot name="body">
                <form id="user-form" class="form needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <input name="user_id" type="hidden" id="user_id">
                                <label for="user-fullname" class="col-form-label mandatory">Nama</label>
                                <input type="text" name="user_fullname" class="form-control" id="user-fullname" required>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user-name" class="col-form-label mandatory">NIP</label>
                                <input type="text" name="user_name" class="form-control" id="user-name" required>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user-email" class="col-form-label mandatory">Email</label>
                                <input type="email" name="user_email" class="form-control" id="user-email" required>
                                <div class="invalid-feedback">
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
                                <input name="user_password" type="hidden" id="user_password">
                                <label for="user-password" class="col-form-label mandatory">Password</label>
                                <input type="password" name="user_password" class="form-control" id="user-password" required>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <input name="user_confirm_password" type="hidden" id="user_confirm_password">
                                <label for="user-confirm-password" class="col-form-label mandatory">Konfirmasi Password</label>
                                <input type="password" name="user_confirm_password" class="form-control" id="user-confirm-password" required>
                                <div class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="type-role" class="col-form-label mandatory">Pilih Hak Akses</label>
                                <select class="form-control" name="asset_category_id" id="type-role">
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
                                <a data-bs-toggle="modal" data-bs-target="#user-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="user-table" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
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
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    @push('scripts')
        <script type="text/javascript">
            let modal = 'user-modal';
            let urlPost = "{{ route('admin.user.store') }}";
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
                            data: 'user_name',
                            name: 'user_name',
                        },
                        {
                            data: 'user_email',
                            name: 'user_email'
                        },
                        {
                            name: 'action',
                            data: 'user_id',
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

                let forms = $('#user-form');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                        } else {
                            let formData = $('#user-form').serialize();
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
                    forms.find('input[name="user_name"]').val(rowData.user_name);
                    forms.find('input[name="user_email"]').val(rowData.user_email);
                    $("#type-role").val(rowData.asset_category.asset_category_id).change();
                    $('#'+options.modal).modal('show');
                    $('#'+options.modal).find('#save').text('Ubah');
                    options.id = rowData.user_id;
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.user_name;
                    deleteData(rowData.user_id);
                })

                $(window).on('hide.bs.modal', function() {
                    $('#'+options.modal).find('#save').text('Simpan');
                    forms.trigger('reset');
                    forms.removeClass('was-validated');
                    options.id = null;
                });
            });
        </script>
    @endpush
</x-layout>
