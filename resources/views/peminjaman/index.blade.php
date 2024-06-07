<x-layout>
    @push('styles')
    <style>
        .text-nav{
            color:#012970
        }

        .form-text {
            text-transform: lowercase;
            font-style: italic;
            font-weight: lighter;
        }
    </style>
    <link href="{{asset('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css')}}" rel="stylesheet">
    @endpush
    @section('title', 'Peminjaman')
    <section class="section">
    <x-modal id="peminjaman-modal" size="modal-lg">
            <x-slot name="title">Form @yield('title')</x-slot>
            <x-slot name="body">
                <form id="peminjaman-type-form" class="form needs-validation" novalidate>
                <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="col-form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" value="{{ Session::get('user.user_fullname')}}" readonly>
                                <input type="hidden" name="user_id" id="user_id" value="{{ Session::get('user.user_id')}}">
                                <input type="hidden" name="asset_peminjaman_status" id="asset_peminjaman_status" value="MENUNGGU PERSETUJUAN">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="asset_id" class="col-form-label">Nama Aset yang Dipinjam</label>
                                <select class="form-control select2assets" data-action="{{route('admin.asset.ajax')}}" name="asset_id" id="asset_id">
                                </select>
                                <div id="asset_id_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="asset_peminjaman_datetime" class="col-form-label mandatory">Tanggal Waktu Peminjaman </label>
                                <input type="text" name="asset_peminjaman_datetime" id="asset_peminjaman_datetime" class="form-control" required>
                                <div id="asset_peminjaman_datetime_feedback" class="invalid-feedback">
                                    Wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="asset_pengembalian_datetime" class="col-form-label mandatory">Tanggal Waktu Pengembalian</label>
                                <input type="text" name="asset_pengembalian_datetime" id="asset_pengembalian_datetime" class="form-control" required>
                                <div id="asset_pengembalian_datetime_feedback" class="invalid-feedback">
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
        <x-modal id="asset-detail-modal" size="modal-fullscreen">
            <x-slot name="title">Asset Detail Modal</x-slot>
            <x-slot name="body">
                <x-asset.detail-asset></x-asset.detail-asset>
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
                                <a data-bs-toggle="modal" data-bs-target="#peminjaman-modal" href="javascript:void(0)"
                                    class="btn btn-sm btn-primary mb-2">Tambah Data</a>
                            </div>
                            @endif
                        </div>
                        {{-- @if(auth()->user()->hasPermissionTo('aset-persetujuan_peminjaman')) --}}
                        <div class="table-responsive">
                            <table id="peminjaman-table" class="table display nowrap table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Waktu Peminjaman</th>
                                        <th>Tanggal Waktu Pengembalian</th>
                                        <th>Status</th>
                                        <th>Aset</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js')}}"></script>
        <script src="{{ asset('assets/js/select2-asset.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script src="{{ asset('assets/js/asset-event.js') }}"></script>
        <script src="{{ asset('assets/js/simple.money.format.js') }}"></script>
        <script type="text/javascript">
            let modal = 'peminjaman-modal';
            let urlPost = "{{ route('admin.peminjaman.store') }}";
            let formMain = 'peminjaman-type-form';
            let loginUserId = "{{auth()->user()->user_id}}";
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
                $('#asset_peminjaman_datetime').datetimepicker({
                    uiLibrary: 'bootstrap5',
                    format: 'dd-mm-yyyy HH:MM'
                });

                $('#asset_pengembalian_datetime').datetimepicker({
                    uiLibrary: 'bootstrap5',
                    format: 'dd-mm-yyyy HH:MM'
                });

                dataTableList = $('#peminjaman-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    order: [[0, 'desc']],
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'asset_peminjaman_id',
                            name: 'asset_peminjaman_id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'user.user_fullname',
                            name: 'user.user_fullname',
                        },
                        {
                            data: 'asset_peminjaman_datetime',
                            name: 'asset_peminjaman_datetime',
                        },
                        {
                            data: 'asset_pengembalian_datetime',
                            name: 'asset_pengembalian_datetime',
                        },
                        {
                            data: 'asset_peminjaman_status',
                            name: 'asset_peminjaman_status',
                        },
                        {
                            data: 'asset.asset_name',
                            name: 'asset.asset_name',
                        },
                        {
                            name: 'action',
                            data: 'asset_peminjaman_id',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {

                                let buttonApprove = '';
                                row.peminjaman_approval.forEach(v => {
                                    if (loginUserId == v.user.user_id && data == v.asset_peminjaman_id && v.asset_peminjaman_approval_status == 'MENUNGGU PERSETUJUAN') {
                                      buttonApprove = ` <button type="button" data-id="${data}" data-status="true" class="btn btn-sm btn-edit btn-primary"><i class="bi bi-check"></i></button>
                                                        <button type="button" data-id="${data}" data-status="false" class="btn btn-sm btn-edit btn-danger"><i class="bi bi-x"></i></button>`;
                                    }
                                });
                                let button = `
                                @if(auth()->user()->hasPermissionTo('aset-persetujuan_peminjaman') || auth()->user()->hasPermissionTo('peminjaman-delete') || auth()->user()->hasPermissionTo('peminjaman-list'))
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group" role="group">
                                            @if(auth()->user()->hasPermissionTo('aset-persetujuan_peminjaman'))
                                                ${buttonApprove}
                                            @endif
                                            @if(auth()->user()->hasPermissionTo('peminjaman-list'))
                                                <button type="button" data-id="${data}" class="btn btn-sm btn-show btn-success"><i class="bi bi-eye-fill"></i></button>
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
                        {
                            data: 'asset.asset_code',
                            name: 'asset.asset_code',
                            visible: false,
                        }
                    ]
                });

                const saveData = (formData) => {
                    options.data = formData;
                    options.dataTable = dataTableList;
                    POST_DATA(options);
                }

                const updateData = (id, status) => {
                    options.id = id;
                    options.status = status;
                    options.dataTable = dataTableList;
                    console.log(status);
                    if (status == 'true') APPROVED_ASET(options);
                    if (status == 'false') REJECTED_ASET(options);
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
                        }
                    });
                });

                $(document).on('click','.btn-edit',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.asset.asset_name;
                    updateData(rowData.asset_peminjaman_id, $(this).attr('data-status'));
                })

                $(document).on('click','.btn-show',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data();
                    console.log(rowData);
                    let newOptions = {
                        url: "{{ route('admin.asset.store') }}",
                        id: rowData.asset_id,
                        modal: 'asset-detail-modal',
                        assetCode: rowData.asset.asset_code,
                    }
                    DETAIL_ASSET_ON_MODAL(newOptions);
                })

                $(document).on('click','.btn-delete',function(){
                    let rowData = dataTableList.row($(this).parents('tr')).data()
                    options.dataTitle = rowData.asset_peminjaman_id;
                    deleteData(rowData.asset_peminjaman_id);
                })

            });
        </script>
    @endpush
</x-layout>
