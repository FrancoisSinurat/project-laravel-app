const showLoadingDetail = (id) => $(`#loading-${id}`).removeClass('d-none');
const hideLoadingDetail = (id) => $(`#loading-${id}`).addClass('d-none');
const formatDateDMY = (inputDate) => {
    let date = new Date(inputDate);
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0');
    let year = date.getFullYear();
    let formattedDate = day + '-' + month + '-' + year;
    return formattedDate;
}

const generateDescription = (data) => {
    let description = '';
    if (data.historyable_type == 'App\\Models\\AssetUsed') description = `Digunakan Oleh ${data.historyable.user.user_fullname} (${data.historyable.user.user_nrk})`;
    return description;
}

const showAssetOnModal = (data) => {
    const { asset, history, peminjaman } = data;
    hideLoadingDetail(asset.asset_code);
    let detailTitle = `${asset.asset_name}`;
    $(`#${data.modal}`).modal('show');
    $(`#${data.modal}-title`).html(detailTitle);
    $('asset-detail-additional').addClass('d-none')
    if (asset.item_category_code == 'KDO') {
        $('.asset-detail-additional').removeClass('d-none')
    }
    for (let [k, v] of Object.entries(asset)) {
        if (!v) v = '';
        if (k == 'asset_documents') {
            let assetDoc = [];
            let doc = {};
            if (v) {
                doc = new Object(JSON.parse(v));
                let urlFile = $('.table-detail-asset').find(`#${k}`).data('url-file');
                if (doc?.dokumen_barang?.filename) {
                    assetDoc.push(`<a target="_blank" href="${urlFile}/upload/${doc.dokumen_barang.filename}?path=${doc.dokumen_barang.filepath}&driver=${doc.dokumen_barang.driver}">Dokumen Barang</a>`)
                }
                if (doc?.dokumen_penyedia?.filename) {
                    assetDoc.push(`<a target="_blank" href="${urlFile}/upload/${doc.dokumen_penyedia.filename}?path=${doc.dokumen_penyedia.filepath}&driver=${doc.dokumen_penyedia.driver}">Dokumen Penyedia</a>`)
                }
                if (doc?.dokumen_spj?.filename) {
                    assetDoc.push(`<a target="_blank" href="${urlFile}/upload/${doc.dokumen_spj.filename}?path=${doc.dokumen_spj.filepath}&driver=${doc.dokumen_spj.driver}">Dokumen SPJ</a>`)
                }
            }
            if (assetDoc.length) $('.table-detail-asset').find(`#${k}`).html(`${assetDoc.join(', ')}`);
            // if (v) {
            //     $('.table-detail-asset').find(`#${k}`).html(`${v}`);
            // }
            console.log(doc);
        } else {
            $('.table-detail-asset').find(`#${k}`).html(`${v}`);
        }
        console.log(`${k}: ${v}`);
    }
    $('#asset-history tr:not(:first)').remove();
    history.forEach(v => {
        let description = generateDescription(v);
        $('#asset-history').append(`<tr>
            <td>
                ${new Date(v.created_at).getDate()}/${new Date(v.created_at).getMonth() + 1}/${new Date(v.created_at).getFullYear()}
            </td>
            <td>
                ${v.asset_history_status}
            </td>
            <td>
                ${description}
            </td>
        </tr>`)
    });
    $('#aset-peminjaman tr:not(:first)').remove();
    peminjaman.forEach(v => {
        $('#aset-peminjaman').append(`<tr>
            <td>
                ${new Date(v.created_at).getDate()}/${new Date(v.created_at).getMonth() + 1}/${new Date(v.created_at).getFullYear()}
            </td>
            <td>
                ${v.asset_peminjaman_status}
            </td>
            <td>
                Dipinjam Oleh ${v.user.user_fullname}
            </td>
        </tr>`)
    });
}
const editAssetOnModal = (data) => {
    const { asset } = data;
    hideLoadingDetail(asset.asset_code);
    console.log(asset);
    $(`#${data.modal}`).modal('show');
    if (asset?.asset_group?.asset_procurement_year) $(`#${data.modal}`).find('input[name="asset_procurement_year"]').val(asset.asset_group.asset_procurement_year);
    if (asset.asset_bpad_code) $(`#${data.modal}`).find('input[name="asset_bpad_code"]').val(asset.asset_bpad_code);
    if (asset.asset_serial_number) $(`#${data.modal}`).find('input[name="asset_serial_number"]').val(asset.asset_serial_number);
    if (asset.asset_police_number) $(`#${data.modal}`).find('input[name="asset_police_number"]').val(asset.asset_police_number);
    if (asset.asset_frame_number) $(`#${data.modal}`).find('input[name="asset_frame_number"]').val(asset.asset_frame_number);
    if (asset.asset_machine_number) $(`#${data.modal}`).find('input[name="asset_machine_number"]').val(asset.asset_machine_number);
    if (asset.asset_specification) $(`#${data.modal}`).find('textarea[name="asset_specification"]').val(asset.asset_specification);
    if (asset.asset_shrinkage) $(`#${data.modal}`).find('input[name="asset_shrinkage"]').val(asset.asset_shrinkage);
    if (asset.asset_category_id) $(`#${data.modal}`).find('input[name="asset_category_id"]').val(asset.asset_category_id);
    if (asset.item_category_id) $(`#${data.modal}`).find('input[name="item_category_id"]').val(asset.item_category_id);
    // if (asset.asset_used_by) {
    //     $(".select2users").empty().append(`<option value="${asset.asset_used_by}">${asset.user.user_fullname} - ${asset.user.user_nrk}</option>`).val(asset.asset_used_by).trigger('change');
    // }
    if (asset?.asset_group?.asset_document_number) {
        $(".select2groups").empty().append(`<option value="${asset?.asset_group?.asset_document_number}">${asset?.asset_group?.asset_document_number} (${asset?.asset_group?.asal_oleh?.asaloleh_category_name})</option>`).val(asset?.asset_group?.asset_document_number).trigger('change');
    }
    if (asset?.asset_group?.asalpengadaan_category_id) {
        $(".select2asalpengadaans").empty().append(`<option value="${asset.asset_group.asalpengadaan_category_id}">${asset.asset_group.asal_pengadaan.asalpengadaan_category_name}</option>`).val(asset.asset_group.asalpengadaan_category_id).trigger('change');
    }
    if (asset?.asset_group?.asaloleh_category_id) {
        $(".select2asalolehs").empty().append(`<option value="${asset.asset_group.asal_oleh.asaloleh_category_id}">${asset.asset_group.asal_oleh.asaloleh_category_name}</option>`).val(asset.asset_group.asaloleh_category_id).trigger('change');
    }
    if (asset.item_id) {
        $(".select2items").empty().append(`<option value="${asset.item_id}">${asset.item.item_name}</option>`).val(asset.item_id).trigger('change');
    }
    if (asset.item_brand_id) {
        $(".select2brands").empty().append(`<option value="${asset.item_brand_id}">${asset.item_brand.item_brand_name}</option>`).val(asset.item_brand_id).trigger('change');
    }
    if (asset.item_type_id) {
        $(".select2types").empty().append(`<option value="${asset.item_type_id}">${asset.item_type.item_type_name}</option>`).val(asset.item_type_id).trigger('change');
    }
    if (asset.bahan_category_id) {
        $(".select2bahans").empty().append(`<option value="${asset.bahan_category_id}">${asset.bahan.bahan_category_name}</option>`).val(asset.bahan_category_id).trigger('change');
    }
    if (asset.satuan_category_id) {
        $(".select2satuans").empty().append(`<option value="${asset.satuan_category_id}">${asset.satuan.satuan_category_name}</option>`).val(asset.satuan_category_id).trigger('change');
    }
    if (asset?.location?.location_id) {
        $(".select2locations").empty().append(`<option value="${asset.location_id}">${asset.location.location_name}</option>`).val(asset.location_id).trigger('change');
    }
    if (asset.asset_price) {
        $(`#${data.modal}`).find('input[name="asset_price"]').val(asset.asset_price);
        $(`#${data.modal}`).find('input[name="asset_price"]').keyup();
    }
    if (asset?.asset_group?.asset_asaloleh_date) {
        const asalOlehDate = new Date(asset.asset_group.asset_asaloleh_date).getDate() + '-' + (new Date(asset.asset_group.asset_asaloleh_date).getMonth() + 1) + '-' + new Date(asset.asset_group.asset_asaloleh_date).getFullYear();
        $(`#${data.modal}`).find('input[name="asset_asaloleh_date"]').val(asalOlehDate);
    }
    if (asset?.asset_group?.asset_documents) {
        let assetDoc = JSON.parse(asset.asset_group.asset_documents);
        // $(`#${data.modal}`).find('input[name="asset_asaloleh_date"]').val(asalOlehDate);
    }
}
const DETAIL_ASSET_ON_MODAL = (options) => {
    // merge options with new options
    let newOptions = {
        ...options,
        transform: true
    };
    showLoadingDetail(newOptions.assetCode);
    if (options.modal) newOptions.callbackModal = () => showAssetOnModal
    GET_DATA(newOptions);
}

