@extends('admin.layouts.layout')
@section('title')
    List Data
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div id="toolbar">
                        <a href="{{ route('page.add.data') }}" class="btn btn-primary btn-sm">+Add</a>
                        <button class="btn btn-success btn-sm" data-toggle="button" id="toggleReorder"
                            aria-pressed="false">Reorder</button>
                    </div>

                    <table id="tblList" class="table"></table>
                </div>
            </div>
        </div>
    </div>

    <div id="mdRoleEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mdRoleEditLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdRoleEditLabel">Role Prices</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="productDataID">ID</label>
                        <input type="text" name="productDataID" id="productDataID" readonly class="form-control">
                    </div>
                    <table class="table table-stripped" id="productDataPrices">
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" onclick="savePrices()">Save</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('scripts')
    @php
    $uType = DB::table('usertype')
        ->select(DB::raw('type as name'))
        ->get();
    @endphp
    <script>
        let PRODUCT_DATA = []
        $(document).ready(() => {
            initTable()
            $("#mdRoleEdit").on("show.bs.modal", function(e) {
                let _btn = $(e.relatedTarget);
                let _id = _btn.data('bs-id');
                // let _json = JSON.parse(_btn.data('json'))
                let _json = []
                let __j = {!! $uType->toJson() !!};
                if (_btn.data('json')) {
                    js_on = _btn.data('json')
                    _json = __j.map(item => {
                        return {
                            name: item.name,
                            price: js_on.find(i => i.name == item.name) ? js_on.find(i => i.name ==
                                item.name).price : 0
                        }
                    })
                } else {
                    _json = []
                    __j.forEach((value, index) => {
                        _json.push({
                            name: value.name,
                            price: _btn.data('bs-defprice') ? _btn.data('bs-defprice') : 0
                        })
                    })
                }
                PRODUCT_DATA = _json;
                console.log(PRODUCT_DATA)
                $(this).find("#productDataID").val(_id);
                $(this).find("#productDataPrices").bootstrapTable('destroy').bootstrapTable({
                    data: _json,
                    columns: [{
                            title: 'Name',
                            field: 'name'
                        },
                        {
                            title: 'Price',
                            field: 'price',
                            editable: {
                                type: 'number',
                                mode: 'inline',
                            },
                        }
                    ],
                    onEditableSave: (field, row, oldValue, $el) => {
                        PRODUCT_DATA[PRODUCT_DATA.findIndex(el => el.name == row.name)] = row
                        // $.post(`{{ route('data.edit') }}`, row, (result) => {
                        //     if (result.success) {
                        //         Swal.fire("Edit", 'Berhasil edit', 'success')
                        //     }
                        // })
                    }
                })
            })

            $("#toggleReorder").click(function() {
                if ($(this).attr('aria-pressed') == 'false') {
                    initTable(true);
                    $(this).text('Reorder done');
                } else {
                    initTable(false)
                    $(this).text('Reorder');
                }
            });
        })

        function savePrices() {
            $.post("{{ URL::route('data.event') }}", {
                type: 'saveprices',
                id: $("#productDataID").val(),
                data: JSON.stringify(PRODUCT_DATA)
            }, (
                res) => {
                initTable();
                $("#mdRoleEdit").modal('hide');
            })
        }

        function initTable(reorder = false) {
            const detailFormat = (index, row) => {
                let $html = [
                    `<b>Role per Prices</b>`
                ]
                $data = JSON.parse(row.role_prices);
                console.log($data)
                $data.forEach(element => {
                    $html.push(`<b>${element.name.toUpperCase()}</b> : ${element.price}`)
                });

                return $html.join("<br>")
            }
            $("#tblList").bootstrapTable('destroy').bootstrapTable({
                url: "{{ route('data.list') }}",
                toolbar: "#toolbar",
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                search: true,
                detailView: true,
                // detailViewByClick: true,
                detailFormatter: detailFormat,
                detailViewIcon: true,
                showColumns: true,
                showColumnsToggleAll: true,
                showRefresh: true,
                reorderableRows: reorder,
                useRowAttrFunc: true,
                onReorderRow: (newOrderedList) => {
                    var order = [];
                    for (let index = 0; index < newOrderedList.length; index++) {
                        const element = newOrderedList[index];
                        order.push({
                            id: element.id,
                            position: index + 1
                        });
                    }
                    $.post("{{ URL::route('data.event') }}", {
                        type: 'reorder',
                        order: order
                    }, (res) => {
                        $("#tblList").bootstrapTable('refresh');
                    })
                },
                columns: [{
                        title: "Product",
                        sortable: true,
                        field: "product_name",
                    },
                    {
                        title: "Data",
                        sortable: true,
                        field: "name",
                        editable: {
                            type: 'text',
                            title: 'name',
                            mode: 'inline',
                            validate: function(v) {
                                if (!v) return 'Username can not be empty';
                            }
                        }
                    },
                    {
                        title: "Type",
                        sortable: true,
                        field: "type_data",
                        editable: {
                            type: 'select',
                            mode: 'inline',
                            pk: 1,
                            source: [{
                                    value: 'diamond',
                                    text: 'diamond'
                                },
                                {
                                    value: 'voucher',
                                    text: 'voucher'
                                }
                            ]
                        }
                    },
                    {
                        title: 'Additional',
                        sortable: true,
                        field: 'layanan',
                        editable: {
                            type: 'text',
                            mode: 'inline',
                        },
                    },
                    {
                        title: "Price",
                        sortable: true,
                        field: "price",
                        editable: {
                            type: 'number',
                            mode: 'inline',
                        },
                        // formatter: (value, row, index) => "Rp." + parseInt(row.price).toLocaleString()
                    },
                    // {
                    //     title: "Discount %",
                    //     sortable: true,
                    //     field: "discount",
                    //     editable: {
                    //         type: 'number',
                    //         mode: 'inline',
                    //     },
                    // },

                    // {
                    //     title: 'Role Prices',
                    //     field: 'role_prices'
                    // },
                    {
                        title: 'Active',
                        events: {
                            'click input[name="isActive"]': (e, value, row, index) => {
                                $.post("{{ URL::route('data.event') }}?type=reactivate&id=" + row
                                    .id, (
                                        res) => {
                                        $("#tblProducts").bootstrapTable('refresh');
                                    })
                            },
                        },
                        formatter: (value, row, index) => {
                            let checked = '';
                            if (row.active) {
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
                        title: "Action",
                        events: {
                            'click #delete': (e, value, row, index) => {
                                $.post(`{{ route('data.delete') }}`, row, (result) => {
                                    if (result.success) {
                                        Swal.fire('Deleted', "Berhasil delete", 'success');
                                        initTable()
                                    }
                                })
                            }
                        },
                        formatter: (value, row, index) => {
                            let btn =
                                `<a type="button" id="delete" class="badge badge-sm badge-danger text-white">Delete</a> `;
                            btn +=
                                `<a type="button" class="badge badge-sm badge-info text-white" data-toggle="modal" data-target="#mdRoleEdit" data-bs-id="${row['id']}" data-bs-defprice="${row['price']}" data-json='${row['role_prices']}'>Edit</a>`
                            if (row['type_data'] == 'voucher') {
                                btn +=
                                    `<br><a href='{{ route('data.page.voucher') }}' class="badge badge-sm badge-primary text-white">List Vouchers</a>`
                            }
                            return btn;
                        }
                    }
                ],
                onEditableSave: (field, row, oldValue, $el) => {
                    $.post(`{{ route('data.edit') }}`, row, (result) => {
                        if (result.success) {
                            Swal.fire("Edit", 'Berhasil edit', 'success')
                        }
                    })
                }
            })
        }
    </script>
@endsection
