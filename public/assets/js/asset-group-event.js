const showLoadingDetail = (id) => $(`#loading-${id}`).removeClass("d-none");
const hideLoadingDetail = (id) => $(`#loading-${id}`).addClass("d-none");
const formatDateDMY = (inputDate) => {
    let date = new Date(inputDate);
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0');
    let year = date.getFullYear();
    let formattedDate = day + '-' + month + '-' + year;
    return formattedDate;
}
const showAssetOnModal = (data) => {
    const { asset } = data;
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
            if (v) {
                $('.table-detail-asset').find(`#${k}`).html(`${v}`);
            }
            console.log(doc);
        } 
        console.log(`${k}: ${v}`);
    }
}
const editAssetOnModal = (data) => {
    const { asset } = data;
    hideLoadingDetail(asset.asset_code);
    console.log(asset);
    $(`#${data.modal}`).modal('show');
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