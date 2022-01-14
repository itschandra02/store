@extends('admin.layouts.layout')
@section('title')
    Add Data
@endsection
@section('top-scripts')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection
@section('content')

    <div class="row mb-5">
        <div class="col-lg-9">
            <div class=" card shadow">
                <div class="card-body">
                    <form class="floating-labels m-t-10" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" readonly name="id" id="id" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" id="product" class="form-control p-0">
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="namaData">Nama Data</label>
                                    <input type="text" name="namaData" id="namaData" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="number" name="discount" id="discount" value="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control p-0">
                                        <option value="diamond">diamond</option>
                                        <option value="voucher">voucher</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="layanan">Layanan</label>
                                    <input type="text" name="layanan" id="layanan" class="form-control"
                                        data-placement="right" data-original-title="Layanan" data-html="true"
                                        data-toggle="popover" data-container="body" data-trigger="focus">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <button class="btn btn-primary float-end" onclick="add_data();">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div id="voucher-panel">
                <div class="card shadow">
                    <div class="card-body">
                        <form class="floating-labels m-t-10" id="frmVoucher">
                            <div class="row">
                                <div class="form-group col-lg-7">
                                    <label for="v-data">Data</label>
                                    <input type="text" name="v-data" id="v-data" class="form-control">
                                </div>
                                <div class="form-group col-lg-5">
                                    <label for="v-expired">Expired At</label>
                                    <input type="text" name="v-expired" id="v-expired" class="form-control">
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="v-desc" id="v-desc"></textarea>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <button type="submit" class="btn btn-primary float-right"
                                        onclick="add_voucher()">Add</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table class="table table-stripped" id="tbl_vouchers">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/assets/plugins/moment/moment.js') }}"></script>
    <script
        src="{{ asset('assets/admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>
    <script>
        var VOUCHER_ITEMS = [];
        $(document).ready(function() {
            $("#voucher-panel").hide();
            $("#type").change(function(e) {
                if ($("#type option:selected").val() == "voucher") {
                    $("#voucher-panel").show()
                } else {
                    $("#voucher-panel").hide()
                }
            })
            $("#frmVoucher").submit(function(e) {
                e.preventDefault();
            })
            initTable();
            $('#v-desc').summernote();
            $('#v-expired').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false
            });
            let lastProduct = sessionStorage.getItem("lastProduct")
            if (lastProduct) {
                $("#product").val(lastProduct)
                $("#product").trigger("change")
            } else {

                $("#layanan").attr({
                    "data-content": [
                        `Untuk mengaktifkan fitur auto buy mobile legend smile.one, gunakan id layanan berikut`,
                        `86 💎 = 86`,
                        `172 💎 = 172`,
                        `257 💎 = 257`,
                        `706 💎 = 706`,
                        `2195 💎 = 2195`,
                        `3688 💎 = 3688`,
                        `5532 💎 = 5532`,
                        `9288 💎 = 9288`,
                        `Starlight Member = starlight`,
                        `Twilight Pass = twilight`,
                        `Starlight Plus = starlightplus`,
                        `Note: apabila ingin menambahkan banyak layanan. gunakan comma. contoh:`,
                        `86,86`,
                        `hasilnya mendapat diamond 172`
                    ].join("<br>")
                })
            }

            $("#product").change(function() {
                if ($("#product option:selected").val() == `{{ $autoorder['smile'] }}`) {
                    $("#layanan").attr({
                        "data-content": [
                            `Untuk mengaktifkan fitur auto buy mobile legend smile.one, gunakan id layanan berikut`,
                            `86 💎 = 86`,
                            `172 💎 = 172`,
                            `257 💎 = 257`,
                            `706 💎 = 706`,
                            `2195 💎 = 2195`,
                            `3688 💎 = 3688`,
                            `5532 💎 = 5532`,
                            `9288 💎 = 9288`,
                            `Starlight Member = starlight`,
                            `Twilight Pass = twilight`,
                            `Starlight Plus = starlightplus`,
                            `Note: apabila ingin menambahkan banyak layanan. gunakan comma. contoh:`,
                            `86,86`,
                            `hasilnya mendapat diamond 172`
                        ].join("<br>")
                    })
                } else if ($("#product option:selected").val() == `{{ $autoorder['kiosgamer'] }}`) {
                    $("#layanan").attr({
                        "data-content": [
                            `Untuk mengaktifkan fitur auto buy Free Fire Kiosgamer, gunakan id layanan berikut`,
                            `5 💎 = 5`,
                            `20 💎 = 20`,
                            `50 💎 = 50`,
                            `70 💎 = 70`,
                            `140 💎 = 140`,
                            `355 💎 = 355`,
                            `720 💎 = 720`,
                            `2.000 💎 = 2000`,
                            `7.290 💎 = 7290`,
                            `36.500 💎 = 36500`,
                            `73.100 💎 = 73100`,
                            `Member Mingguan = membermingguan`,
                            `Member Bulanan = memberbulanan`,
                            `Note: apabila ingin menambahkan banyak layanan. gunakan comma. contoh:`,
                            `5,5`,
                            `hasilnya mendapat diamond 10`
                        ].join("<br>")
                    })
                } else if ($("#product option:selected").val() == `{{ $autoorder['kiosgamercodm'] }}`) {
                    $("#layanan").attr({
                        "data-content": [
                            `Untuk mengaktifkan fitur auto buy Call Of Duty Mobile Kiosgamer, gunakan id layanan berikut`,
                            `53 CP = 53`,
                            `112 CP = 112`,
                            `278 CP = 278`,
                            `580 CP = 580`,
                            `1268 CP = 1268`,
                            `1901 CP = 1901`,
                            `3300 CP = 3300`,
                            `7128 CP = 7128`,
                            `Note: apabila ingin menambahkan banyak layanan. gunakan comma. contoh:`,
                            `53,53`,
                            `hasilnya mendapat CP 106`
                        ].join("<br>")
                    })
                } else if ($("#product option:selected").val() == `{{ $autoorder['kiosgameraov'] }}`) {
                    $("#layanan").attr({
                        "data-content": [
                            `Untuk mengaktifkan fitur auto buy Garena AOV Kiosgamer, gunakan id layanan berikut`,
                            `40 VC = 40`,
                            `90 VC = 90`,
                            `230 VC = 230`,
                            `470 VC = 470`,
                            `950 VC = 950`,
                            `1430 VC = 1430`,
                            `2390 VC = 2390`,
                            `4800 VC = 4800`,
                            `24050 VC = 24050`,
                            `48200 VC = 48200`,
                            `Note: apabila ingin menambahkan banyak layanan. gunakan comma. contoh:`,
                            `40,40`,
                            `hasilnya mendapat VC 106`
                        ].join("<br>")
                    })
                } else {
                    $("#layanan").attr({
                        "data-content": [`Belum tersedia`].join("<br>")
                    })
                }
            })
        })

        function initTable() {
            $("#tbl_vouchers").bootstrapTable('destroy').bootstrapTable({
                data: VOUCHER_ITEMS,
                columns: [{
                        title: 'Data',
                        field: 'data'
                    },
                    {
                        title: 'Expired at',
                        field: 'expired_at'
                    },
                    {
                        title: 'Description',
                        field: 'description'
                    },
                    {
                        title: 'Action',
                        events: {
                            'click #v-delete': (e, value, row, index) => {
                                VOUCHER_ITEMS = VOUCHER_ITEMS.filter(v => v.id != row.id)
                                initTable()
                            }
                        },
                        formatter: (value, row, index) => {
                            return `<a href="javascript:void(0);" id='v-delete' class="text-danger"><i class="fas fa-trash-alt"></i></a>`
                        }
                    }
                ]
            })
        }

        function add_voucher() {
            let _data = {
                id: Math.floor(Math.random() * 999),
                data: $("#v-data").val(),
                expired_at: $("#v-expired").val(),
                description: $("#v-desc").summernote('code')
            }
            VOUCHER_ITEMS.push(_data)
            initTable()
        }

        function add_data() {
            let data = {
                id: $("#id").val(),
                product_id: $("#product option:selected").val(),
                name: $("#namaData").val(),
                price: $("#price").val(),
                discount: $("#discount").val(),
                type_data: $("#type option:selected").val(),
                layanan: $("#layanan").val()
            };
            if (data.type_data == "voucher") {
                data.voucher_items = JSON.stringify(VOUCHER_ITEMS);
            }

            $.post("{{ route('page.add.data') }}", data, (result) => {
                if (result.success) {
                    Swal.fire("Saved!", "Your product data has been saved.", "success")
                    sessionStorage.setItem('lastProduct', data.product_id)
                    window.location.reload();
                }
            });
        }
    </script>
@endsection