const EDIT_ASSET_ON_MODAL = (options) => {
    // merge options with new options
    let newOptions = {
        ...options,
        transform: false
    };

    showLoadingDetail(newOptions.assetCode);
    if (options.modal) newOptions.callbackModal = () => editAssetOnModal
    GET_DATA(newOptions);
}

const APPROVED_ASET = (options) => {
    console.log('UPDATE_DATA', options);
    Swal.fire({
        title: "Persetujuan peminjaman aset",
        html: `Konfirmasi persetujuam peminjaman aset <span class="fw-bold">${options.dataTitle} </span>`,
        showCancelButton: true,
        icon: 'question',
        confirmButtonText: "Setujui",
        confirmButtonColor: "#0d6efd",
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            PATCH_DATA({
                ...options, data: {status: true}, isNotModal: true
            });
            options.id = null;
        } else if (result.isDenied) {
            options.id = null;
        }
    });
}

const REJECTED_ASET = (options) => {
    console.log('UPDATE_DATA', options);
    Swal.fire({
        title: "Penolakan peminjaman aset",
        html: `Konfirmasi penolakan peminjaman aset <span class="fw-bold">${options.dataTitle} </span>`,
        showCancelButton: true,
        icon: 'question',
        confirmButtonText: "Tolak",
        confirmButtonColor: "red",
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            PATCH_DATA({
                ...options, data: {status: false}, isNotModal: true
            });
            options.id = null;
        } else if (result.isDenied) {
            options.id = null;
        }
    });
}
