@extends('admin.layouts.layout')
@section('title')
    Kiosgamer Codm Auto order
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    Kiosgamer Codm Auto order
                    @if ($data)
                        <strong>
                            @if ($data->is_active)
                                <span class="text-info">[ACTIVE]</span>
                            @else
                                <span class="text-danger">[NOT ACTIVE]</span>
                            @endif
                        </strong>
                        <input type="checkbox" id="is_active" @if ($data->is_active) checked @endif data-on-color="primary"
                            data-off-color="danger">
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label for="product_id">Product</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}" @if ($data)
                                            @if ($data->product_id == $item->id)
                                                selected
                                            @endif
                                    @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" @if ($data)
                                value="{{ $data->username }}"
                                @endif>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" @if ($data)
                                value="{{ $data->password }}"
                                @endif>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="otp_key">OTP Key</label>
                                <input type="text" name="otp_key" id="otp_key" class="form-control" @if ($data)
                                value="{{ $data->otp_key }}"
                                @endif>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="session_key">Session Key</label>
                                <input type="text" name="session_key" id="session_key" class="form-control" @if ($data)
                                value="{{ $data->token }}"
                                @endif>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="account" value="kiosgamercodm">
                            <button class="btn btn-primary float-right" onclick="saveKiosAccount()">Save!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($data)
            @if ($data->is_active)
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header">Status</div>
                        <div class="card-body">
                            <div id="loading" class="spinner-grow" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div id="panel-balance">
                                <dl>
                                    <dt>User ID</dt>
                                    <dd id="uid"></dd>
                                    <dt>Username</dt>
                                    <dd id="garena_username"></dd>
                                    <dt>Balance</dt>
                                    <dd id="balance"></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
@section('scripts')
    @if ($data)
        @if ($data->is_active)
            <script>
                $(document).ready(() => {
                    $("#panel-balance").hide();
                    $.get("{{ route('auto.kiosgamercodm.check') }}", (result) => {
                        if (result.success) {
                            $("#uid").text(result.data.uid)
                            $("#garena_username").text(result.data.username)
                            $("#balance").text(result.data.shell_balance)
                            $("#loading").hide()
                            $("#panel-balance").show();
                            console.log(result)
                        }
                    })
                })
            </script>
        @endif
    @endif
    <script>
        $(document).ready(() => {
            $("input[type='checkbox']").bootstrapSwitch();
        })

        function saveKiosAccount() {
            let data = {
                account: $(`input[name='account']`).val(),
                username: $(`#username`).val(),
                password: $("#password").val(),
                otp_key: $("#otp_key").val(),
                session_key: $("#session_key").val(),
                is_active: $("#is_active").is(":checked") ? 1 : 0,
                product_id: $("#product_id option:selected").val()
            }
            $.post("{{ route('auto.kiosgamercodm.save') }}", data, (result) => {
                if (result.success) {
                    Swal.fire('Saved!', "Your kiosgamer codm account has been saved.", "success");
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
