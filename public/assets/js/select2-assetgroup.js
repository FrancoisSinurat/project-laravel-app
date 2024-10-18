"use strict";

let selectAssetGroups = {
    init: function () {
        // selectAssetGroups.assetCategories();
        // selectAssetGroups.itemCategories();
        
        selectAssetGroups.asalolehs();
        selectAssetGroups.asalpengadaanGroup();
      
    },

    asalolehs: function (asalOlehCategoryName = null) {
        let urlBrand = $(".selectasalolehGroup").attr("data-action");

        $(".selectasalolehGroup").select2({
            dropdownParent: $("#asset-group-type-modal .modal-content"),
            theme: "bootstrap-5",
            width: "100%",
            allowClear: true,
            placeholder: "Pilih Asal Oleh",
            ajax: {
                url: urlBrand,
                type: "GET",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: asalOlehCategoryName || params.term || "",
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.asaloleh_category_name,
                                id: item.asaloleh_category_id,
                            };
                        }),
                    };
                },
            },
        });
    },

    asalpengadaanGroup: function (asalPengadaanCategoryName = null) {
        let urlBrand = $(".selectasalpengadaanGroup").attr("data-action");

        $(".selectasalpengadaanGroup").select2({
            dropdownParent: $("#asset-group-type-modal .modal-content"),
            theme: "bootstrap-5",
            width: "100%",
            allowClear: true,
            placeholder: "Pilih Asal Pengadaan",
            ajax: {
                url: urlBrand,
                type: "GET",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: asalPengadaanCategoryName || params.term || "",
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.asalpengadaan_category_name,
                                id: item.asalpengadaan_category_id,
                            };
                        }),
                    };
                },
            },
        });
    },
};

$(document).ready(function () {
    selectAssetGroups.init();
});
