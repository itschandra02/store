@extends('layouts.layout')
@section('title')
    Invoice Detail - {{ request()->id }}
@endsection
@section('top-scripts')

    <style>
        @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700");
        @import url("https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css");

        .cus-accordion {
            transform: translateZ(0);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            /* background: #fff; */
        }

        .cus-accordion>.accordion-toggle {
            position: absolute;
            opacity: 0;
            display: none;
        }

        .cus-accordion>label {
            position: relative;
            display: block;
            height: 50px;
            line-height: 50px;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 700;
            border-top: 1px solid #ddd;
            /* background: #fff; */
            cursor: pointer;
        }

        .cus-accordion>label:after {
            content: '\f078';
            position: absolute;
            top: 0px;
            right: 20px;
            font-family: fontawesome;
            transform: rotate(90deg);
            transition: .3s transform;
        }

        .cus-accordion>section {
            height: 0;
            transition: .3s all;
            overflow: hidden;
        }

        .cus-accordion>.accordion-toggle:checked~label:after {
            transform: rotate(0deg);
        }

        .cus-accordion>.accordion-toggle:checked~section {
            height: 200px;
        }

        .cus-accordion>section p {
            margin: 15px 0;
            padding: 0 20px;
            font-size: 12px;
            line-height: 1.5;
        }

    </style>
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <button class="btn btn-warning btn-sm mb-3" onclick="print_invoice()"><i class="fas fa-print"></i>
                    Print</button>
                <div class="card bg-dark shadow" id="invoice">
                    <div class="card-header">
                        <span class="h4">
                            Invoice Number <strong>#{{ $invoice->invoice_number }}</strong>
                        </span>
                        <span class="float-end">
                            Status: <span
                                class="badge text-uppercase bg-@php
                                switch ($invoice->status) {
                                    case 'PENDING':
                                        # code...
                                        echo 'warning text-dark';
                                        break;
                                    case 'PROGRESS':
                                        # code...
                                        echo 'warning text-dark';
                                        break;
                                    case 'PAID':
                                        echo 'primary';
                                        break;
                                    case 'DONE':
                                        echo 'success';
                                        break;
                                    case 'EXPIRED':
                                        echo 'danger';
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            @endphp">{{ $invoice->status }}</span>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="h6"><b>Tanggal dibuat</b>: {{ $invoice->created_at }}</span>
                            </div>
                            <div class="col-12">
                                <span class="h6 text-danger"><b>Tanggal expired</b>: {{ $invoice->expired_at }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <blockquote class="blockquote border bg-gradient rounded shadow p-4">
                                    <b>Harap Dibayar Sebelum 3 Jam!</b><br>
                                    Segera lakukan pembayaran sesuai "Total Yang Harus Dibayar" tekan tombol Copy Nominal yg
                                    berwarna hijau
                                </blockquote>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-clear table-dark">
                                        <thead>
                                            <tr>

                                                <td style="text-align: center; vertical-align: middle;">Nama Layanan</td>
                                                <td style="text-align: center; vertical-align: middle;">ID</td>
                                                <td style="text-align: center; vertical-align: middle;">Metode Pembayaran
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{ $invoice->product_name }} ({{ $invoice->product_data_name }})
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    @if ($invoice->user_input != '')
                                                        @foreach (json_decode($invoice->user_input) as $item)
                                                            {{ $item->value }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{ strtoupper(str_replace('hitpay-', '', $invoice->payment_method)) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            @if ($voucher)
                                <div class="col-lg-7">
                                    <div class="card bg-dark shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto mx-auto">
                                                    <style>
                                                        .coupon {
                                                            padding: 9px 32px;
                                                            border: 4px dashed var(--bs-primary);
                                                        }

                                                        kbd.coupon {
                                                            background-color: #2125293f
                                                        }

                                                    </style>
                                                    <h5><kbd data-toggle="tooltip" class="coupon text-white mt-2"
                                                            data-placement="bottom" id="paycode"
                                                            title="Click to copy">{{ $voucher->data }}</kbd>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    @php
                                                        echo $voucher->description;
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php
                                $stats = ['expired', 'done', 'paid', 'progress'];
                            @endphp
                            @if ($invoice->payment_method != 'saldo' && !in_array(strtolower($invoice->status), $stats))

                                <div class="col-lg-7 d-print-none">
                                    {{-- @if ($invoice->payment_method != 'saldo' || ($invoice->status != 'EXPIRED' && $invoice->status != 'DONE' && $invoice->status != 'PAID' && $invoice->status != 'PROGRESS')) --}}

                                    <div class="card bg-dark shadow">
                                        <div class="card-body">
                                            @if ($invoice->payment_method == 'qris')
                                                <div class="row">
                                                    <div class="col-auto mx-auto">
                                                        <div height="100%" width="50"
                                                            style="padding:5px;border-radius:2px;display:flex;flex-direction:column;align-items:center;background:white">
                                                            @php
                                                                echo $qr;
                                                            @endphp
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col">
                                                        <div class="list-group">
                                                            <button type="button"
                                                                class="list-group-item list-group-item-action bg-dark text-white"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collHowTo" aria-expanded="false"
                                                                aria-controls="collHowTo">Bagaimana cara
                                                                membayar dengan QRIS?</button>
                                                        </div>
                                                        <div class="collapse mt-1" id="collHowTo">
                                                            <ul class="list-group  list-group-numbered bg-dark">
                                                                <li class="list-group-item bg-dark text-white">Scan/unduh
                                                                    kode
                                                                    QR
                                                                    menggunakan
                                                                    dompet digital kamu</li>
                                                                <li class="list-group-item bg-dark text-white">Pastikan nama
                                                                    dan
                                                                    nominal
                                                                    sudah
                                                                    benar</li>
                                                                <li class="list-group-item bg-dark text-white">Pembayaranmu
                                                                    selesai</li>
                                                                <li class="list-group-item bg-dark text-white">Tunggu sistem
                                                                    mendeteksi
                                                                    pembayaran 5-10 menit</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($invoice->payment_method=="bca")
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <img src="{{ $paygate->image }}" alt="{{ $paygate->payment }}"
                                                            height="32px">
                                                    </div>
                                                    <div class="col-12">
                                                        <b>Silahkan Transfer ke rekening berikut :</b>
                                                    </div>
                                                    <div class="col-12 mb-2 mt-2">
                                                        <span class="h5"><b>{{ $paygate->norek }} A/N
                                                                {{ $paygate->name }}</b></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <b>Harap Dibayar Sebelum 3 Jam!</b><br>
                                                        Segera lakukan pembayaran sesuai "Total Yang Harus Dibayar" tekan
                                                        tombol Copy Nominal yg berwarna hijau
                                                    </div>
                                                </div>
                                            @elseif (str_starts_with($invoice->payment_method,"tripay-"))
                                                @if ($tripay)
                                                    @if (in_array($tripay['data']['payment_method'], ['QRIS', 'QRISC', 'QRISD']))
                                                        <a href="{{ $tripay['data']['qr_url'] }}" download>
                                                            <img src="{{ $tripay['data']['qr_url'] }}" alt="qrcode"
                                                                class="img-fluid" width="200px">
                                                        </a>
                                                    @elseif ($tripay['data']['payment_method'] == 'OVO')
                                                        <a href="{{ $tripay['data']['pay_url'] }}"
                                                            class="btn btn-success"><i class="fas fa-shopping-basket"></i>
                                                            Klik Disini untuk Bayar</a>
                                                    @else
                                                        <h5>Code: <kbd data-toggle="tooltip" data-placement="bottom"
                                                                id="paycode"
                                                                title="Click to copy">{{ $tripay['data']['pay_code'] }}</kbd>
                                                        </h5>
                                                    @endif
                                                    <h4>Instruksi:</h4>
                                                    @foreach ($tripay['data']['instructions'] as $item)
                                                        <div class="cus-accordion">
                                                            <input type="radio" class="accordion-toggle" name="toggle"
                                                                id="toggle{{ $loop->index + 1 }}">
                                                            <label for="toggle{{ $loop->index + 1 }}">
                                                                {{ $item['title'] }}
                                                            </label>
                                                            <section>
                                                                <p>
                                                                    @foreach ($item['steps'] as $item1)
                                                                        {{ $loop->index + 1 }}.
                                                                        {!! $item1 !!}<br>
                                                                    @endforeach
                                                                </p>
                                                            </section>
                                                        </div>
                                                    @endforeach
                                                    {{-- <div class="accordion accordion-flush bg-dark" id="instruksi">
                                                        @foreach ($tripay['data']['instructions'] as $item)
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    <button
                                                                        class="accordion-button @if (!$loop->index == 0) collapsed @endif"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#instruksi{{ $loop->index + 1 }}"
                                                                        @if (!$loop->index == 0) aria-expanded="true" @else aria-expanded="false" @endif
                                                                        aria-controls="instruksi{{ $loop->index + 1 }}">
                                                                        {{ $item['title'] }}
                                                                    </button>
                                                                </h2>
                                                                <div id="instruksi{{ $loop->index + 1 }}"
                                                                    class="accordion-collapse collapse @if ($loop->index == 0) show @endif"
                                                                    aria-labelledby="headingOne"
                                                                    data-bs-parent="#instruksi">
                                                                    <div class="accordion-body bg-dark">
                                                                        @foreach ($item['steps'] as $item1)
                                                                            {{ $loop->index + 1 }}.
                                                                            {!! $item1 !!}<br>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div> --}}

                                                    {{-- @foreach ($payment_gateway['data']['instructions'] as $item)
                                                        <h3 class="card-title">{{ $item['title'] }}</h3>
                                                        <blockquote class="blockquote blockquote-info">
                                                            @foreach ($item['steps'] as $item1)
                                                                {{ $loop->index + 1 }}. {!! $item1 !!}<br>
                                                            @endforeach
                                                        </blockquote>
                                                    @endforeach --}}
                                                @endif
                                            @elseif (str_starts_with($invoice->payment_method,"hitpay-"))
                                                @if ($hitpay)
                                                    <a href="{{ $hitpay['url'] }}" class="btn btn-success">
                                                        <i class="fas fa-cart-plus"></i> Please click here to pay
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-5">
                                <table class="table table-clear table-dark">
                                    <tbody>
                                        <tr>
                                            <td class="left">
                                                Harga
                                            </td>
                                            <td class="right text-right">
                                                {{ $hitpay ? $hitpay['currency'] : 'Rp.' }}
                                                {{ number_format($invoice->price, 2, '.', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                Biaya Admin
                                            </td>
                                            <td class="right text-right">
                                                {{ $hitpay ? $hitpay['currency'] : 'Rp.' }}
                                                {{ number_format($invoice->fee, 2, '.', '.') }} </td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong>Total Yang Harus Di Bayar</strong>
                                            </td>
                                            <td class="right text-right">
                                                <strong style="color:lime;">
                                                    {{ $hitpay ? $hitpay['currency'] : 'Rp.' }}
                                                    <span type="button" title="Click to copy" id="totPriceBayar"
                                                        onclick="copyToClipboard2(this)">{{ number_format($invoice->price + $invoice->fee, 2, '.', '.') }}</span>
                                                    <i class="fas fa-copy" type="button"
                                                        onclick="copyToClipboard2($('#totPriceBayar')[0])"></i>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="card bg-dark mt-3 shadow">
                    <div class="card-body">
                        <div class="row mrg-top-5">
                            <div class="col-md-6 ">
                                <div class="pdd-vertical-20">
                                    <span>

                                        <strong>1. Jangan salah nominal</strong><br>Transfer sesuai angka "Total yang harus dibayar"
                                        tekan Tombol Copy Nominal yg berwarna hijau<br><br>
                                        <strong>2. Transfer dengan Biaya Admin</strong><br>Transfer Sesuai Dengan
                                        Nominal Total Yang Harus Di Bayar Agar Pembayaran Bisa Diverifikasi Otomatis
                                        Oleh Sistem.<br><br>


                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="pdd-vertical-20">
                                    <span>
                                        <strong>3. Setelah melakukan pembayaran</strong><br>
                                        Tunggu 5-10 Menit Sistem Akan Melakukan
                                        Verifikasi Pembayaran Anda Secara Otomatis Dan Anda Akan Mendapatkan
                                        Notifkasi Whatsapp Pembayaran Berhasil.<br><br>
                                        <strong>4. Proses Pengisian Otomatis</strong><br>
                                        Catat &amp; Simpan No.Pesanan Anda Untuk Melakukan Cek Status Order, Detail
                                        Status
                                        Pesanan, Atau Tunggu Sampai Mendapatkan Notifikasi Whatsapp Pesanan Anda
                                        Berhasil Di Kirim Di.<br><br>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@section('scripts')

    @if ($invoice->status != 'DONE')
        @if (str_starts_with($invoice->product_data_name, 'TOPUP'))
            @if ($invoice->status != 'PAID')
                <script>
                    $(document).ready(function() {
                        setInterval(() => {
                            console.log("checking")
                            $.get("{{ route('api.invoice.get') }}?invno={{ $invoice->invoice_number }}", (
                                result) => {
                                if (result.status != 'PENDING') {
                                    location.reload();
                                }
                            })
                        }, 2000);
                    })
                </script>
            @endif
        @else
            <script>
                $(document).ready(function() {
                    setInterval(() => {
                        console.log("checking")
                        $.get("{{ route('api.invoice.get') }}?invno={{ $invoice->invoice_number }}", (
                            result) => {
                            if (result.status != 'PENDING') {
                                location.reload();
                            }
                        })
                    }, 2000);
                })
            </script>
        @endif
    @endif
    <script>
        $(document).ready(function() {
            $("#paycode").tooltip();
            $("#paycode").click(function() {
                copyToClipboard($(this).text(), $(this));
            })
            $("#paycode").css('cursor', 'pointer');
        })

        function print_invoice() {
            var printContents = document.getElementById('invoice').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.onafterprint = function() {
                location.reload()
            }
        }

        function copyToClipboard2(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.info("Copied to clipboard");
        }


        function copyToClipboard(text, el) {
            var copyTest = document.queryCommandSupported('copy');
            var elOriginalText = el.attr('data-bs-original-title');

            if (copyTest === true) {
                var copyTextArea = document.createElement("textarea");
                copyTextArea.value = text;
                document.body.appendChild(copyTextArea);
                copyTextArea.select();
                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'Copied!' : 'Whoops, not copied!';
                    el.attr('data-bs-original-title', msg).tooltip('show');
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
                document.body.removeChild(copyTextArea);
                el.attr('data-bs-original-title', elOriginalText);
                console.log(elOriginalText);
            } else {
                // Fallback if browser doesn't support .execCommand('copy')
                window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
            }
        }
    </script>
@endsection
