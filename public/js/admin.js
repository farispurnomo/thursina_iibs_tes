$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

function initDatatable(id, url, columns, search = {}, domain = [], additional = {}) {
    const datatable = $(id).DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        columns: columns,
        ajax: {
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (dtp) {
                dtp['filter']       = search;
                dtp['domain']       = domain;
                dtp['additional']   = additional;
                // console.log(dtp);
                // for (const property in search) {
                // dtp['filter'][property] = search[property];
                // }
                return dtp;
            }
        },
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const href = $(e.currentTarget).attr('href');

        swal.fire({
            title: "Apakah Anda Yakin ?",
            text: "Data akan terhapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    url: href,
                    method: 'DELETE',
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == 200) {
                            Swal.fire('Berhasil', response.msg, 'success');
                        } else {
                            Swal.fire('Gagal', response.msg, 'error');
                        }

                        datatable.ajax.reload();
                    },
                    error: function (response) {
                        Swal.fire('Gagal', response.responseJSON.message, 'success');
                    }
                });
            }
        });
    });

    $(document).on('submit', '#form-datatable-search', function (e) {
        e.preventDefault();

        datatable.ajax.reload();

        return false;
    });

    return datatable;
}

function initSelect2(class_name, option, additionals) {
    let select;
    if (option.route_to == undefined) {
        select = $(class_name).select2({
            theme: 'bootstrap-5',
            placeholder: option.placeholder == undefined ?
                "Select Option" : option.placeholder,
            allowClear: option.allowClear == undefined ? false : option.allowClear,
            ...additionals
        });
    } else {
        select = $(class_name).select2({
            placeholder: option.placeholder == undefined ?
                "Select Option" : option.placeholder,
            allowClear: option.allowClear == undefined ? false : option.allowClear,
            theme: 'bootstrap-5',
            ajax: {
                url: option.route_to,
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: params.page * 30 < data.total_count
                        }
                    };
                },
                cache: true
            },
            tags: option.tag == undefined || option.tag == false ?
                false : option.tag,
            tokeSparator: [","],
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: option.MininputLength == undefined ?
                false : option.MininputLength,
            templateResult: formatResult, // omitted for brevity, see the source of this page
            templateSelection: formatResult, // omitted for brevity, see the source of this page
            ...additionals
        });

        function formatResult(result) {
            return result.text;
        }
    }

    return select;
}

function numberFormat(angka, absolute = true) {
    try {
        angka = angka.toString();

        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join(',');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        if (!absolute) {
            if (angka < 0) {
                rupiah = angka.charAt(0) + rupiah;
            }
        }
        return rupiah;

        // return new Intl.NumberFormat("id-ID", {
        //     style: "currency",
        //     currency: "IDR"
        // }).format(angka);
    } catch (error) {
        return '-';
    }
}

function terbilang(nilai) {
    // deklarasi variabel nilai sebagai angka matemarika
    // Objek Math bertujuan agar kita bisa melakukan tugas matemarika dengan javascript
    nilai = Math.floor(Math.abs(nilai));

    // deklarasi nama angka dalam bahasa indonesia
    const huruf = [
        '',
        'Satu',
        'Dua',
        'Tiga',
        'Empat',
        'Lima',
        'Enam',
        'Tujuh',
        'Delapan',
        'Sembilan',
        'Sepuluh',
        'Sebelas',
    ];

    // menyimpan nilai default untuk pembagian
    let bagi = 0;
    // deklarasi variabel penyimpanan untuk menyimpan proses rumus terbilang
    let penyimpanan = '';

    // rumus terbilang
    if (nilai < 12) {
        penyimpanan = ' ' + huruf[nilai];
    } else if (nilai < 20) {
        penyimpanan = terbilang(Math.floor(nilai - 10)) + ' Belas';
    } else if (nilai < 100) {
        bagi = Math.floor(nilai / 10);
        penyimpanan = terbilang(bagi) + ' Puluh' + terbilang(nilai % 10);
    } else if (nilai < 200) {
        penyimpanan = ' Seratus' + terbilang(nilai - 100);
    } else if (nilai < 1000) {
        bagi = Math.floor(nilai / 100);
        penyimpanan = terbilang(bagi) + ' Ratus' + terbilang(nilai % 100);
    } else if (nilai < 2000) {
        penyimpanan = ' Seribu' + terbilang(nilai - 1000);
    } else if (nilai < 1000000) {
        bagi = Math.floor(nilai / 1000);
        penyimpanan = terbilang(bagi) + ' Ribu' + terbilang(nilai % 1000);
    } else if (nilai < 1000000000) {
        bagi = Math.floor(nilai / 1000000);
        penyimpanan = terbilang(bagi) + ' Juta' + terbilang(nilai % 1000000);
    } else if (nilai < 1000000000000) {
        bagi = Math.floor(nilai / 1000000000);
        penyimpanan = terbilang(bagi) + ' Miliar' + terbilang(nilai % 1000000000);
    } else if (nilai < 1000000000000000) {
        bagi = Math.floor(nilai / 1000000000000);
        penyimpanan = terbilang(nilai / 1000000000000) + ' Triliun' + terbilang(nilai % 1000000000000);
    }

    // mengambalikan nilai yang ada dalam variabel penyimpanan
    return penyimpanan;
}