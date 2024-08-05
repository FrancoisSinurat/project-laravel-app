function reloadTable(dataTable) {
    // console.log('reload event');
    if (dataTable) dataTable.ajax.reload();
}

function successEvent(modalId = null, dataTable = null) {
    // console.log(modalId, 'succes event', dataTable);
    if (modalId) {
        const modalEl = document.querySelector("#" + modalId);
        const modalObj = bootstrap.Modal.getInstance(modalEl);
        if (modalObj == null) {
            return;
        }
        modalObj.hide();
    }
    SUCCESS_ALERT();
    if (dataTable) reloadTable(dataTable);
    options.enabledButton();
}

function errorEvent() {
    ERROR_ALERT();
    options.enabledButton();
}

function validation(err) {
    if (err?.errors) {
        options.error = err.errors;
        $("form").addClass("was-validated");
        for (const [key, value] of Object.entries(err.errors)) {
            $(`#${key}`).val("");
            $(`#${key}_feedback`).text(value[0]);
        }
    }
}

$(window).on("hide.bs.modal", function () {
    if (options.modal)
        $("#" + options.modal)
            .find(".btn-name")
            .text("Simpan");
    if (options.formMain) {
        $("#" + options.formMain).removeClass("was-validated");
        $("#" + options.formMain).trigger("reset");
        $("#" + options.formMain + " select")
            .val("")
            .trigger("change");
    }
    options.id = null;
    if (options.error) {
        for (const [key, value] of Object.entries(options.error)) {
            $(`#${key}`).val("");
            $(`#${key}_feedback`).text("Wajib diisi");
        }
        options.error = null;
    }
    $(`#${options.modal}`).find("#save").show();
});

const GET_DATA = (options) => {
    let url = options.url + "/" + options.id + "";
    if (options.transform) url = url + "?transform=true";
    $.ajax({
        url,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .then((data) => {
            const result = data.data;
            if (options.modal) {
                result.modal = options.modal;
                options.callbackModal()(result);
            }
        })
        .catch((err) => {
            ERROR_ALERT(err?.message || "Terjadi Kendala");
            if (options.dataTable) reloadTable(options.dataTable);
        });
};

const POST_DATA = (options) => {
    console.log("POST_DATA", options);
    $.ajax({
        url: options.url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: options.data,
        beforeSend: () => {
            // LOADING_ALERT('Sedang menyimpan data');
        },
        success: () => {
            if (modal) successEvent(options.modal, options.dataTable);
            if (options.dataTableId) {
                $(`${options.dataTableId}`).DataTable().ajax.reload();
                options.dataTableId = null;
            }
        },
        error: (err) => {
            const resErr = err?.responseJSON;
            validation(resErr);
            if (resErr.message) {
                ERROR_ALERT(resErr.message);
            }
            options.enabledButton();
            if (options.file) $(`input[type=file]`).prop("disabled", false);
        },
    });
};

const PATCH_DATA = (options) => {
    console.log("PATCH_DATA", options);
    $.ajax({
        url: options.url + "/" + options.id,
        type: "PATCH",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: options.data,
        beforeSend: () => {
            // LOADING_ALERT('Sedang merubah data');
        },
        success: (data) => {
            if (modal && !options.isNotModal)
                successEvent(options.modal, options.dataTable);
            if (options.isNotModal) {
                SUCCESS_ALERT("Berhasil merubah data");
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
            } else {
                ERROR_ALERT("Gagal merubah data");
            }
        },
    });
};

const DELETE_DATA = (options) => {
    console.log("DELETE_DATA", options);
    Swal.fire({
        title: "Anda yakin ingin menghapus data?",
        html: `data <span class="fw-bold">${options.dataTitle} </span>akan dihapus`,
        showCancelButton: true,
        icon: "question",
        confirmButtonText: "Hapus",
        confirmButtonColor: "#0d6efd",
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: options.id ? options.url + "/" + options.id : options.url,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                data: {
                    _method: "delete",
                },
                beforeSend: () => {
                    LOADING_ALERT("Sedang menghapus data");
                },
                success: () => {
                    setTimeout(() => {
                        SUCCESS_ALERT("Berhasil menghapus data");
                        if (options.dataTableId) {
                            $(`${options.dataTableId}`)
                                .DataTable()
                                .ajax.reload();
                            options.dataTableId = null;
                        }
                    }, 100);
                    reloadTable(options.dataTable);
                },
                error: (err) => {
                    console.log(err);
                    setTimeout(() => {
                        ERROR_ALERT("Gagal menghapus data");
                    }, 100);
                },
            });
            options.id = null;
        } else if (result.isDenied) {
            options.id = null;
        }
    });
};
