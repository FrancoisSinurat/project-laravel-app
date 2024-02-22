"use strict"

let selectAsset = {

    init: function () {
        selectAsset.assetCategories();
        selectAsset.itemCategories();
        selectAsset.items();
        selectAsset.brands();
        selectAsset.types();
        selectAsset.asalolehs();
        selectAsset.asalpengadaans();
        selectAsset.bahans();
        selectAsset.satuans();
    },

    assetCategories: function () {

        let urlAssetCategories = $('.select2assetCategories').attr('data-action');

        $('.select2assetCategories').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            dataType: 'json',
            allowClear: true,
            placeholder: 'Pilih Aset',
            ajax: {
                url: urlAssetCategories,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {

                            console.log(item);
                            return {
                                text: item.asset_category_name,
                                id: item.asset_category_id,
                            }
                        })
                    };
                }
            }
        });

        $('.select2assetCategories').on('select2:select', function (item) {

            $('.select2itemCategories').val('');

            $('.select2items').val('');

            $('.select2brands').val('');

            $('.select2types').val('');

            selectAsset.itemCategories(item.params.data.id)
            selectAsset.items(item.params.data.assetCategories);
            selectAsset.brands(null);
            selectAsset.types(null);
        })

        $('.select2assetCategories').on('select2:clear', function (item) {

            $('.select2itemCategories').val('');

            $('.select2items').val('');

            $('.select2brands').val('');

            $('.select2types').val('');

            selectAsset.itemCategories(null)
            selectAsset.items(null);
            selectAsset.brands(null);
            selectAsset.types(null);
        })
    },

    itemCategories: function (assetCategory) {

        let urlItemCategories = $('.select2itemCategories').attr('data-action');

        $('.select2itemCategories').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Kategori',
            ajax: {
                url: urlItemCategories,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        assetCategory: assetCategory,
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.item_category_name,
                                id: item.item_category_id,
                                itemCategory: item.item_category_id
                            }
                        })
                    };
                }
            }
        });

        $('.select2itemCategories').on('select2:select', function (item) {

            $('.select2items').val('');

            $('.select2brands').val('');

            $('.select2types').val('');

            selectAsset.items(item.params.data.itemCategory)
        })

        $('.select2itemCategories').on('select2:clear', function (item) {

            $('.select2items').val('');

            $('.select2brands').val('');

            $('.select2types').val('');

            selectAsset.items(null);
            selectAsset.brands(null);
            selectAsset.types(null);
        })

    },

    items: function (itemCategory) {

        let urlItem = $('.select2items').attr('data-action');

        $('.select2items').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Item',
            ajax: {
                url: urlItem,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        itemCategory: itemCategory,
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.item_name,
                                id: item.item_id,
                                item: item.item_id
                            }
                        })
                    };
                }
            }
        });

        $('.select2items').on('select2:select', function (item) {

            $('.select2brands').val('');

            selectAsset.brands(item.params.data.item)
        })

        $('.select2items').on('select2:clear', function (item) {

            $('.select2brands').val('');

            $('.select2types').val('');

            selectAsset.brands(null);
            selectAsset.types(null);
        })
    },

    brands: function (item) {

        let urlBrand = $('.select2brands').attr('data-action');

        $('.select2brands').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Merk',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        item: item,
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.item_brand_name,
                                id: item.item_brand_id,
                                brand: item.item_brand_id
                            }
                        })
                    };
                }
            }
        });

        $('.select2brands').on('select2:select', function (item) {

            $('.select2types').val('');

            selectAsset.types(item.params.data.brand)
        })

        $('.select2brands').on('select2:clear', function (item) {
            $('.select2types').val('');

            selectAsset.types(null);
        })
    },

    types: function (brand) {

        let urlBrand = $('.select2types').attr('data-action');

        $('.select2types').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Tipe',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        brand: brand,
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.item_type_name,
                                id: item.item_type_id,
                            }
                        })
                    };
                }
            }
        });
    },

    asalolehs: function () {

        let urlBrand = $('.select2asalolehs').attr('data-action');

        $('.select2asalolehs').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Asal Oleh',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.asaloleh_category_name,
                                id: item.asaloleh_category_id,
                            }
                        })
                    };
                }
            }
        });
    },

    asalpengadaans: function () {

        let urlBrand = $('.select2asalpengadaans').attr('data-action');

        $('.select2asalpengadaans').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Asal Pengadaan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.asalpengadaan_category_name,
                                id: item.asalpengadaan_category_id,
                            }
                        })
                    };
                }
            }
        });
    },

    bahans: function () {

        let urlBrand = $('.select2bahans').attr('data-action');

        $('.select2bahans').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Bahan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.bahan_category_name,
                                id: item.bahan_category_id,
                            }
                        })
                    };
                }
            }
        });
    },

    satuans: function () {

        let urlBrand = $('.select2satuans').attr('data-action');

        $('.select2satuans').select2({
            dropdownParent: $('#asset-type-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Satuan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.satuan_category_name,
                                id: item.satuan_category_id,
                            }
                        })
                    };
                }
            }
        });
    }
}

$(document).ready(function () {
    selectAsset.init();
});

