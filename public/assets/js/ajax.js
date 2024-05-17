function reloadTable (dataTable) {
    if (dataTable) dataTable.ajax.reload();
} 

function successEvent(modalId, dataTable = null) {
    const modalEl  = document.querySelector('#'+modalId);
    const modalObj = bootstrap.Modal.getInstance(modalEl);
    if (modalObj ==  null){
       return;
    }
    SUCCESS_ALERT();
    if (dataTable) reloadTable(dataTable);
    options.enabledButton();
    modalObj.hide();
}

function errorEvent() {
    ERROR_ALERT();
    options.enabledButton();
}

function validation(err) {
    if (err?.errors) {
        options.error = err.errors;
        $('form').addClass('was-validated');
        for (const [key, value] of Object.entries(err.errors)) {
            $(`#${key}`).val('');
            $(`#${key}_feedback`).text(value[0]);
        }
    }
}

$(window).on('hide.bs.modal', function() {
    if (options.modal) $('#'+options.modal).find('.btn-name').text('Simpan');
    if (options.formMain) {
        $('#'+options.formMain).removeClass('was-validated');
        $('#'+options.formMain).trigger('reset');
        $('#'+options.formMain+' select').val('').trigger('change');
    }
    options.id = null;
    if (options.error) {
        for (const [key, value] of Object.entries(options.error)) {
            $(`#${key}`).val('');
            $(`#${key}_feedback`).text('Wajib diisi');
        }
        options.error = null;
    }
    $(`#${options.modal}`).find('#save').show();
});

const GET_DATA = (options) => {
    let url =  options.url + '/' + options.id + '';
    if (options.transform) url = url + '?transform=true';
    $.ajax({
        url,
        type: 'GET',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
    }).then((data) => {
        const result = data.data;
        if (options.modal) {
            result.modal = options.modal;
            options.callbackModal()(result);
        }
    });

}

const POST_DATA = (options) => {
    console.log('POST_DATA', options);
    $.ajax({
        url: options.url,
        type: 'POST',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        data: options.data,
        success: () => {
            if (modal) successEvent(options.modal, options.dataTable);
        },
        error: (err) => {
            const resErr = err?.responseJSON;
            validation(resErr);
            if (resErr.message) ERROR_ALERT(resErr.message);
            options.enabledButton();
        }
    });
}

const PATCH_DATA = (options) => {
    console.log('PATCH_DATA', options);
    $.ajax({
        url: options.url + '/' + options.id,
        type: 'PATCH',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        data: options.data,
        beforeSend: () => {
            LOADING_ALERT('Sedang merubah data');
        },
        success: (data) => {
            if (modal && !options.isNotModal) successEvent(options.modal, options.dataTable);
            if (options.isNotModal) {
                    SUCCESS_ALERT('Berhasil merubah data');
                     reloadTable(options.dataTable);
            }
        },
        error: (err) => {
            console.log(err);
            const resErr = err?.responseJSON;
            validation(resErr);
            if (resErr?.message && !options.isNotModal) {
                ERROR_ALERT(resErr?.message);
                options.enabledButton();
            }
            else {
                ERROR_ALERT('Gagal');
            }
        }
    });
}

const DELETE_DATA = (options) => {
    console.log('DELETE_DATA', options);
    Swal.fire({
        title: "Anda yakin ingin menghapus data?",
        html: `data <span class="fw-bold">${options.dataTitle} </span>akan dihapus`,
        showCancelButton: true,
        icon: 'question',
        confirmButtonText: "Hapus",
        confirmButtonColor: "#0d6efd",
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: options.url + '/' + options.id,
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _method: 'delete'
                },
                beforeSend: () => {
                    LOADING_ALERT('Sedang menghapus data');
                },
                success: () => {
                    SUCCESS_ALERT('Berhasil menghapus data');
                    reloadTable(options.dataTable);
                },
                error: (err) => {
                    console.log(err);
                }
            });
            options.id = null;
        } else if (result.isDenied) {
            options.id = null;
        }
    });
}
