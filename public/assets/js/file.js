let fileInputs = [];
let appFiles = [];
let counterUpload = 0;
let docNameUpload = '';
let statusUpload = false;

const newUpload = () => {
    fileInputs = [];
    appFiles = [];
    counterUpload = 0;
    docNameUpload = '';
    $(`input[type=file]`).prop('disabled', false);
}

function showLoading () {
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


const uploadFile = async (fileObj, totalFile) =>
{
    let url = $('#upload-container').data('upload-url');
    let form = $('#upload-container').data('form');
    let formDataUpload = new FormData();
    console.log(fileObj);
    formDataUpload.append('file', fileObj[counterUpload].file);
    formDataUpload.append('name', fileObj[counterUpload].name);
    formDataUpload.append('path', 'dokumen');
    docNameUpload = fileObj[counterUpload].name;
    $('#doc-name-upload').text(fileObj[counterUpload].name);
    formDataUpload.append('driver', "{{env('FILESYSTEM_CLOUD', 'local')}}")
    await $.ajax({
        url,
        type: "POST",
        processData: false,
        contentType: false,
        cache:false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formDataUpload,
        success: async function(data){
            if(data && data.data && data.data.file) {
                const fsResult = data.data.file;
                counterUpload++;
                let existsInput =  $(`#${form} input[name="${fsResult.key}"]`);
                if (existsInput.length) $(`#${form} input[name="${fsResult.key}"]`).remove();
                $("<input />").attr("type", "hidden").attr("name", fsResult.key).attr("value", JSON.stringify(fsResult)).appendTo(`#${form}`);
            }
        },
        error: (err) => {
          console.log(err);
        }
    });
    if (counterUpload !== totalFile) await uploadFile(fileInputs, totalFile);
    if (counterUpload == totalFile) {
        $(`input[type=file]`).prop('disabled', true);
    }
}

const populateFile = async (form) =>
{
    $(`#${form}`).find("input[type=file]").each(function(index, field){
        const file = field.files[0];
        if (file) {
            console.log($(this).data('name'));
            fileInputs.push({file, name: $(this).data('name')});
        }
    });
}

const getFile = async () => {

}
