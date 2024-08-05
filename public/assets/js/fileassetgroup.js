let fileInput = null;
let docNameUpload = '';
let statusUpload = false;

const newUpload = () => {
    fileInput = null;
    docNameUpload = '';
    statusUpload = false;
    $('#asset_documents').prop('disabled', false);
}

const populateFile = async (form) => {
    fileInputs = []; // Clear previous files

    $(`#${form}`).find("input[type=file][name='asset_documents']").each(function(index, field) {
        const file = field.files[0];
        if (file) {
            console.log($(this).data('name'));
            fileInputs.push({file, name: $(this).data('name')});
        }
    });
}

function showLoadingFile() {
    Swal.fire({
        title: 'Loading....',
        html: `Mohon menunggu sedang mengunggah dokumen <span id="doc-name-upload">${docNameUpload}</span>`,
        icon: 'info',
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
        // onOpen: () => {
        //     swal.showLoading();
        // }
    });
}

const uploadFile = async (fileObj) => {
    if (fileObj.length === 0) {
        console.error("No file to upload.");
        return;
    }

    let url = $('#upload-container').data('upload-url');
    let form = $('#upload-container').data('form');
    let formDataUpload = new FormData();
    const file = fileObj[0].file; // Assume the first file is the one to upload

    formDataUpload.append('file', file);
    formDataUpload.append('name', fileObj[0].name);
    formDataUpload.append('path', 'dokumen');
    docNameUpload = fileObj[0].name;
    $('#doc-name-upload').text(fileObj[0].name);
    formDataUpload.append('driver', "{{env('FILESYSTEM_CLOUD', 'local')}}");

    showLoadingFile(); // Show loading message

    try {
        const response = await $.ajax({
            url,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formDataUpload
        });

        if (response && response.data && response.data.file) {
            const fsResult = response.data.file;
            let existsInput = $(`#${form} input[name="${fsResult.key}"]`);
            if (existsInput.length) $(`#${form} input[name="${fsResult.key}"]`).remove();
            $("<input />").attr("type", "hidden").attr("name", fsResult.key).attr("value", JSON.stringify(fsResult)).appendTo(`#${form}`);
        }
    } catch (err) {
        console.error("Upload failed:", err);
    } finally {
        $(`input[type=file]`).prop('disabled', true); // Disable file input after upload
    }
}

const getFile = async () => {
    populateFile();
    
    if (fileInput) {
        await uploadFile(fileInput); // Upload the file
    }
}
