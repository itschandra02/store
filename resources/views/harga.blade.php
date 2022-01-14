@extends('layouts.layout')
@section('title')
    Daftar Harga
@endsection
@section('body')
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-9 mx-auto">
                <div class="card bg-dark shadow">
                    <div class="card-header">
                        <span class="h4">Daftar Harga</span>
                    </div>
                    <div class="card-body">
                        <div id="toolbar">
                            <div class="row float-end">
                                <div class="col">
                                    <select name="selGame" id="selGame" class="form-select" onchange="selectGame(this)">
                                        <option value="all">All</option>
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-dark" id="tblHarga"></table>
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
            initTable()
        })

        function selectGame(el) {
            initTable($(el).find(":selected").val())
        }

        function initTable(val) {
            if (val == "all") val = null
            let v = "";
            if (val != null) v = "?id=" + val;
            $("#tblHarga").bootstrapTable('destroy').bootstrapTable({
                url: "{{ route('harga.list') }}" + v,
                pagination: true,
                search: true,
                toolbar: '#toolbar',
                showRefresh: true,
                columns: [{
                        title: 'Name',
                        field: 'name'
                    },
                    {
                        title: 'Product',
                        field: 'product_name'
                    },
                    {
                        title: 'Price',
                        field: 'price',
                        formatter: (value, row, index) => "Rp. " + parseInt(value).toLocaleString()
                    },
                    {
                        title: 'Updated at',
                        field: 'updated_at'
                    }
                ]
            })
        }
    </script>
@endsection
