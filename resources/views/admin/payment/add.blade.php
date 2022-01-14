@extends('admin.layouts.layout')
@section('title')
    @if ($data) Edit @else Add @endif Payment Gateway
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-lg-10">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="payment">Payment</label>
                            @php
                                $payments = json_decode(
                                    json_encode([
                                        [
                                            'key' => 'bca',
                                            'value' => 'BCA',
                                        ],
                                        [
                                            'key' => 'tripay',
                                            'value' => 'Tripay',
                                        ],
                                        [
                                            'key' => 'hitpay',
                                            'value' => 'Hitpay',
                                        ],
                                        [
                                            'key' => 'toyyibpay',
                                            'value' => 'Toyyibpay',
                                        ]
                                    ]),
                                    1,
                                );
                            @endphp
                            <select name="payment" id="payment" class="form-control">
                                @foreach ($payments as $item)
                                    <option value="{{ $item['key'] }}" @if ($data)
                                        @if ($data->payment == $item['key'])
                                            selected @endif
                                @endif>{{ $item['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="bca">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label for="username-bca">Username IBank</label>
                                <input type="text" name="username-bca" id="username-bca" class="form-control"
                                    autocomplete="off" placeholder="Username IBank" @if ($data) value="{{ $data->username }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="password-bca">Password IBank</label>
                                <input type="password" name="password-bca" id="password-bca" class="form-control"
                                    autocomplete="off" placeholder="Password IBank" @if ($data) value="{{ $data->password }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="nama-bca">Nama Rekening</label>
                                <input type="text" name="nama-bca" id="nama-bca" class="form-control" autocomplete="off"
                                    placeholder="Nama Rekening Bank" @if ($data) value="{{ $data->name }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="norek">Nomor Rekening</label>
                                <input type="text" name="norek" id="norek" class="form-control" autocomplete="off"
                                    placeholder="Nomor Rekening Bank" @if ($data) value="{{ $data->norek }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div id="tripay">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label for="apikey-tripay">ApiKey</label>
                                <input type="text" name="apikey-tripay" id="apikey-tripay" class="form-control"
                                    placeholder="Apikey" @if ($data) value="{{ $data->username }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="private-tripay">PrivateKey</label>
                                <input type="text" name="private-tripay" id="private-tripay" class="form-control"
                                    placeholder="Private Key" @if ($data) value="{{ $data->token }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="merchant-tripay">Merchant Code</label>
                                <input type="text" name="merchant-tripay" id="merchant-tripay" placeholder="Merchant code"
                                    @if ($data) value="{{ $data->norek }}" @endif class="form-control">
                            </div>
                        </div>
                    </div>
                    <div id="hitpay">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label for="apikey-hitpay">Api-Key</label>
                                <input type="text" name="apikey-hitpay" id="apikey-hitpay" class="form-control"
                                    placeholder="Api-Key" @if ($data) value="{{ $data->token }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="salt-hitpay">Salt</label>
                                <input type="text" name="salt-hitpay" id="salt-hitpay" class="form-control"
                                    placeholder="Salt" @if ($data) value="{{ $data->password }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div id="toyyibpay">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label for="secretKey-toyyibpay">Secret Key</label>
                                <input type="text" name="secretKey-toyyibpay" id="secretKey-toyyibpay" class="form-control"
                                    placeholder="Secret Key" @if ($data) value="{{ $data->token }}" @endif>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="qris">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label for="nomor-qris">Nomor Bukukas</label>
                                <input type="text" name="nomor-qris" id="nomor-qris" class="form-control"
                                    placeholder="62895xxx" @if ($data) value="{{ $data->username }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="otpvia">Sent OTP via</label>
                                <select name="otpvia" id="otpvia" class="form-control">
                                    <option value="WHATSAPP">Whatsapp</option>
                                    <option value="SMS">SMS</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="otp">OTP</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="otp" id="otp" class="form-control" autocomplete="off"
                                            disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-info btn-sm" onclick="sendOTP()" id="btnOtp">
                                            Send OTP
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="token">Token</label>
                                <input type="text" name="token" id="token" readonly class="form-control"
                                    @if ($data) value="{{ $data->token }}" @endif>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="bisnisid">Bisnis ID</label>
                                <select name="bisnisid" id="bisnisid" class="form-control" @if (!$data) disabled @endif>
                                    @if ($data && $data->payment == 'qris' && $profile)
                                        @foreach ($profile['data']['currentUser']['businesses'] as $item)
                                            <option value="{{ $item['id'] }}" @if ($item['id'] == $data->password)
                                                selected
                                        @endif>{{ $item['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label for="bankid">Bank ID</label>
                                <input type="text" name="bankid" id="bankid" class="form-control" @if ($data) value="{{ $data->norek }}" @endif
                                    readonly>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <button class="btn btn-primary float-right" onclick="submitForm()">Submit</button>
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
            $("#tripay").hide();
            $("#qris").hide();
            $("#bca").hide();
            $("#hitpay").hide();
            $("#toyyibpay").hide();
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.get('id')) {
                var $option = $("select#payment").find('option:selected').val();
                var $option_ = $("select#payment").find('option:not(:selected)');
                $(`#${$option}`).show();
                for (let index = 0; index < $option_.length; index++) {
                    const element = $($option_[index]);
                    $(`#${element.val()}`).hide();
                }
            }


            $("select#payment").change(function() {
                var $option = $(this).find('option:selected').val();
                var $option_ = $(this).find('option:not(:selected)');
                $(`#${$option}`).show();
                for (let index = 0; index < $option_.length; index++) {
                    const element = $($option_[index]);
                    $(`#${element.val()}`).hide();
                }
            })

            $('#nomor-qris').on('input', function() {
                if (this.value.startsWith('08')) {
                    this.value = "628";
                }
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
        })

        function submitForm() {
            let payment = $("select#payment option:selected").val();
            let data = {
                payment: payment,
            }
            if (payment == 'qris') {
                data.type = 'submitqris'
                data.number = $("#nomor-qris").val()
                data.token = $("#token").val()
                data.bisnisid = $("#bisnisid option:selected").val()
            } else if (payment == 'bca') {
                data.username = $("#username-bca").val();
                data.password = $("#password-bca").val();
                data.name = $("#nama-bca").val();
                data.norek = $("#norek").val();
            } else if (payment == 'tripay') {
                data.username = $("#apikey-tripay").val();
                data.token = $("#private-tripay").val();
                data.norek = $("#merchant-tripay").val();
            } else if (payment == 'hitpay') {
                data.token = $("#apikey-hitpay").val();
                data.password = $("#salt-hitpay").val();
            }else if (payment == 'toyyibpay') {
                data.token = $("#secretKey-toyyibpay").val();
            }
            $.post(`{{ route('payment.event') }}`, data, (result) => {
                console.log(result)
                if (result.success) {
                    Swal.fire('Success', `Berhasil memperbaharui ${payment.toUpperCase()}!`, 'success')
                }
            })
        }

        function sendOTP() {
            let number = $("#nomor-qris").val()
            if (!number) {
                $("#nomor-qris").focus();
                return
            }
            let data = {
                payment: 'qris',
                type: 'getOtp',
                number: number,
                otpvia: $("#otpvia").val()
            }
            console.log($("#btnOtp").text().trim())
            if ($("#btnOtp").text().trim() == "Send OTP") {
                $.post(`{{ route('payment.event') }}`, data, (result) => {
                    if (result.success) {
                        $("#btnOtp").text("OK")
                        $("#otp").prop('disabled', false);
                    }
                })
            } else if ($("#btnOtp").text().trim() == "OK") {
                if (!$("#otp").val()) {
                    return $("#otp").focus()
                }
                data.type = "verifOtp";
                data.otp = $("#otp").val();
                $.post(`{{ route('payment.event') }}`, data, (result) => {
                    if (result.success) {
                        console.log(result)
                        $("#otp").prop('disabled', true);
                        $("#btnOtp").prop('disabled', true);
                        $("#token").val(result.token);
                        $("#bisnisid").html('');
                        result.data.forEach(element => {
                            let opt = $("<option>")
                                .text(element.name)
                                .val(element.id);
                            $("#bisnisid").append(opt);
                        });
                        $("#bisnisid").prop('disabled', false);
                        return
                    } else {
                        $("#btnOtp").text("Send OTP");
                        Swal.fire("Failed", result.message, 'error');
                        return
                    }
                })
            }
        }
    </script>
@endsection
