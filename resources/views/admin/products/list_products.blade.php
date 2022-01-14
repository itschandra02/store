@extends('admin.layouts.layout')
@section('title')
    List Products
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div id="toolbar">
                        <a class="btn btn-primary btn-sm" href="{{ route('prod.add') }}">+Add</a>
                        <button class="btn btn-success btn-sm" data-toggle="button" id="toggleReorder"
                            aria-pressed="false">Reorder</button>
                    </div>
                    <table id="tblProducts" class="table table-stripped"></table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            initTable();

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

        function initTable(reorder = false) {
            $("#tblProducts").bootstrapTable('destroy').bootstrapTable({
                url: "{{ URL::route('prod.list') }}",
                toolbar: '#toolbar',
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                search: true,
                showRefresh: true,
                showColumns: true,
                showColumnsToggleAll: true,
                searchHighlightFormatter: true,
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
                    $.post("{{ URL::route('prod.event') }}", {
                        type: 'reorder',
                        order: order
                    }, (res) => {
                        $("#tblProducts").bootstrapTable('refresh');
                    })
                },
                columns: [{
                        title: '#',
                        formatter: (value, row, index) => {
                            let b = [
                                `
                                    <figure class="avatar avatar-lg">
                                        <img src="${row.thumbnail}" />
                                    </figure>
                                    `
                            ]
                            return b.join('');
                        }
                    },
                    {
                        title: 'ID',
                        field: 'id',
                        sortable: true,
                    },
                    {
                        title: 'Name',
                        field: 'name',
                        sortable: true,
                        formatter: (value, row, index) => {
                            return `<a href="{{ URL::to('order') }}/${row.slug}" target="_blank">${row.name} <i class="fas fa-external-link-alt"></i></a>`
                        }
                    },
                    {
                        title: 'Subtitle',
                        field: 'subtitle',
                        sortable: true,
                    },
                    {
                        title: 'Slug',
                        field: 'slug',
                        sortable: true,
                    }, {
                        title: 'Category',
                        field: 'category'
                    },
                    {
                        title: 'Active',
                        sortable: true,
                        events: window.operateEvents,
                        formatter: (value, row, index) => {
                            let checked = '';
                            if (row.active) {
                                checked = 'checked'
                            }
                            // let b = `
                        // <div class="material-switch">
                        //     <input id="isActive${index}" name="isActive" type="checkbox" ${checked}/>
                        //     <label for="isActive${index}" class="bg-primary"></label>
                        // </div>
                        // `
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
                        events: window.operateEvents,
                        formatter: (value, row, index) => {
                            let b = `
                                    <a href="{{ route('prod.add') }}?id=${row.id}" class="btn btn-success btn-sm">Edit</a>
                                    <button id="delete" class="btn btn-danger btn-sm">Delete</button>
                                `
                            return b
                        }
                    }
                ]
            })
        }
        window.operateEvents = {
            'click input[name="isActive"]': (e, value, row, index) => {
                $.post("{{ URL::route('prod.event') }}?type=reactivate&id=" + row.id, (res) => {
                    $("#tblProducts").bootstrapTable('refresh');
                })
            },
            'click #delete': (e, value, row, index) => {
                $.post("{{ route('prod.event') }}?type=delete&id=" + row.id, (res) => {
                    $("#tblProducts").bootstrapTable('refresh');
                    location.reload();
                })
            }
        }
    </script>
@endsection
