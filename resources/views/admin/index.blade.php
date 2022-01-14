@extends('admin.layouts.layout')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-info"><i class="mdi mdi-briefcase-check"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 id="totOrder" class="m-b-0">0</h3>
                            <h5 class="text-muted m-b-0">Total Orders</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 id="pendingOrder" class="m-b-0">2690</h3>
                            <h5 class="text-muted m-b-0">Pending orders</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 id="expOrder" class="m-b-0">20 march</h3>
                            <h5 class="text-muted m-b-0">Expired orders</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-settings"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0" id="successOrders">6540</h3>
                            <h5 class="text-muted m-b-0">Success orders</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <div class="row">
        <div class="col-lg-6  col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pending paid orders</h4>

                    <table class="table table-stripped" id="tblPendingPaid">
                    </table>

                </div>
            </div>
        @endsection
        @section('scripts')
            <script>
                $(document).ready(() => {
                    fetch(`{{ route('api.invoice.list') }}`, {
                            Accept: 'application/json'
                        })
                        .then(async (resp) => {
                            let data = [];
                            data = await resp.json()
                            let totalOrders = data.filter((val, num) => val.product_data_id != 151)
                            $("#totOrder").text(totalOrders.length);
                            $("#pendingOrder").text(totalOrders.filter((val, num) => val.status === "PENDING")
                                .length)
                            $("#expOrder").text(totalOrders.filter((val, index) => val.status === "EXPIRED").length)
                            $("#successOrders").text(totalOrders.filter((val, num) => val.status == "DONE" || val
                                .status == "PAID").length)
                            let pendingPaid = totalOrders.filter((val, num) => val.status == "PENDING" || val
                                .status == "PAID")
                            console.log(pendingPaid)
                            // tblPendingPaid using bootstraptable
                            $('#tblPendingPaid').bootstrapTable({
                                data: pendingPaid,
                                onClickRow: (row, $element) => {
                                    console.log(row)
                                },
                                height: '400',
                                columns: [{
                                        field: 'invoice_number',
                                        title: '#',
                                        sortable: true,
                                    },
                                    {
                                        field: 'product_name',
                                        title: 'Name',
                                        sortable: true,
                                    },
                                    {
                                        field: 'product_data_name',
                                        title: 'Amount',
                                        sortable: true,
                                    },
                                    {
                                        field: 'status',
                                        title: 'Status',
                                        sortable: true,
                                        formatter: (value, row, index) => {
                                            if (value == "PENDING") {
                                                return `<span class="label label-danger">${value}</span>`
                                            } else if (value == "PAID") {
                                                return `<span class="label label-success">${value}</span>`
                                            } else if (value == "EXPIRED") {
                                                return `<span class="label label-warning">${value}</span>`
                                            } else if (value == "DONE") {
                                                return `<span class="label label-success">${value}</span>`
                                            }
                                        }
                                    }
                                ]
                            });
                        })
                })
            </script>
        @endsection
