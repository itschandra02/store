@extends('admin.layouts.layout')
@section('title')
    Smile Auto order
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    Smile Auto order
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
                    {{-- <div class="row">
                        <div class="col-lg-4">
                            @php
                                $type_accs = json_decode(
                                    json_encode([
                                        [
                                            'name' => 'vk',
                                            'text' => 'VK',
                                        ],
                                        [
                                            'name' => 'facebook',
                                            'text' => 'Facebook',
                                        ],
                                        [
                                            'name' => 'google',
                                            'text' => 'Google',
                                        ],
                                    ]),
                                    1,
                                );
                            @endphp
                            <label for="type_acc">Type Account</label>
                            <select name="type_acc" id="type_acc" class="form-control">
                                @foreach ($type_accs as $item)
                                    <option value="{{ $item['name'] }}" @if ($data)
                                        @if ($data->type == $item['name'])
                                            selected @endif
                                @endif>{{ $item['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
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
                        <div class="col-lg-12 mt-3">
                            <label for="user_smile">PHPSessid</label>
                            <input type="text" name="user_smile" id="user_smile" class="form-control"
                                @if ($data) value="{{ $data->cookie }}" @endif>
                        </div>
                        {{-- <div class="col-lg-6 mt-3">
                            <label for="pass_smile">password</label>
                            <input type="password" name="pass_smile" id="pass_smile" class="form-control"
                                @if ($data) value="{{ $data->password }}" @endif>
                        </div> --}}
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input type="hidden" name="account" value="smile">
                            <button class="btn btn-primary float-right" onclick="saveSmileAcc()">Submit</button>
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
                                    <dt>Account ID</dt>
                                    <dd id="acc_id"></dd>
                                    <dt>Balance</dt>
                                    <dd id="balance"></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header">Price list</div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                            src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTjPnnmm63QCK6bfWJ4kM621vBQQJaqv0riH45nyJcwb41XI2vglsNtl3biLxSPgy_VgM2e1QCZ7caD/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if ($data)
        @if ($data->is_active)
            <script>
                $(document).ready(() => {
                    $("#panel-balance").hide();
                    $.get("{{ route('auto.smile.check') }}", (result) => {
                        if (result.success) {
                            $("#acc_id").text(result.data.nickname)
                            $("#balance").text(result.data.saldo)
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

        function saveSmileAcc() {
            let data = {
                // type: $("#type_acc option:selected").val(),
                // username: $("#user_smile").val(),
                cookie: $("#user_smile").val(),
                account: $("input[name='account']").val(),
                is_active: $("#is_active").is(":checked") ? 1 : 0,
                product_id: $("#product_id option:selected").val()
            }
            console.log(data);
            $.post("{{ route('auto.smile.save') }}", data, (result) => {
                if (result.success) {
                    Swal.fire('Saved!', "Your smile coin account has been saved.", "success");
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
