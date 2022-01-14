@extends('admin.layouts.layout')
@section('title')
    Invoices
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblInvoices" class="table table-stripped"></table>
                    </div>
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
        const initTable = () => {
            const detailFormat = (index, row) => {
                let $row = $("<div>", {
                    class: 'row'
                });
                let $col = $("<div>", {
                    class: 'col-xs-12 col-sm-12 col-md-5 col-lg-5',
                });
                let $p = $("<p>");
                let $invoiceNumber = $('<h3>', {
                    text: `Invoice Number: `
                });
                let t = [
                    `<hr/>`,
                    `Product Name : <b>${row['product_name']}</b>`,
                    `Product Data: <b>${row['product_data_name']}</b>`,
                    `Price: <b>${parseInt(row['price']+row['fee']).toLocaleString('id-ID')}</b>`,
                    `Payment Method: <b>${row['payment_method']}</b>`,
                    `User: <b>${row['user_username'] ? row['user_username'] : 'GUEST'}</b>`,
                    `Whatsapp Number: <b>${row['number'] ? row['number'] : row['user_number']}</b>`,
                    `Created At: <b>${row['created_at']}</b>`
                ]
                $p.append(t.join('<br>'))
                $invoiceNumber.append($('<b>').text(row['invoice_number']))
                $col.append($invoiceNumber)
                if (row['user_input'] != '') {
                    let $_inputs = JSON.parse(row['user_input'])
                    console.log($_inputs)
                    let _bb = [
                        `<div class="container bg-secondary text-white shadow pb-2 pt-2 rounded">`,
                        $_inputs.map((value, index) => {
                            return [
                                `<label for="${value.name}">${value.name}</label>`,
                                `<input type="text" class="form-control" value="${value.value}" id="${value.name}" name="${value.name}" readonly/>`
                            ].join('')
                        }),
                        `</div>`
                    ].join('').replace(',', "")
                    $col.append(_bb)
                }
                $col.append($p)

                $row.append($col)
                return $row[0].outerHTML
            }
            window.icons = {
                paginationSwitchDown: 'fa-caret-square-down',
                paginationSwitchUp: 'fa-caret-square-up',
                refresh: 'fa-sync',
                toggleOff: 'fa-toggle-off',
                toggleOn: 'fa-toggle-on',
                columns: 'fa-th-list',
                fullscreen: 'fa-arrows-alt',
                detailOpen: 'fa-plus',
                detailClose: 'fa-minus'
            }
            $("#tblInvoices").bootstrapTable('destroy').bootstrapTable({
                url: `{{ route('api.invoice.list') }}`,
                search: true,
                showRefresh: true,
                detailView: true,
                // detailViewByClick: true,
                detailFormatter: detailFormat,
                detailViewIcon: true,
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                showColumns: true,
                showColumnsToggleAll: true,
                searchHighlightFormatter: true,
                columns: [{
                        title: '#',
                        field: 'invoice_number',
                        sortable: true
                    },
                    {
                        title: 'Tanggal',
                        field: 'created_at',
                        sortable: true
                    },
                    {
                        title: 'Product Name',
                        field: 'product_name',
                        sortable: true
                    },
                    {
                        title: 'Product Data',
                        field: 'product_data_name',
                        sortable: true
                    },
                    {
                        title: 'User',
                        formatter: (value, row, index) => row['number'] ? row['number'] : row[
                            'user_number'],
                        sortable: true
                    },
                    {
                        title: 'Price',
                        sortable: true,
                        formatter: (val, row, index) => `Rp.` + parseFloat(row['price'] + row['fee'])
                            .toLocaleString()
                    },
                    {
                        title: 'Status',
                        field: 'status',
                        sortable: true,
                        formatter: (val, row, index) => {
                            let $bdg = $("<span>", {
                                class: 'badge',
                                text: val
                            })
                            switch (String(val).toLocaleLowerCase()) {
                                case 'pending':
                                    $bdg.addClass('badge-warning')
                                    break;
                                case 'progress':
                                    $bdg.addClass('badge-warning')
                                    break;
                                case 'done':
                                    $bdg.addClass('badge-info')
                                    break;
                                case 'paid':
                                    $bdg.addClass('badge-success')
                                    break;
                                case 'expired':
                                    $bdg.addClass('badge-danger');
                                    break;
                                default:
                                    break;
                            }
                            return $bdg[0].outerHTML
                        }
                    },
                    {
                        title: 'Actions',
                        events: {
                            'click .done-order': function(e, value, row, index) {
                                let data = row;
                                data.type = 'done';
                                $.ajax({
                                    url: `{{ route('admin.invoice.done_order') }}`,
                                    method: 'POST',
                                    processData: false,
                                    contentType: false,
                                    data: JSON.stringify(data),
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function(result) {
                                        console.log(result)
                                        if (result.success) {
                                            Swal.fire('Success', result.message, 'success')
                                            $("#tblInvoices").bootstrapTable('refresh')
                                        }
                                    }
                                })
                            },
                            'click .retry-order': function(e, value, row, index) {
                                let data = row;
                                data.type = 'retry';
                                $.ajax({
                                    url: `{{ route('admin.invoice.done_order') }}`,
                                    method: 'POST',
                                    processData: false,
                                    contentType: false,
                                    data: JSON.stringify(data),
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function(result) {
                                        console.log(result)
                                        if (result.success) {
                                            Swal.fire('Success', result.message, 'success')
                                            $("#tblInvoices").bootstrapTable('refresh')
                                        } else {
                                            Swal.fire('Failed', result.message, 'error')
                                        }
                                    }
                                })
                            }
                        },
                        formatter: (val, row, index) => {
                            if (row['status'].toLocaleLowerCase() == 'paid' ) {
                                return [
                                    '<a class="badge badge-success done-order" href="javascript:void(0)" title="Done">',
                                    '<i class="fa fa-check-square"></i> Done',
                                    '</a>  ',
                                    // view invoice button
                                    `<a class="badge badge-info view-invoice" href="{{ route('invoice', ':invoice_number') }}" target="_blank" title="View Invoice">`
                                    .replace(":invoice_number", row['invoice_number']),
                                    '<i class="fa fa-eye"></i> View',
                                    '</a>'
                                ].join('')
                            } else if (row['status'].toLocaleLowerCase() == 'pending' || row['status']
                                    .toLocaleLowerCase() == 'progress'|| row['status']
                                    .toLocaleLowerCase() == 'pending' && !String(row[
                                    'product_data_name']).startsWith('TOPUP')) {
                                console.log(row['status'].toLocaleLowerCase())
                                return ['<a class="badge badge-danger retry-order" href="javascript:void(0)" title="Retry">',
                                    '<i class="fa fa-redo"></i> Proses',
                                    '</a>  ',
                                    // view invoice button
                                    `<a class="badge badge-info view-invoice" href="{{ route('invoice', ':invoice_number') }}" target="_blank" title="View Invoice">`
                                    .replace(":invoice_number", row['invoice_number']),
                                    '<i class="fa fa-eye"></i> View',
                                    '</a>'
                                ].join('')
                            }
                        }
                    }
                ]
            })
        }
    </script>
@endsection
