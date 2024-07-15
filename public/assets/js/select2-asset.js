"use strict"

let selectAsset = {

    init: function () {
        // selectAsset.assetCategories();
        // selectAsset.itemCategories();
        selectAsset.assets();
        selectAsset.items();
        selectAsset.brands();
        selectAsset.types();
        selectAsset.groups();
        selectAsset.asalolehs();
        selectAsset.asalpengadaans();
        selectAsset.bahans();
        selectAsset.satuans();
        selectAsset.users();
        selectAsset.locations();
    },

    assetCategories: function () {

        let urlAssetCategories = $('.select2assetCategories').attr('data-action');

        $('.select2assetCategories').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Aset',
            ajax: {
                url: urlAssetCategories,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Kategori',
            ajax: {
                url: urlItemCategories,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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

    assets: function () {

        let urlAssets = $('.select2assets').attr('data-action');

        $('.select2assets').select2({
            dropdownParent: $('#aset-peminjaman-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Asset',
            ajax: {
                url: urlAssets,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: item.asset_name,
                                id: item.asset_id,
                            }
                        })
                    };
                }
            }
        });
    },

    items: function (itemCategory) {

        let urlItem = $('.select2items').attr('data-action');

        $('.select2items').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Item',
            ajax: {
                url: urlItem,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        itemCategory: itemCategory || categoryId,
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
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Merk',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Tipe',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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

    asalolehs: function (asalOlehCategoryName = null) {
        let urlBrand = $('.select2asalolehs').attr('data-action');

        $('.select2asalolehs').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Asal Oleh',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: asalOlehCategoryName || params.term || ''
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

    asalpengadaans: function (asalPengadaanCategoryName = null) {

        let urlBrand = $('.select2asalpengadaans').attr('data-action');

        $('.select2asalpengadaans').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Asal Pengadaan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: asalPengadaanCategoryName || params.term || ''
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
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Bahan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Satuan',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
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
    },

    users: function () {
        let urlUsers = $('.select2users').attr('data-action');

        $('.select2users').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            minimumInputLength: 3,
            placeholder: 'Cari berdasarkan nama atau NRK',
            ajax: {
                url: urlUsers,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            let text = item.user_fullname;
                            if (item.user_nrk) text += '-'+item.user_nrk;
                            return {
                                text: text,
                                id: item.user_id,
                            }
                        })
                    };
                }
            }
        });
    },

    groups: function () {
        let urlGroups = $('.select2groups').attr('data-action');

        $('.select2groups').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            tags: true,
            allowClear: true,
            minimumInputLength: 3,
            placeholder: 'Cari Nomor Dokumen',
            ajax: {
                url: urlGroups,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            let text = item.asset_document_number;
                            if (item?.asal_oleh?.asaloleh_category_name) text += ` (${item.asal_oleh.asaloleh_category_name})`;
                            return {
                                text: text,
                                id: item.asset_document_number,
                                asaloleh_category_id: item?.asal_oleh?.asaloleh_category_id,
                                asaloleh_category_name: item?.asal_oleh?.asaloleh_category_name,
                                asalpengadaan_category_id: item?.asal_pengadaan?.asalpengadaan_category_id,
                                asalpengadaan_category_name: item?.asal_pengadaan?.asalpengadaan_category_name,
                                asset_asaloleh_date: formatDateDMY(item?.asset_asaloleh_date),
                                asset_procurement_year: item?.asset_procurement_year,
                            }
                        })
                    };
                }
            }
        });

        $('.select2groups').on('select2:select', function (item) {
            console.log(`select`, item);
            var optAsalPengadaan = $("<option selected='selected'></option>").val(item?.params?.data?.asalpengadaan_category_id).text(item?.params?.data?.asalpengadaan_category_name);
            $(".select2asalpengadaans").append(optAsalPengadaan).trigger('change');
            var optAsalOleh = $("<option selected='selected'></option>").val(item?.params?.data?.asaloleh_category_id).text(item?.params?.data?.asaloleh_category_name);
            $(".select2asalolehs").append(optAsalOleh).trigger('change');
            if (item?.params?.data?.asset_procurement_year) $("#asset_procurement_year").val(Number(item?.params?.data?.asset_procurement_year));
            if (item?.params?.data?.asset_asaloleh_date) $("#asset_asaloleh_date").val(item?.params?.data?.asset_asaloleh_date);
        })

        $('.select2groups').on('select2:clear', function (item) {
            console.log(`clear`, item);
            $(".select2asalpengadaans").val(null).trigger('change');
            $(".select2asalolehs").val(null).trigger('change');
            $("#asset_procurement_year").val(null);
            $("#asset_asaloleh_date").val(null);
        })
    },

    locations: function () {

        let urlBrand = $('.select2locations').attr('data-action');

        $('.select2locations').select2({
            dropdownParent: $('#asset-modal .modal-content'),
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Lokasi',
            ajax: {
                url: urlBrand,
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term || ''
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (item) {
                            return {
                                text: `${item.location_name} (${item.address})`  ,
                                id: item.location_id,
                            }
                        })
                    };
                }
            }
        });
    },
}

$(document).ready(function () {
    selectAsset.init();
});

