@extends('layouts.layout')
@section('title')
    {{ $product->name }}
@endsection
@section('metatag')
    <meta property="og:url" content="{{ route('order_page', $product->slug) }}">
    <meta property="og:title" content="{{ $product->name }} — {{ setting('app_name') }}">
    <meta property="og:description" content="@php
        echo substr(strip_tags($product->description), 0, 160);
    @endphp">
    <meta property="og:image" content="{{ $product->thumbnail }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ Request::getHost() }}">
    <meta property="twitter:url" content="{{ route('order_page', $product->slug) }}">
    <meta name="twitter:title" content="{{ $product->name }} — {{ setting('app_name') }}">
    <meta name="twitter:description" content="@php
        print_r(trim(substr(strip_tags($product->description), 0, 155) . '...'));
    @endphp">
    <meta name="twitter:image" content="{{ $product->thumbnail }}">

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
        @if ($product->instruction)
            <!-- Modal -->
            <div class="modal fade" id="petunjukModal" tabindex="-1" aria-labelledby="petunjukModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title text-white" id="petunjukModalLabel">Petunjuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-dark">
                            <img src="{{ $product->instruction }}" alt="Petunjuk {{ $product->name }}"
                                class="img-fluid">
                        </div>
                        <div class="modal-footer bg-dark">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-4 mt-2 mb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark shadow">
                            <div class="card-body">
                                <img src="{{ URL::to($product->thumbnail) }}" alt=""
                                    class="shadow rounded bg-dark mx-auto mb-2 d-lg-block d-none " width="150">
                                <div class="row">
                                    <div class="col">
                                        <h3>{{ $product->name }}</h3>
                                        <div class="strip-primary"></div><br>
                                        <span class="text-muted mt-3 mb-3">{{ $product->subtitle }}</span>
                                        <img src="{{ URL::to($product->thumbnail) }}" alt=""
                                            class="shadow rounded bg-dark float-start mt-2 me-2 mb-0 d-lg-none d-block"
                                            width="45" />
                                        <?php print_r($product->description); ?>
                                        @if (!$product->use_input)
                                            @if ($product->instruction)
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#petunjukModal">Petunjuk</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mt-3 d-lg-block d-none">
                        <div class="card bg-dark shadow">
                            <div class="card-header">Game Lainnya</div>
                            <div class="card-body">
                                @php
                                    $products = DB::table('products')
                                        ->inRandomOrder()
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @foreach ($products as $item)
                                    @if ($item->active)
                                        <div class="row mb-2">
                                            <div class="col">
                                                <div class="card flex-row flex-wrap bg-dark">
                                                    <div class="card-header border-0">
                                                        <a href="{{ route('order_page', $item->slug) }}"
                                                            class="stretched-link">
                                                            <img src="{{ $item->thumbnail }}" height="50px"
                                                                alt="{{ $item->slug }}-icon">
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <b>{{ $item->name }}</b><br>
                                                        {{ $item->subtitle }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mt-2 mb-2">
                @if ($product->use_input)
                    <div class="row">
                        <div class="col">
                            <div class="card bg-dark shadow">
                                <div class="card-header">
                                    <h5 class="card-title">Lengkapi Data</h5>
                                </div>
                                <div class="card-body">
                                    <div id="userData">
                                        <div class="row row-cols row-cols-md">
                                            @foreach ($formData as $item)
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <label for="{{ $item->name }}">{{ $item->value }}</label>
                                                        <input class="form-control"
                                                            placeholder="{{ $item->placeholder }}"
                                                            type="{{ $item->type }}" name="{{ $item->name }}"
                                                            id="{{ $item->name }}" required>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if ($product->instruction)
                                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#petunjukModal">Petunjuk</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-dark shadow">
                            <div class="card-header">
                                <h5 class="card-title">Pilih Nominal</h5>
                            </div>
                            <div class="card-body">
                                <div id="tempatNominal">
                                    <div class="row row-cols-2">
                                        @foreach ($product_data as $item)
                                            @if ($item->active)
                                                <div class="col-lg-4 mt-3">
                                                    <div class="list-group">
                                                        <input type="radio" name="inlineRadioOptions"
                                                            id="nominal-{{ $item->id }}" value="{{ $item->id }}"
                                                            data-type="{{ $item->type_data }}">
                                                        <label for="nominal-{{ $item->id }}" class="list-group-item">
                                                            @if ($item->type_data == 'diamond')
                                                                <i class="fas fa-gem"></i>
                                                            @else
                                                                <i class="fas fa-ticket-alt"></i>
                                                            @endif
                                                            {{ $item->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-dark shadow">
                            <div class="card-header">
                                <h5 class="card-title">Pilih Metode Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="area-list-payment-method">

                                    @foreach ($paygate as $item)
                                        @if ($item->payment == 'bca')
                                            <div class="child-box payment-drawwer shadow">
                                                <div class="header short-payment-support-info-head"
                                                    onclick="openPaymentDrawer(this)">
                                                    <div class="left">
                                                        {{-- <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/68badd326c92daa50df9b43bd0b2c81c.png"
                                                            alt="Metode Pembayaran"> --}}
                                                        <b><i class="fas fa-bolt"></i> Saldo</b>
                                                    </div>
                                                </div>
                                                <div class="button-action-payment" style="display:none;">
                                                    <ul>
                                                        @if ($item->status)
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
                                                        @endif

                                                        {{-- @if (Session::has('loggedIn')) --}}
                                                        <li>
                                                            <input type="radio" name="paymentMethod"
                                                                id="paymentMethod-saldo" value="saldo"
                                                                @if (!Session::has('loggedIn')) disabled @endif>
                                                            <label for="paymentMethod-saldo" class="payment-item">
                                                                <div class="info-top">
                                                                    <div>
                                                                        <i class="fas fa-wallet"></i>
                                                                        {{ setting('app_name') }} E-Wallet
                                                                    </div>

                                                                    <b id="payment"></b>
                                                                </div>
                                                                <div class="info-bottom" id="info-bottomWallet">
                                                                    Login untuk
                                                                    menggunakan {{ setting('app_name') }} E-Wallet
                                                                </div>
                                                            </label>
                                                        </li>
                                                        {{-- @endif --}}

                                                    </ul>
                                                </div>
                                                <div class="short-payment-support-info" onclick="openPaymentDrawer(this)">

                                                    <i class="fas fa-wallet me-2" id="paymentMethodIMG-saldo"></i>
                                                    @if ($item->status)
                                                        <img src="{{ $item->image }}" alt="" id="paymentMethodIMG-bca">

                                                    @endif
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
                                        @if ($item->payment == 'tripay' && $tripay && $item->status)
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
                                                            {{-- <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/68badd326c92daa50df9b43bd0b2c81c.png"
                                                                alt="Metode Pembayaran"> --}}
                                                            <b>
                                                                @if ($group == 'E-Wallet')
                                                                    <i class="fas fa-wallet"></i>
                                                                @elseif ($group == "Virtual Account")
                                                                    <i class="far fa-credit-card"></i>
                                                                @elseif ($group == "Convenience Store")
                                                                    <i class="fas fa-store"></i>
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
                                                                                @if ($item1['code'] == 'QRISC')
                                                                                    <img
                                                                                        src="{{ asset('assets/img/logos/Gopay.png') }}">
                                                                                    <img
                                                                                        src="{{ asset('assets/img/logos/Dana.png') }}">
                                                                                    <img
                                                                                        src="{{ asset('assets/img/logos/Shopeepay.png') }}">
                                                                                    <img
                                                                                        src="{{ asset('assets/img/logos/OVO.png') }}">
                                                                                    <img
                                                                                        src="{{ asset('assets/img/logos/Linkaja.png') }}">
                                                                                @else
                                                                                    <img src="{{ $item1['icon_url'] }}">
                                                                                @endif
                                                                                <b id="payment"></b>
                                                                            </div>
                                                                            <div class="info-bottom">
                                                                                @if ($item1['code'] == 'QRISC')
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
                                        @if ($item->payment == 'hitpay')
                                            <div class="child-box payment-drawwer shadow">
                                                <div class="header short-payment-support-info-head"
                                                    onclick="openPaymentDrawer(this)">
                                                    <div class="left">
                                                        <b>
                                                            <i class="fas fa-wallet"></i> Payment
                                                        </b>
                                                    </div>
                                                </div>
                                                <div class="button-action-payment" style="display:none;">
                                                    <ul>
                                                        @foreach ($hitpay['payment_methods'] as $item1)
                                                            <li>
                                                                <input type="radio" name="paymentMethod"
                                                                    id="paymentMethod-hitpay-{{ $item1['code'] }}"
                                                                    value="hitpay-{{ $item1['code'] }}">
                                                                <label for="paymentMethod-hitpay-{{ $item1['code'] }}"
                                                                    class="payment-item">
                                                                    <div class="info-top">
                                                                        <div>
                                                                            @foreach ($item1['images'] as $image)
                                                                                <img src="{{ $image }}">
                                                                            @endforeach
                                                                        </div>
                                                                        <b id="payment"></b>
                                                                    </div>
                                                                    <div class="info-bottom">
                                                                        {{ $item1['name'] }}
                                                                    </div>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="short-payment-support-info" onclick="openPaymentDrawer(this)">
                                                    @foreach ($hitpay['payment_methods'] as $item1)
                                                        @foreach ($item1['images'] as $image)
                                                            <img src="{{ $image }}" alt=""
                                                                id="paymentMethodIMG-hitpay-{{ $image }}">
                                                        @endforeach
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
                                        @endif
                                        @if ($item->payment == 'toyyibpay')
                                        <div class="child-box payment-drawwer shadow">
                                            <div class="header short-payment-support-info-head"
                                                onclick="openPaymentDrawer(this)">
                                                <div class="left">
                                                    <b>
                                                        <i class="fas fa-wallet"></i> Payment
                                                    </b>
                                                </div>
                                            </div>
                                            <div class="button-action-payment" style="display:none;">
                                                <ul>
                                                    @foreach ($toyyibpay as $item1)
                                                        <li>
                                                            <input type="radio" name="paymentMethod"
                                                                id="paymentMethod-hitpay-{{ $item1['id'] }}"
                                                                value="hitpay-{{ $item1['id'] }}">
                                                            <label for="paymentMethod-hitpay-{{ $item1['id'] }}"
                                                                class="payment-item">
                                                                <div class="info-top">
                                                                    <div>
                                                                        {{-- @foreach ($item1['images'] as $image)
                                                                            <img src="{{ $image }}">
                                                                        @endforeach --}}
                                                                    </div>
                                                                    <b id="payment"></b>
                                                                </div>
                                                                <div class="info-bottom">
                                                                    {{ $item1['bank'] }}
                                                                </div>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="short-payment-support-info" onclick="openPaymentDrawer(this)">
                                                {{-- @foreach ($hitpay['payment_methods'] as $item1)
                                                    @foreach ($item1['images'] as $image)
                                                        <img src="{{ $image }}" alt=""
                                                            id="paymentMethodIMG-hitpay-{{ $image }}">
                                                    @endforeach
                                                @endforeach --}}
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
                                </div>

                                {{-- <div class="accordion accordion-flush" id="accordion-paymentGateway">
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
                                                @foreach ($groups as $group)

                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="flush-heading{{ $loop->index }}">
                                                            <button class="accordion-button collapsed btn-dark"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapse{{ $loop->index }}"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapse{{ $loop->index }}">
                                                                {{ $group }}
                                                            </button>
                                                        </h2>
                                                        <div class="accordion-collapse collapse"
                                                            id="flush-collapse{{ $loop->index }}"
                                                            aria-labelledby="flush-heading{{ $loop->index }}"
                                                            data-bs-parent="#accordion-paymentGateway">
                                                            <div class="accordion-body bg-dark">
                                                                @foreach ($tripay['data'] as $item1)
                                                                    @if ($item1['group'] == $group)
                                                                        <div class="list-group mb-3">
                                                                            <input type="radio" name="paymentMethod"
                                                                                id="paymentMethod-tripay-{{ $item1['code'] }}"
                                                                                value="tripay-{{ $item1['code'] }}"
                                                                                data-fee="{{ $item1['fee_customer']['flat'] }}"
                                                                                data-fee-percent="{{ $item1['fee_customer']['percent'] }}">
                                                                            <label
                                                                                for="paymentMethod-tripay-{{ $item1['code'] }}"
                                                                                class="list-group-item">
                                                                                <span style="font-size:15px">
                                                                                    @if ($item1['code'] == 'QRISC')
                                                                                        <img src="https://images-ext-1.discordapp.net/external/rnPe2cTIaaJ4T65ZOyVVL7yaQlOweGZDXM8cO0cOQuU/https/i.ibb.co/CQdrC97/003-AC0-A6-2-F9-E-45-E3-96-C1-7-FE3-FFD4-ECEE.png%2522"
                                                                                            alt="{{ $item1['code'] }}"
                                                                                            class="img-fluid">
                                                                                    @else
                                                                                        <img src="{{ $item1['icon_url'] }}"
                                                                                            alt="{{ $item1['code'] }}"
                                                                                            height="32px">
                                                                                    @endif
                                                                                </span>
                                                                                <span id="payment" class="float-end"
                                                                                    style="font-size:15px">0</span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <div class="list-group mb-3">
                                                <input type="radio" name="paymentMethod"
                                                    id="paymentMethod-{{ $item->payment }}"
                                                    value="{{ $item->payment }}">
                                                <label for="paymentMethod-{{ $item->payment }}" class="list-group-item">
                                                    <span style="font-size:15px"><img src="{{ $item->image }}"
                                                            alt="{{ $item->payment }}" @if ($item->payment == 'qris') style="filter:invert(100%)" @endif
                                                            height="32px"></span>
                                                    <span id="payment" class="float-end"
                                                        style="font-size:15px">0</span>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div> --}}

                                @if (Session::has('loggedIn'))
                                    <div class="col-lg-12">
                                        <div class="g-recaptcha" data-sitekey="{{ setting('captcha_sitekey') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if (!Session::has('loggedIn'))

                    <div class="row mt-3">
                        <div class="col">
                            <div class="card bg-dark shadow">
                                <div class="card-header">
                                    <h5 class="card-title">Nomor Whatsapp</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="denom">Nomor Whatsapp</label>
                                        <input class="form-control" placeholder="Nomor Whatsapp [628xxxxx]" type="number"
                                            name="denom" id="denom" required>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="{{ setting('captcha_sitekey') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 clearfix">
                        @if (Session::has('loggedIn'))
                            <input type="hidden" id="username" name="username" value="{{ Session::get('username') }}">
                            <input type="hidden" name="product_name" id="product_name" value="{{ $product->name }}">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <button class="btn btn-primary float-end" onclick="beli();">
                                <i class="fas fa-cart-arrow-down"></i>
                                Order Now
                            </button>
                        @else
                            <input type="hidden" id="username" name="username" value="">
                            <input type="hidden" name="product_name" id="product_name" value="{{ $product->name }}">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <div class="float-end">
                                {{-- <button class="btn btn-success" onclick="location.href='{{ route('login') }}'">
                                    <div class="fas fa-sign-in-alt"></div>Login
                                </button> --}}
                                <button class="btn btn-primary" onclick="beli();">
                                    <i class="fas fa-cart-arrow-down"></i>
                                    Order Now
                                </button>
                                <br>
                                {{-- <a href="{{ URL::to('login') }}"
                                    class="text-muted text-decoration-none fst-italic fw-light" id="btnLogin">
                                    Login Untuk Beli
                                </a> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var product_data = @json($product_data);
        var templateNotify =
            `<div class="alert alert-{0} alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                <span>
                    <b> {1} <br> </b> {2}</span>
                <a href="{3}" target="{4}" data-notify="url"></a>
            </div>
            `;
        var act_price;
        var act_type;
        // var templateNotify =
        //     `<div class="alert alert-{0} alert-with-icon">
    //                                 <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
    //                                     <i class="tim-icons icon-simple-remove"></i>
    //                                 </button>
    //                                 <span data-notify="icon" class="tim-icons icon-bell-55"></span>
    //                                 <span>
    //                                     <b> {1} <br> </b> {2}</span>
    //                                 <div class="progress" data-notify="progressbar">
    //                                     <div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    //                                 </div>
    //                                 <a href="{3}" target="{4}" data-notify="url"></a>
    //                             </div>`;
        $(document).ready(() => {
            setTimeout(() => {
                try {
                    $('#info-bottomWallet').html(`Saldo E-Wallet Rp.(${window.userdata.balance})`)
                } catch (error) {
                    // console.error(error);
                }
            }, 1000);

            $('#denom').on('input', function() {
                if (this.value.startsWith('08')) {
                    this.value = "628";
                }
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
            $("input[type=radio]#paymentMethod-qris").parent().hide()
            changePayments();
            $("input[type='radio'][name='paymentMethod']").change(function() {
                if ($(this).is(":checked")) {

                    $("li.active").removeClass("active")
                    $(this).parent('li').addClass("active")
                }
            })
        })

        function changePayments() {
            $("input[type='radio'][name='inlineRadioOptions']").click(function() {
                if ($(this).is(":checked")) {
                    product_data.forEach(i => {
                        if (i.id == parseFloat($(this).val())) {
                            act_type = $(this).data('type');
                            if ($(this).data('type') == "voucher") {
                                let $data_id = $(this).val();
                                $.get(`{{ route('order.voucher') }}?data_id=${$data_id}`, res => {
                                    if (res.success) {
                                        $(".info-top #payment").map(function(i, e) {
                                            let $ipt = $(e).parent().parent().parent().find(
                                                'input[type=radio]')
                                            $ipt.attr('disabled',
                                                false)
                                        })
                                    } else {
                                        $(".info-top #payment").map(function(i, e) {
                                            let $ipt = $(e).parent().parent().parent().find(
                                                'input[type=radio]')
                                            $ipt.attr('disabled',
                                                true)
                                        })
                                    }
                                    if (res.stock > 0) {
                                        toastr.info(`Stock ${res.stock} buah`, 'Info Stock');
                                    } else {
                                        toastr.error(`Stock Kosong`, 'Info Stock');
                                    }
                                })
                            }
                            let _visibleDenom = [];
                            $(".info-top #payment").map(function() {
                                let real_price = i.price;
                                let getSes = @json($user);
                                let $optPaygate = $(this).parent().parent().siblings(
                                    "input[type='radio']");
                                if (getSes) {
                                    if (i.role_prices != null) {
                                        let rolePrice = JSON.parse(i.role_prices);
                                        console.log(rolePrice);
                                        rolePrice = rolePrice.filter(v => v.name == getSes.status)[
                                            0];
                                        real_price = rolePrice ? rolePrice.price :
                                            i.price;
                                        if (real_price != i.price) {
                                            $(this).html(
                                                `${parseFloat(real_price).toLocaleString()} (<strike class="text-danger">${parseFloat(i.price).toLocaleString()}</strike>)`
                                            )
                                            $optPaygate.parent().find("#discPercent").remove();
                                            $optPaygate.parent().append(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="discPercent">${(((real_price - i.price) / i
                                            .price) * 100).toFixed(1)}%</span>`)
                                        } else {
                                            $optPaygate.parent().find("#discPercent").remove();
                                            $(this).html(parseFloat(i.price).toLocaleString())
                                        }
                                    } else {
                                        $optPaygate.parent().find("#discPercent").remove();
                                        $(this).html(parseFloat(i.price).toLocaleString())
                                    }
                                } else {
                                    $(this).html(parseFloat(i.price).toLocaleString())
                                }
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
                                    $optPaygate.parent().parent().parent().parent()
                                        .find(`#paymentMethodIMG-${_payCode}`).fadeOut();
                                } else {
                                    // $optPaygate.attr('disabled', false);
                                    $optPaygate.parent().slideDown();
                                    let _payCode = $optPaygate.val();
                                    $optPaygate.parent().parent().parent().parent()
                                        .find(`#paymentMethodIMG-${_payCode}`).fadeIn();
                                    $optPaygate.parent().removeClass("hideme")
                                }
                                act_price = real_price
                                // console.log($optPaygate);
                                if ($optPaygate.data("fee")) {
                                    // act_price = i.price + parseInt($optPaygate.data("fee")) +
                                    //     parseFloat($optPaygate.data("fee-percent"))
                                    // act_price = i.price + (i.price * (parseFloat($optPaygate.data(
                                    //     "fee-percent")) / 100)) + $optPaygate.data("fee")
                                    act_price = real_price;
                                    // console.log($optPaygate);
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
                    });
                }
            })
        }

        function Notifikasi(title, message, type) {
            $.notify({
                message: message,
                title: title
            }, {
                offset: {
                    x: 5,
                    y: 100
                },
                placement: {
                    from: 'top',
                    align: 'right'
                },
                showProgressbar: true,
                newest_on_top: true,
                z_index: 50000,
                type: type,
                template: templateNotify
            });
        }

        function beli() {
            let userData = [];
            var bisaSubmit = true;
            $("#userData input").map(function() {
                userData.push({
                    name: $(this)[0].name,
                    value: $(this).val()
                });
            })
            console.log(userData)
            var nameData = $('input[name="inlineRadioOptions"]:checked').parent().text().trim();
            var idData = $('input[type="radio"][name="inlineRadioOptions"]:checked').val();
            var paymentMethod = $('input[type="radio"][name="paymentMethod"]:checked').val();
            userData.forEach((k, a) => {
                if (!k.value) {
                    // Notifikasi("Warning", `Data ${k.name} kosong, silahkan di input`, "danger");
                    toastr.error(`Data ${k.name} kosong, silahkan di input`, "Warning")
                    bisaSubmit = false;
                }
            });
            if (nameData == "") {
                // Notifikasi("Warning", `Nominal belum dipilih`, "warning");
                toastr.warning(`Nominal belum dipilih`, "Warning")
                bisaSubmit = false;
            }
            if (paymentMethod == null) {
                // Notifikasi("Warning", "Metode pembayaran belum di pilih", "primary")
                toastr.error(`Metode pembayaran belum di pilih`, "Warning")
                bisaSubmit = false;
            }
            // if ($("#g-recaptcha-response").val() == "") {
            // // Notifikasi("Danger", "Captcha salah", primary);
            //    toastr.error(`Captcha salah`, "Warning")
            //    bisaSubmit = false;
            // }
            if (bisaSubmit) {
                let user = $("#username").val()
                var _form = {
                    dataId: userData,
                    nominal: {
                        name: nameData,
                        id: idData,
                        product_id: $("#product_id").val().trim(),
                        product_name: $("#product_name").val().trim()
                    },
                    price: act_price,
                    paymentMethod: paymentMethod,
                    user: user,
                    number: $("#denom").val(),
                    captcha_response: $("#g-recaptcha-response").val()
                }
                $.ajax({
                    url: `{{ route('order.check') }}`,
                    data: _form,
                    method: 'POST',
                    beforeSend: () => {
                        Swal.fire({
                            title: 'Tunggu sebentar',
                            allowOutsideClick: false
                        })
                        Swal.showLoading();
                    },
                    success: function(result) {
                        if (result.status) {

                            txt = [
                                _form.nominal.product_name + (act_type == 'diamond' ?
                                    `<br>Nickname : ${result.message}<br>` + _form.dataId.map(
                                        k => `${k.name}: ${k.value}`).join(
                                        '<br>') + "" : ""),
                                `Data : ` + _form.nominal.name,
                                `Harga : ${parseFloat(_form.price).toLocaleString()}`,
                                `Metode Pembayaran : ${_form.paymentMethod.replace("tripay-","")}`,
                                ``,
                                `Note: Harga ini belum termasuk biaya admin!`
                            ];
                            Swal.fire({
                                title: 'Data Pesanan',
                                html: txt.join("<br>"),
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Beli Sekarang'
                            }).then((result) => {
                                console.log(result)
                                if (result.isConfirmed) {
                                    // order(_form)
                                    // Verif without otp
                                    verif(_form)
                                }
                            });
                        } else {
                            Swal.fire({
                                title: result.message,
                                icon: 'error'
                            })
                        }
                    }
                })
            }
        }

        // function order(_form) {
        //     _form.type = "otp"

        //     $.ajax({
        //         url: `{{ route('order.add') }}`,
        //         data: _form,
        //         method: 'POST',
        //         beforeSend: () => {
        //             Swal.fire({
        //                 title: 'Tunggu sebentar',
        //                 allowOutsideClick: false
        //             })
        //             Swal.showLoading();
        //         },
        //         success: (result) => {
        //             if (result.success) {
        //                 Swal.fire({
        //                     title: 'Input OTP',
        //                     text: result.message,
        //                     input: 'text',
        //                     inputAttributes: {
        //                         autocapitalize: 'off'
        //                     },
        //                     confirmButtonText: 'Login',
        //                     showCancelButton: true,
        //                     inputPlaceholder: 'Input OTP From Whatsapp',
        //                     allowOutsideClick: () => !Swal.isLoading(),
        //                     preConfirm: (otp) => verif(otp, _form)
        //                 })
        //             }
        //         }
        //     })
        // }
        // function verif(otp, _form) {
        function verif(_form) {
            _form.type = "verification"
            //_form.otp = otp

            $.ajax({
                url: `{{ route('order.add') }}`,
                data: _form,
                method: 'POST',
                beforeSend: () => {
                    Swal.fire({
                        title: 'Tunggu sebentar',
                        allowOutsideClick: false
                    })
                    Swal.showLoading();
                },
                success: (result) => {
                    if (result.success) {
                        return window.location.href = result.message;
                    } else {
                        return Swal.fire({
                            title: 'Error',
                            text: result.message,
                            icon: 'error'
                        });
                    }
                }
            })
        }

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
