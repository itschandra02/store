@extends('admin.layouts.layout')
@section('title')
    List Vouchers
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div id="toolbar">
                        <select name="v-product-id" id="v-product-id" class="form-control p-0"
                            onchange="selectProduct(this)">
                            <option value="">
                                Select product item
                            </option>
                            @foreach ($product_data as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->product_name }} - {{ $item->data_name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('data.page.vocher.add') }}" class="btn btn-primary mt-2">Add +</a>
                    </div>

                    <table id="tblList" class="table"></table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            initTable()
        })

        function selectProduct(el) {
            initTable($(el).find(":selected").val())
        }

        function initTable(val) {

            if (val == "all") val = null
            let v = "";
            if (val != null) v = "?id=" + val;
            $("#tblList").bootstrapTable('destroy').bootstrapTable({
                url: "{{ route('data.list.voucher') }}" + v,
                toolbar: "#toolbar",
                search: true,
                showRefresh: true,
                columns: [{
                        title: 'Product Name',
                        field: 'product_name'
                    },
                    {
                        title: 'Data Name',
                        field: 'data_name'
                    },
                    {
                        title: 'Status',
                        field: 'status'
                    },
                    {
                        title: 'Used',
                        field: 'used',
                        formatter: (value, row, index) => {
                            if (value == 0) {
                                return `<span class="badge badge-sm badge-success">NO</span>`
                            } else {
                                return `<span class="badge badge-sm badge-danger">YES</span>`
                            }
                        }
                    },
                    {
                        title: 'Expired At',
                        field: 'expired_at'
                    },
                    {
                        title: 'Purchased',
                        field: 'purchased'
                    },
                    {
                        title: 'Action',
                        formatter: (value, row, index) => {
                            let btn =
                                `<a href='{{ route('data.page.vocher.add') }}?id=${row.id}' class='badge badge-info'>Edit</a>`
                            return btn
                        }
                    }
                ]
            })
        }
    </script>
@endsection
