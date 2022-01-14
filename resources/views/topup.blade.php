@extends('layouts.layout')
@section('title')
    Top up saldo
@endsection

@section('top-scripts')
    <style type="text/css">
        .list-group-item {
            user-select: none;
        }

        .list-group input[type="radio"] {
            display: none;
        }

        .list-group input[type="radio"]+.list-group-item {
            cursor: pointer;
            background-color: #00000091;
            color: #dcddeb;
            border-color: transparent;
            font-size: 12px;
        }

        .list-group input[type="radio"]+.list-group-item:before {
            content: "\2713";
            color: transparent;
            font-weight: bold;
            margin-right: 1em;

        }

        .list-group input[type="radio"]:checked+.list-group-item {
            background-color: #3929a0;
            color: #e1e1e4;

            font-size: 12px;
        }

        .list-group input[type="radio"]:checked+.list-group-item:before {
            color: inherit;
        }

    </style>
@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto mb-5">
                <div class="card bg-dark shadow">
                    <div class="card-header">
                        <span class="card-title h5">Top up saldo</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="h4">Saldo Sekarang : <span class="badge bg-success badge-pill"
                                        id="saldoSekarang"></span></span>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row justify-content-center">
                                    <span class="h3">Pilih saldo</span>
                                    <hr>
                                    @foreach ($priceList as $item)
                                        <div class="list-group col-auto mb-3">
                                            <input type="radio" name="price" id="price-{{ $item }}"
                                                value="{{ $item }}">
                                            <label for="price-{{ $item }}" class="list-group-item">
                                                <span style="font-size:15px"><i class="fas fa-wallet"></i>
                                                    Rp. {{ number_format($item, 0, '.', '.') }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <span class="h3">Atau Input:</span>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" class="form-control" id="inputSaldo"
                                            placeholder="Masukkan nominal saldo">
                                        <div class="invalid-feedback">
                                            Nominal kurang dari 10000.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <span class="h3">Pilih metode pembayaran</span>
                                <hr>

                                <div class="area-list-payment-method">

                                    @foreach ($paygate as $item)
                                        @if ($item->payment == 'bca')
                                            <div class="child-box payment-drawwer shadow">
                                                <div class="header short-payment-support-info-head"
                                                    onclick="openPaymentDrawer(this)">
                                                    <div class="left">
                                                        <b><i class="fas fa-bolt"></i> Transfer bank</b>
                                                    </div>
                                                </div>
                                                <div class="button-action-payment" style="display:none;">
                                                    <ul>

                                                            <li>
                                                                <input type="radio" name="paymentMethod"
                                                                    id="paymentMethod-{{ $item->payment }}"
                                                                    value="{{ $item->payment }}">
                                                                <label for="paymentMethod-{{ $item->payment }}"
                                                                    class="payment-item">
                                                                    <div class="info-top">
                                                                        <img src="{{ $item->image }}">
                                                                        <b id="payment"></b>
                                                                    </div>
                                                                    <div class="info-bottom">
                                                                        Bank Central Asia (BCA)
                                                                    </div>
                                                                </label>
                                                            </li>


                                                    </ul>
                                                </div>
                                                <div class="short-payment-support-info" onclick="openPaymentDrawer(this)">

                                                    <img src="{{ $item->image }}" alt="">
                                                    <a class="open-button-action-payment">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </a>

                                                    <span class="channel-not-available" style="display: none;">Tidak
                                                        tersedia
                                                        pembayaran pada channel
                                                        ini</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach ($paygate as $item)
                                        @if ($item->payment == 'tripay')
                                            @if ($tripay)
                                                @php
                                                    $groups = [];
                                                    foreach ($tripay['data'] as $key => $value) {
                                                        # code...
                                                        $groups = array_unique(array_merge($groups, [$value['group']]));
                                                    }
                                                @endphp
                                            @endif
                                            @foreach ($groups as $group)
                                                <div class="child-box payment-drawwer shadow">
                                                    <div class="header short-payment-support-info-head"
                                                        onclick="openPaymentDrawer(this)">
                                                        <div class="left">
                                                            <b>
                                                                @if ($group == 'Virtual Account')
                                                                    <i class="far fa-credit-card"></i>
                                                                @elseif ($group == "Convenience Store")
                                                                    <i class="fas fa-store"></i>
                                                                @elseif ($group == "E-Wallet")
                                                                    <i class="fas fa-wallet"></i>
                                                                @endif {{ $group }}
                                                            </b>
                                                        </div>
                                                    </div>
                                                    <div class="button-action-payment" style="display:none;">
                                                        <ul>
                                                            @foreach ($tripay['data'] as $item1)
                                                                @if ($item1['group'] == $group)
                                                                    <li>

                                                                        <input type="radio" name="paymentMethod"
                                                                            id="paymentMethod-tripay-{{ $item1['code'] }}"
                                                                            value="tripay-{{ $item1['code'] }}"
                                                                            data-fee="{{ $item1['fee_customer']['flat'] }}"
                                                                            data-fee-percent="{{ $item1['fee_customer']['percent'] }}">
                                                                        <label
                                                                            for="paymentMethod-tripay-{{ $item1['code'] }}"
                                                                            class="payment-item">
                                                                            <div class="info-top">
                                                                                <img src="{{ $item1['icon_url'] }}">
                                                                                <b id="payment"></b>
                                                                            </div>
                                                                            <div class="info-bottom">
                                                                                @if ($item1['code'] == 'QRISC' or $item1['code'] == 'QRIS')
                                                                                    QRIS (Dana, OVO, Gopay, Linkaja,
                                                                                    ShopeePay, BCA Mobile, Maybank, CIMB,
                                                                                    UOB, dan lainnya)
                                                                                @else
                                                                                    {{ $item1['name'] }}
                                                                                @endif
                                                                            </div>
                                                                        </label>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="short-payment-support-info"
                                                        onclick="openPaymentDrawer(this)">

                                                        @foreach ($tripay['data'] as $item1)
                                                            @if ($item1['group'] == $group)
                                                                <img src="{{ $item1['icon_url'] }}" alt=""
                                                                    id="paymentMethodIMG-tripay-{{ $item1['code'] }}">
                                                            @endif
                                                        @endforeach
                                                        <a class="open-button-action-payment">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </a>

                                                        <span class="channel-not-available" style="display: none;">Tidak
                                                            tersedia
                                                            pembayaran pada channel
                                                            ini</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    @endforeach
                                </div>
                                {{-- @foreach ($paygate as $item)
                                    <div class="list-group mb-3 ml-4">
                                        <input type="radio" name="paymentMethod" id="paymentMethod-{{ $item->payment }}"
                                            value="{{ $item->payment }}">
                                        <label for="paymentMethod-{{ $item->payment }}" class="list-group-item">
                                            <span style="font-size:15px"><img src="{{ $item->image }}"
                                                    alt="{{ $item->payment }}" @if ($item->payment == 'qris') style="filter:invert(100%)" @endif
                                                    height="32px"></span>
                                            <span id="payment" class="float-end" style="font-size:15px">0</span>
                                        </label>
                                    </div>
                                @endforeach --}}
                            </div>
                            <div class="col-12 mt-3">
                                <form id="frmTopup">
                                    <input type="hidden" name="payMethod">
                                    <input type="hidden" name="nominal">
                                    <button class="btn btn-success float-end" id="btnTopUp">
                                        Topup Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(() => {
            $.getJSON("{{ route('user') }}", (r) => {
                var userdata = r;

                $("#saldoSekarang").text("Rp." + parseInt(userdata.balance).toLocaleString());
            })
            $("#inputSaldo").on('keyup', function(e) {
                var saldo = $(this).val();
                if (saldo > 0 && saldo < 10000) {
                    $(this).addClass("is-invalid")
                    $("#btnTopUp").attr('disabled', true);
                    $("#btnTopUp").addClass('disabled');
                    $("input[name=payMethod]").val(null)
                } else if (saldo == 0 || saldo == '') {
                    $(this).removeClass("is-invalid")
                    $("#btnTopUp").attr('disabled', false);
                    $("#btnTopUp").removeClass('disabled');
                    $("input[name=payMethod]").val(null)
                    return
                } else {
                    $(this).removeClass("is-invalid")
                    $("#btnTopUp").attr('disabled', false);
                    $("#btnTopUp").removeClass('disabled');
                }
                $("input[name='nominal']").val($(this).val());
                $("input[name='price']").map((idx, el) => {
                    $(el).prop('checked', false);
                });
                let real_price = $(this).val();
                let price = $(this).val();
                let _visibleDenom = [];
                $(".info-top #payment").map(function() {
                    act_price = price
                    let $optPaygate = $(this).parent().parent().siblings();
                    $(this).html(parseInt(price).toLocaleString())
                    // $(this).text(parseInt(price).toLocaleString());
                    $("input[name='nominal']").val(price);
                    let minimumPayment = 0;
                    switch ($optPaygate.val()) {
                        case "tripay-MYBVA":
                        case "tripay-MANDIRIVA":
                        case "tripay-SMSVA":
                        case "tripay-ALFAMART":
                        case "tripay-ALFAMIDI":
                            minimumPayment = 5000;
                            break;
                        case "tripay-PERMATAVA":
                        case "tripay-BNIVA":
                        case "tripay-BRIVA":
                        case "tripay-BCAVA":
                        case "tripay-MUAMALATVA":
                        case "tripay-CIMBVA":
                        case "tripay-SAMPOERNAVA":
                        case "tripay-BRIVAOP":
                        case "tripay-CIMBVAOP":
                        case "tripay-DANAMONOP":
                        case "tripay-BNIVAOP":
                        case "tripay-HANAVAOP":
                        case "tripay-INDOMARET":
                        case "bca":
                            minimumPayment = 10000;
                            break;
                        case "tripay-OVO":
                        case "tripay-QRIS":
                        case "tripay-QRISC":
                        case "tripay-QRISOP":
                        case "tripay-QRISCOP":
                            minimumPayment = 1000;
                            break;
                        default:
                            break;
                    }
                    if (real_price < minimumPayment) {
                        // $optPaygate.attr('disabled', true);
                        $optPaygate.parent().slideUp();
                        if ($optPaygate.is(":checked")) {
                            $optPaygate.prop('checked', false);
                        }
                        $optPaygate.parent().addClass("hideme")
                        let _payCode = $optPaygate.val();
                        console.log();
                        $optPaygate.parent().parent().parent().parent()
                            .find(`#paymentMethodIMG-${_payCode}`).slideUp();
                    } else {
                        // $optPaygate.attr('disabled', false);
                        $optPaygate.parent().slideDown();
                        let _payCode = $optPaygate.val();
                        $optPaygate.parent().parent().parent().parent()
                            .find(`#paymentMethodIMG-${_payCode}`).slideDown();
                        $optPaygate.parent().removeClass("hideme")
                    }
                })
                $(".info-top #payment").parent().parent().parent().parent().map(
                    function(i, e) {
                        let _hiddenDenom = $(e).find('.hideme').length;
                        let _totalDenom = $(e).find('li').length;
                        if (_hiddenDenom == _totalDenom) {
                            $(e).parent().parent().slideUp();
                        } else {
                            $(e).parent().parent().slideDown();
                        }
                    })
            })
            $('input[name="price"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $("#inputSaldo").val("");
                    let real_price = $(this).val();
                    let price = $(this).val();
                    let _visibleDenom = [];
                    $(".info-top #payment").map(function() {
                        act_price = price
                        let $optPaygate = $(this).parent().parent().siblings();
                        $(this).html(parseInt(price).toLocaleString())
                        // $(this).text(parseInt(price).toLocaleString());
                        $("input[name='nominal']").val(price);
                        let minimumPayment = 0;
                        switch ($optPaygate.val()) {
                            case "tripay-MYBVA":
                            case "tripay-MANDIRIVA":
                            case "tripay-SMSVA":
                            case "tripay-ALFAMART":
                            case "tripay-ALFAMIDI":
                                minimumPayment = 5000;
                                break;
                            case "tripay-PERMATAVA":
                            case "tripay-BNIVA":
                            case "tripay-BRIVA":
                            case "tripay-BCAVA":
                            case "tripay-MUAMALATVA":
                            case "tripay-CIMBVA":
                            case "tripay-SAMPOERNAVA":
                            case "tripay-BRIVAOP":
                            case "tripay-CIMBVAOP":
                            case "tripay-DANAMONOP":
                            case "tripay-BNIVAOP":
                            case "tripay-HANAVAOP":
                            case "tripay-INDOMARET":
                            case "bca":
                                minimumPayment = 10000;
                                break;
                            case "tripay-OVO":
                            case "tripay-QRIS":
                            case "tripay-QRISC":
                            case "tripay-QRISOP":
                            case "tripay-QRISCOP":
                                minimumPayment = 1000;
                                break;
                            default:
                                break;
                        }
                        if (real_price < minimumPayment) {
                            // $optPaygate.attr('disabled', true);
                            $optPaygate.parent().slideUp();
                            if ($optPaygate.is(":checked")) {
                                $optPaygate.prop('checked', false);
                            }
                            $optPaygate.parent().addClass("hideme")
                            let _payCode = $optPaygate.val();
                            console.log();
                            $optPaygate.parent().parent().parent().parent()
                                .find(`#paymentMethodIMG-${_payCode}`).slideUp();
                        } else {
                            // $optPaygate.attr('disabled', false);
                            $optPaygate.parent().slideDown();
                            let _payCode = $optPaygate.val();
                            $optPaygate.parent().parent().parent().parent()
                                .find(`#paymentMethodIMG-${_payCode}`).slideDown();
                            $optPaygate.parent().removeClass("hideme")
                        }
                    })
                    $(".info-top #payment").parent().parent().parent().parent().map(
                        function(i, e) {
                            let _hiddenDenom = $(e).find('.hideme').length;
                            let _totalDenom = $(e).find('li').length;
                            if (_hiddenDenom == _totalDenom) {
                                $(e).parent().parent().slideUp();
                            } else {
                                $(e).parent().parent().slideDown();
                            }
                        })
                }
            })
            $('input[name="paymentMethod"]').on('change', function(e) {
                if ($(this).is(':checked')) {

                    $('input[name="payMethod"]').val($(this).val());
                    $('input[name="biayaAdmin"]').val($(this).siblings().children("#bAdmin").val());
                }
            })
            $("#frmTopup").submit((e) => {
                e.preventDefault()
                var price = $('input[name="nominal"]').val();
                if (price == "") {
                    toastr.error("Please select price", "Error");
                    return false;
                }
                var payMethod = $('input[name="payMethod"]').val();
                if (payMethod == "") {
                    toastr.error("Please select payment method", "Error");
                    return false;
                }
                Swal.fire({
                    title: '<b>Konfirmasi</b>',
                    icon: 'info',
                    html: "Silahkan konfirmasi untuk top up saldo berikut:<br>Nominal: Rp." +
                        parseInt(price).toLocaleString() +
                        "<br>Metode pembayaran: " + payMethod +
                        "<br>",
                    showCancelButton: true,
                    confirmButtonText: 'Topup Sekarang!',
                }).then((result1) => {
                    if (result1.isConfirmed) {
                        let data = {
                            payMethod: payMethod,
                            price: price
                        };
                        Swal.fire("Loading");
                        Swal.showLoading()
                        $.post("{{ route('topup.verification') }}",
                            data,
                            (result) => {
                                if (result.success) {
                                    window.location.href = result.message;
                                }
                            }
                        );
                    }
                })
            })
        })

        function openPaymentDrawer(elem) {
            var $this = $(elem);


            $('.payment-drawwer').not(this).each(function() {
                var $parents = $(this);
                $parents.find('.button-action-payment').slideUp(function() {
                    $parents.removeClass('active');
                });

                $parents.find('.short-payment-support-info').find('img').slideDown();
                $parents.find('.short-payment-support-info').find('i').removeClass('fa-chevron-up').addClass(
                    'fa-chevron-down');
            });

            var $parents = $this.parents('.child-box');

            // console.log('IsHidden', $parents.find('.button-action-payment').is(":hidden"));

            if (!$parents.find('.button-action-payment').is(":hidden")) {
                $parents.find('.button-action-payment').slideUp(function() {
                    $parents.removeClass('active');
                });

                $parents.find('.short-payment-support-info').find('img').slideDown();
                $parents.find('.short-payment-support-info').find('.fa-chevron-up').removeClass('fa-chevron-up').addClass(
                    'fa-chevron-down');

            } else {
                $parents.find('.button-action-payment').slideDown(function() {
                    $parents.addClass('active');
                });
                $parents.find('.short-payment-support-info').find('img').slideUp();
                $parents.find('.short-payment-support-info').find('.fa-chevron-down').addClass('fa-chevron-up').removeClass(
                    'fa-chevron-down');

            }

        }
    </script>
@endsection
