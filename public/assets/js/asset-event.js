const showLoadingDetail = (id) => $(`#loading-${id}`).removeClass('d-none');
const hideLoadingDetail = (id) => $(`#loading-${id}`).addClass('d-none');

const generateDescription = (data) => {
    let description = '';
    if (data.historyable_type == 'App\\Models\\AssetUsed') description = `Digunakan oleh ${data.historyable.user.user_fullname} (${data.historyable.user.user_nrk})`;
    return description;
}

const showAssetOnModal = (data) => {
    const { asset, history } = data;
    hideLoadingDetail(asset.asset_code);
    let detailTitle = `${asset.asset_name}`;
    $(`#${data.modal}`).modal('show');
    $(`#${data.modal}-title`).html(detailTitle);
    $('asset-detail-additional').addClass('d-none')
    if (asset.item_category_code == 'KDO') {
        $('.asset-detail-additional').removeClass('d-none')
    }
    for (const [k, v] of Object.entries(asset)) {
        if (v) $('table').find(`#${k}`).html(`${v}`);
        console.log(`${k}: ${v}`);
    }
    $('#asset-history tr:not(:first)').remove();
    history.forEach(v => {
        let description = generateDescription(v);
        $('#asset-history').append(`<tr>
            <td>
                ${new Date(v.created_at).toLocaleDateString()}
            </td>
            <td>
                ${v.asset_history_status}
            </td>
            <td>
                ${description}
            </td>
        </tr>`)
    });
}
const editAssetOnModal = (data) => {
    const { asset } = data;
    hideLoadingDetail(asset.asset_code);
    $(`#${data.modal}`).modal('show');
    if (asset.asset_procurement_year) $(`#${data.modal}`).find('input[name="asset_procurement_year"]').val(asset.asset_procurement_year);
    if (asset.asset_serial_number) $(`#${data.modal}`).find('input[name="asset_serial_number"]').val(asset.asset_serial_number);
    if (asset.asset_police_number) $(`#${data.modal}`).find('input[name="asset_police_number"]').val(asset.asset_police_number);
    if (asset.asset_frame_number) $(`#${data.modal}`).find('input[name="asset_frame_number"]').val(asset.asset_frame_number);
    if (asset.asset_machine_number) $(`#${data.modal}`).find('input[name="asset_machine_number"]').val(asset.asset_machine_number);
    if (asset.asset_specification) $(`#${data.modal}`).find('textarea[name="asset_specification"]').val(asset.asset_specification);
    if (asset.asset_shrinkage) $(`#${data.modal}`).find('input[name="asset_shrinkage"]').val(asset.asset_shrinkage);
    if (asset.asset_category_id) $(`#${data.modal}`).find('input[name="asset_category_id"]').val(asset.asset_category_id);
    if (asset.item_category_id) $(`#${data.modal}`).find('input[name="item_category_id"]').val(asset.item_category_id);
    if (asset.asset_used_by) {
        $(".select2users").empty().append(`<option value="${asset.asset_used_by}">${asset.user.user_fullname} - ${asset.user.user_nrk}</option>`).val(asset.asset_used_by).trigger('change');
    }
    if (asset.asalpengadaan_category_id) {
        $(".select2asalpengadaans").empty().append(`<option value="${asset.asalpengadaan_category_id}">${asset.asal_pengadaan.asalpengadaan_category_name}</option>`).val(asset.asalpengadaan_category_id).trigger('change');
    }
    if (asset.asaloleh_category_id) {
        $(".select2asalolehs").empty().append(`<option value="${asset.asal_oleh.asaloleh_category_id}">${asset.asal_oleh.asaloleh_category_name}</option>`).val(asset.asaloleh_category_id).trigger('change');
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
    if (asset.asset_price) {
        $(`#${data.modal}`).find('input[name="asset_price"]').val(asset.asset_price);
        $(`#${data.modal}`).find('input[name="asset_price"]').keyup();
    }

    if (asset.asset_asaloleh_date) {
        const asalOlehDate = new Date(asset.asset_asaloleh_date).getDate() + '-' + new Date(asset.asset_asaloleh_date).getMonth() + '-' + new Date(asset.asset_asaloleh_date).getFullYear();
        $(`#${data.modal}`).find('input[name="asset_asaloleh_date"]').val(asalOlehDate);
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