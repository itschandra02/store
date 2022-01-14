@extends('admin.layouts.layout')
@section('title')
    Add Voucher
@endsection
@section('top-scripts')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div id="voucher-panel">
                <div class="card shadow">
                    <div class="card-header">
                        <a type="button" href="javascript:void(0)" onclick="history.back();" class="h3">
                            < Back </a>
                    </div>
                    <div class="card-body">
                        <form class="floating-labels m-t-10" id="frmVoucher">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="v-id">ID</label>
                                    <input type="text" name="v-id" id="v-id" readonly class="form-control" @if ($data)
                                    value="{{ $data->id }}"
                                    @endif>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="v-product-id">Product Data</label>
                                    <select name="v-product-id" id="v-product-id" class="form-control p-0">
                                        @foreach ($product_data as $item)
                                            <option value="{{ $item->id }}" @if ($data)
                                                @if ($data->product_data_id == $item->id)
                                                    selected
                                                @endif
                                        @endif >{{ $item->product_name }} -
                                        {{ $item->data_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-7">
                                    <label for="v-data">Data</label>
                                    <input type="text" name="v-data" id="v-data" class="form-control" @if ($data)
                                    value="{{ $data->data }}"
                                    @endif>
                                </div>
                                <div class="form-group col-lg-5">
                                    <label for="v-expired">Expired At</label>
                                    <input type="text" name="v-expired" id="v-expired" class="form-control" @if ($data)
                                    value="{{ $data->expired_at }}"
                                    @endif>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <textarea name="v-desc" id="v-desc">@if ($data){{ $data->description }}@endif</textarea>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary float-right m-1"
                                        onclick="add_voucher()">Add</button>

                                    @if ($data)
                                        <button type="submit" class="btn btn-danger float-right m-1"
                                            onclick="delete_voucher()">Delete</button>
                                    @endif
                                </div>
                            </div>
                        </form>
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
        $(document).ready(function() {
            $("#frmVoucher").submit(function(e) {
                e.preventDefault();
            })
            $('#v-desc').summernote();
            $('#v-expired').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false
            });
        })

        function add_voucher() {
            let _data = {
                id: $("#v-id").val(),
                product_data_id: $("#v-product-id").val(),
                data: $("#v-data").val(),
                expired_at: $("#v-expired").val(),
                description: $("#v-desc").summernote('code')
            }
            $.post("{{ route('data.page.voucher.add') }}", _data, (result) => {
                if (result.success) {
                    Swal.fire("Saved!", "Your product data has been saved.", "success").then(r => {
                        location.href = `{{ route('data.page.vocher.add') }}?id=${result.id}`
                    })
                }
            });
        }

        function delete_voucher() {
            let _data = {
                id: $("#v-id").val()
            };
            $.post(`{{ route('data.page.voucher.delete') }}`, _data, (result) => {
                        if (result.success) {
                            $.post(`{{ route('data.page.voucher.delete') }}`, _data, (result) => {
                                if (result.success) {
                                    window.history.back();
                                }
                            })
                        }
    </script>
@endsection
