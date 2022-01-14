@extends('admin.layouts.layout')
@section('title')
    List Payment Gateway
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div id="toolbar">
                        <a class="btn btn-primary" href="{{ route('payment.add') }}">Add +</a>
                    </div>
                    <table id="tblPay" class="table table-stripped"></table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready((e) => {
            initTable()
        })

        function initTable() {
            $("#tblPay").bootstrapTable('destroy').bootstrapTable({
                url: "{{ route('payment.list') }}",
                toolbar: "#toolbar",
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                search: true,
                showColumns: true,
                showColumnsToggleAll: true,
                searchHighlightFormatter: true,
                columns: [{
                        title: '#',
                        formatter: (value, row, index) => {
                            return `<img src="${row.image}" alt="${row.payment}" height="25px">`
                        }
                    },
                    {
                        title: 'Payment',
                        field: 'payment'
                    },
                    {
                        title: 'Name',
                        field: 'name'
                    },
                    {
                        title: 'Active',
                        sortable: true,
                        events: {
                            'click input[name="isActive"]': (e, value, row, index) => {
                                $.post(`{{ URL::route('payment.event') }}?type=reactivate&payment=${row.payment}`,
                                    (res) => {
                                        $("#tblPay").bootstrapTable('refresh');
                                    })
                            },
                        },
                        formatter: (value, row, index) => {
                            let checked = '';
                            if (row.status) {
                                checked = 'checked'
                            }
                            let b = `
                                <div class="switch">
                                    <label><input id="isActive${index}" name="isActive" type="checkbox" ${checked}><span class="lever"></span></label>
                                </div>
                                `
                            return b
                        }
                    },
                    {
                        title: 'Update at',
                        field: 'updated_at'
                    },
                    {
                        title: 'Actions',
                        formatter: (value, row, index) => {
                            let btn = $('<a/>', {
                                class: ['btn', 'btn-primary', 'btn-sm'].join(' '),
                                text: 'Edit',
                                href: `{{ route('payment.add') }}?id=${row.payment}`
                            });
                            return btn[0].outerHTML;
                        }
                    }
                ]
            })
        }
    </script>
@endsection
