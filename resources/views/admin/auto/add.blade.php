@extends('admin.layouts.layout')
@section('title')
    Add New Auto Order
@endsection
@section('top-scripts')
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="auto_account" class="form-label">Select Auto Order Provider</label><br>
                                <select name="auto_account" id="auto_account" class="selectpicker  m-b-20 m-r-10"
                                    data-style="btn-primary">
                                    <option value="~">-Select Provider-</option>
                                    <option value="smile">Mobile Legends</option>
                                    <option value="kiosgamer">Free Fire</option>
                                    <option value="kiosgamercodm">Call Of Duty Mobile</option>
                                    <option value="kiosgameraov">Arena Of Valor</option>
                                    <option value="kiosgamerft">Fantasy Town</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="product_id" class="form-label">Select Product</label><br>
                                <select name="product_id" id="product_id" class="selectpicker  m-b-20 m-r-10"
                                    data-style="btn-primary">
                                    <option value="~">-Select Product-</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-none pnl" id="panel_cookie">
                            <div class="form-group">
                                <label for="cookie" class="form-label">Cookie (PHP SESSID)</label>
                                <input type="text" class="form-control" id="cookie" name="cookie" placeholder="Cookie"
                                    @if ($data)
                                @if ($data->cookie)
                                    value="{{ $data->cookie }}"

                                @endif
                                @endif
                                >
                            </div>
                        </div>
                        <div class="col-12 d-none pnl" id="panel_username">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" @if ($data)
                                @if ($data->username)
                                    value="{{ $data->username }}"
                                @endif

                                @endif>
                            </div>
                        </div>
                        <div class="col-12 d-none pnl" id="panel_password">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Password" @if ($data)
                                @if ($data->password)
                                    value="{{ $data->password }}"
                                @endif

                                @endif>
                            </div>
                        </div>
                        <div class="col-12 d-none pnl" id="panel_otp">
                            <div class="form-group">
                                <label for="otp" class="form-label">OTP Key</label>
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="OTP Key"
                                    @if ($data)
                                @if ($data->otp_key)
                                    value="{{ $data->otp_key }}"

                                @endif

                                @endif>
                            </div>
                        </div>
                        <div class="col-12 d-none pnl" id="panel_session_key">
                            <div class="form-group">
                                <label for="session_key" class="form-label">Session Key</label>
                                <input type="text" class="form-control" id="session_key" name="session_key"
                                    placeholder="Session Key" @if ($data)
                                @if ($data->token)
                                    value="{{ $data->token }}"
                                @endif

                                @endif>
                            </div>
                        </div>
                        <div class="col-12 d-none" id="panel_buttons">
                            <div class="float-right">
                                <button class="btn btn-warning btn-sm " id="btnCheck">Check</button>
                                <button class="btn btn-success btn-sm " id="btnSubmit">Submit</button>
                            </div>
                        </div>
                        <input type="hidden" name="balance" id="balance">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script>
        let _DATA = @json($data);
        $(document).ready(function() {
            $('#auto_account').change(function() {
                var auto_account = $(this).val();
                $('.pnl').addClass('d-none');
                switch (auto_account) {
                    case "smile":
                        $('#panel_cookie').removeClass('d-none');
                        break;
                    case "kiosgamer":
                    case "kiosgamercodm":
                    case "kiosgameraov":
                    case "kiosgamerft":
                        $('#panel_username').removeClass('d-none');
                        $('#panel_password').removeClass('d-none');
                        $("#panel_otp").removeClass('d-none');
                        $("#panel_session_key").removeClass('d-none');
                        break;
                    default:
                        break;
                }
                $("#panel_buttons").removeClass('d-none');
            });
            if (_DATA) {
                $('#auto_account').val(_DATA.account);
                $("#auto_account").selectpicker("render");
                $('#product_id').val(_DATA.product_id);
                console.log(_DATA);
                $("#product_id").selectpicker("render");
                $('#cookie').val(_DATA.cookie);
                $('#username').val(_DATA.username);
                $('#password').val(_DATA.password);
                $('#otp').val(_DATA.otp_key);
                $('#session_key').val(_DATA.token);
                $('#balance').val(_DATA.balance);
                $('#panel_buttons').removeClass('d-none');

                var auto_account = $('#auto_account').val();
                $('.pnl').addClass('d-none');
                switch (auto_account) {
                    case "smile":
                        $('#panel_cookie').removeClass('d-none');
                        break;
                    case "kiosgamer":
                    case "kiosgamercodm":
                    case "kiosgameraov":
                    case "kiosgamerft":
                        $('#panel_username').removeClass('d-none');
                        $('#panel_password').removeClass('d-none');
                        $("#panel_otp").removeClass('d-none');
                        $("#panel_session_key").removeClass('d-none');
                        break;
                    default:
                        break;
                }
            }
            $("#btnCheck").click(function() {
                var auto_account = $('#auto_account').val();
                var cookie = $('#cookie').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var otp = $('#otp').val();
                var session_key = $('#session_key').val();
                var product_id = $('#product_id').val();
                switch (auto_account) {
                    case 'smile':
                        if (cookie == '') {
                            toastr.error('Cookie is required');
                            return false;
                        }
                        break;
                    case "kiosgamer":
                    case "kiosgamercodm":
                    case "kiosgameraov":
                    case "kiosgamerft":
                        if (username == '') {
                            toastr.error('Username is required');
                            return false;
                        }
                        if (password == '') {
                            toastr.error('Password is required');
                            return false;
                        }
                        if (otp == '') {
                            toastr.error('OTP is required');
                            return false;
                        }
                        break;
                    default:
                        break;
                }
                var data = {
                    type: 'check',
                    auto_account: auto_account,
                    cookie: cookie,
                    username: username,
                    password: password,
                    otp: otp,
                    session_key: session_key,
                    product_id: product_id
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('auto-order.event') }}",
                    type: "POST",
                    data: data,
                    beforeSend: function() {
                        $('#btnCheck').html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.success == true) {
                            switch (data.auto_account) {
                                case 'smile':
                                    Swal.fire({
                                        title: 'Success',
                                        html: [
                                            '<p><b>Cookie</b>: ' + data.cookie +
                                            '</p>',
                                            '<p><b>Account Name</b>: ' + response
                                            .nickname + '</p>',
                                            '<p><b>Account Balance</b>: ' + response
                                            .saldo + '</p>',
                                        ].join(''),
                                        customClass: {
                                            htmlContainer: 'text-left'
                                        },
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    $("#balance").val(parseInt(response.saldo.replace(",",
                                        "")));
                                    break;
                                case 'kiosgamer':
                                case 'kiosgamercodm':
                                case 'kiosgameraov':
                                case 'kiosgamerft':
                                    Swal.fire({
                                        title: 'Success',
                                        html: [
                                            '<p><b>Username</b>: ' + data.username +
                                            '</p>',
                                            '<p><b>Session Key</b>: ' + data
                                            .session_key +
                                            '</p>',
                                            '<p><b>Account Balance</b>: ' + response
                                            .shell_balance + '</p>',
                                        ].join(''),
                                        customClass: {
                                            htmlContainer: 'text-left'
                                        },
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    console.log(response);
                                    $("#balance").val(response.shell_balance);
                                    $("#session_key").val(data.session_key);
                                    break;
                                default:
                                    break;
                            }
                        }
                        $("#btnCheck").html('Check');
                    }
                });
            });
            $("#btnSubmit").click(function() {
                var auto_account = $('#auto_account').val();
                var cookie = $('#cookie').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var otp = $('#otp').val();
                var session_key = $('#session_key').val();
                var product_id = $('#product_id').val();
                var balance = $('#balance').val();
                var data = {
                    type: 'submit',
                    auto_account: auto_account,
                    cookie: cookie,
                    username: username,
                    password: password,
                    otp: otp,
                    session_key: session_key,
                    product_id: product_id,
                    balance: balance
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('auto-order.event') }}",
                    type: "POST",
                    data: data,
                    beforeSend: function() {
                        $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Success',
                                customClass: {
                                    htmlContainer: 'text-left'
                                },
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        }
                        $("#btnSubmit").html('Submit');
                    }
                });
            })
        });
    </script>
@endsection
