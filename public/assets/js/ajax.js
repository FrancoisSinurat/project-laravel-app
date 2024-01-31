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

const GET_DATA = (options) => {
    console.log('GET_DATA', options);
    $.ajax({
        url: options.url + '/' + options.id,
        type: 'GET',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        success: (result) => {
            console.log(result);
        },
        error: (err) => {
            console.log(err);
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
            console.log(err);
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
        success: (data) => {
            if (modal) successEvent(options.modal, options.dataTable);
        },
        error: (err) => {
            console.log(err);
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
