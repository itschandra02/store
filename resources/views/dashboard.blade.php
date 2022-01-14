@extends('layouts.layout')
@section('title')
    Dashboard
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-lg-4 mx-auto mt-5">
                <div class="card shadow bg-dark">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('settings') }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-user-edit"></i> Edit Profile</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="{{ $user->avatar }}" class="avatar avatar-128 rounded-circle text-white p-2">
                            </div>
                        </div>
                        <hr>
                        <dl>
                            <dt>Nama</dt>
                            <dd class="text-end">{{ $user->name }}</dd>
                            <dt>Username</dt>
                            <dd class="text-end">{{ $user->username }}</dd>
                            <dt>Email</dt>
                            <dd class="text-end">{{ $user->email }}</dd>
                            <dt>Nomor</dt>
                            @if ($user->number == '')
                                <dd class="text-end"><a href="{{ route('settings') }}"
                                        class="btn btn-primary btn-sm">Tambah
                                        Nomor</a></dd>
                            @else
                                <dd class="text-end">{{ $user->number }}</dd>
                            @endif
                            <dt>Saldo</dt>
                            <dd class="text-end"><span class="badge bg-primary" id="balance" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Klik untuk Topup" type="button"
                                    onclick="window.location.href = '{{ route('topup') }}';"></span> <span
                                    class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Klik untuk Topup" type="button"
                                    onclick="window.location.href = '{{ route('topup') }}';">+</span></dd>
                            <dt>Total Pesanan</dt>
                            <dd class="text-end">{{ $totalTransactions->tot_trans }}</dd>
                            <dt>Total Pengeluaran</dt>
                            <dd class="text-end"><span
                                    class="badge bg-success">Rp.{{ number_format($totalTransactions->tot_price, 0, ',', '.') }}</span>
                            </dd>
                            <dt>Status Akun</dt>
                            <dd class="text-end">{{ strtoupper($user->status) }}</dd>
                        </dl>
                        {{-- <div class="row">
                            <div class="col-4"><strong>Name</strong></div>
                            <div class="col">{{ $user->name }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"><strong>Username</strong></div>
                            <div class="col">{{ $user->username }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"><strong>Email</strong></div>
                            <div class="col">{{ $user->email }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"><strong>Number</strong></div>
                            @if ($user->number == '')
                                <div class="col"><a href="{{ route('settings') }}"
                                        class="btn btn-primary btn-sm">Tambah
                                        Nomor</a></div>
                            @else
                                <div class="col">{{ $user->number }}</div>
                            @endif
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"><strong>Balance</strong></div>
                            <div class="col"><span class="badge bg-primary" id="balance"></span></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"><strong>Total Pesanan</strong></div>
                            <div class="col">{{ count($totalTransactions) }}</div>
                        </div>

                        @if ($expireSeller)
                            <div class="row mt-2">
                                <div class="col-4"><b>Batas waktu reseller</b></div>
                                <div class="col">
                                    <div class="badge bg-success" id="batasWaktu"></div>
                                </div>
                            </div>
                        @endif
                        <div class="row mt-2">
                            <div class="col-4"><strong>Status</strong></div>
                            <div class="col">{{ $user->status }}</div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 mx-auto mt-5">
                <div class="card shadow rounded bg-dark">
                    <div class="card-header"><span class="h4">History</span></div>
                    <div class="card-body text-center">
                        @if (count($invoices) > 0)
                            @foreach ($invoices as $invoice)
                                <div class="card bg-dark mt-3">
                                    <div class="card-body">
                                        <div class="row text-white">
                                            <div class="col-lg-1">
                                                @if (str_starts_with($invoice->product_data_name, 'TOPUP'))
                                                    <i class="fas fa-wallet fa-2x"></i>
                                                @else
                                                    <i class="fas fa-cart-plus fa-2x"></i>
                                                @endif
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="h5">
                                                            {{ $invoice->product_name }}
                                                            <small>({{ $invoice->product_data_name }})</small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <i>
                                                            <small>
                                                                <a class="stretched-link text-decoration-none text-white"
                                                                    href="{{ route('invoice', ['id' => $invoice->invoice_number]) }}">{{ $invoice->invoice_number }}
                                                                    ({{ $invoice->payment_method }})</a>
                                                            </small>
                                                        </i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                @if (str_starts_with($invoice->product_data_name, 'TOPUP'))
                                                    <span class="badge bg-success">+{{ $invoice->price }}</span>
                                                @else
                                                    <span class="badge bg-info">-{{ $invoice->price }}</span>
                                                @endif
                                                <br>
                                                @if ($invoice->status == 'PAID')
                                                    <span class="badge bg-info">{{ $invoice->status }}</span>
                                                @elseif ($invoice->status == 'EXPIRED')
                                                    <span class="badge bg-danger">{{ $invoice->status }}</span>
                                                @elseif ($invoice->status == 'DONE')
                                                    <span class="badge bg-primary">{{ $invoice->status }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $invoice->status }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <span class="h4">There is nothing here</span>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(() => {
            $('#balance').html('Rp.' + parseInt('{{ $user->balance }}').toLocaleString());
        })
    </script>
    @if ($expireSeller)
        <script src="{{ asset('assets/js/jquery.countdown.js') }}" defer></script>
    @endif
    <script>
        $(document).ready(function(e) {
            var t = `Reseller: Keuntungan menjadi reseller adalah akan mendapatkan diskon tambahan sebesar 2% setiap pembelian product,
apabila ingin menjadi Reseller anda harus menyimpan saldo sebanyak 500rb di akun anda, apabila saldo kurang dari 500rb akan ada batas waktu selama 7 hari sebelum isi ulang,
apabila selama 7 hari masih kurang dari 500rb status menjadi member`
            $("#benefit").popover({
                trigger: 'hover',
                title: 'Benefit',
                content: t
            })
            @if ($expireSeller)
                $("#batasWaktu").countdown('{{ $expireSeller->expire_seller_at }}',function(ev){
                $(this).html(ev.strftime('%D hari %H:%M:%S'));
                })
            @endif
        })
    </script>
@endsection
