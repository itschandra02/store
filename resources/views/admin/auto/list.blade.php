@extends('admin.layouts.layout')
@section('title')
    Auto Order
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div id="toolbar">
                        <a class="btn btn-primary btn-sm" href="{{ route('auto-order.add') }}">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    </div>
                    <table class="table table-stripped" id="tblAuto">

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#tblAuto").bootstrapTable({
                url: "{{ route('auto-order.list') }}",
                toolbar: "#toolbar",
                columns: [{
                        field: 'account',
                        title: 'Account',
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    },
                    {
                        field: 'name',
                        title: 'Name',
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    },
                    {
                        field: 'username',
                        title: 'Username',
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    },
                    {
                        field: 'password',
                        title: 'Password',
                        align: 'center',
                        valign: 'middle',
                        events: {
                            'click #btnKey': function(e, value, row, index) {
                                Swal.fire({
                                    title: `${row['name']}'s Key`,
                                    input: 'textarea',
                                    inputValue: row['password'],
                                    inputAttributes: {
                                        readonly: true
                                    },
                                    type: 'info',
                                });
                            }
                        },
                        formatter: (value, row, index) => {
                            return `<a href="javascript:void(0);" id="btnKey" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>`;
                        },
                        sortable: true
                    },
                    {
                        title: 'Key',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        events: {
                            'click #btnKey': function(e, value, row, index) {
                                Swal.fire({
                                    title: `${row['name']}'s Key`,
                                    input: 'textarea',
                                    inputValue: row['cookie'] ?? row['token'],
                                    inputAttributes: {
                                        readonly: true
                                    },
                                    type: 'info',
                                });
                            }
                        },
                        formatter: (value, row, index) => {
                            return `<a href="javascript:void(0);" id="btnKey" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>`;
                        },
                    },
                    {
                        field: 'last_balance',
                        title: 'balance',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                    },
                    {
                        field: 'is_active',
                        title: 'Status',
                        align: 'center',
                        valign: 'middle',
                        formatter: (value, row, index) => {
                            return `<span class="badge badge-${value ? 'success' : 'danger'}">${value ? 'Active' : 'Inactive'}</span>`;
                        },
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        events: {
                            'click #btnDelete': function(e, value, row, index) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            url: `{{ route('auto-order.event') }}`,
                                            type: 'POST',
                                            data: {
                                                type: 'delete',
                                                account: row['account']
                                            },
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data.status) {
                                                    Swal.fire(
                                                        'Deleted!',
                                                        'Your file has been deleted.',
                                                        'success'
                                                    ).then(() => {
                                                        window.location
                                                            .reload();
                                                    });
                                                } else {
                                                    Swal.fire(
                                                        'Error!',
                                                        data.message,
                                                        'error'
                                                    );
                                                }
                                            }
                                        });
                                    }
                                });
                            },
                        },
                        formatter: (value, row, index) => {
                            return `<a href="{{ route('auto-order.add') }}?id=${row['account']}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger" id="btnDelete"><i class="fas fa-trash"></i></a>`;
                        },
                    }
                ]
            })
        });
    </script>
@endsection
