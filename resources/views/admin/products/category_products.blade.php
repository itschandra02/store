@extends('admin.layouts.layout')
@section('title')
    List Category Products
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div id="toolbar">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdCategoryAdd">+
                            Add</button>
                        <button class="btn btn-success btn-sm" data-toggle="button" id="toggleReorder"
                            aria-pressed="false">Reorder</button>
                    </div>
                    <table id="tblCategories" class="table table-stripped"></table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal category add here --}}

    <div class="modal fade" id="mdCategoryAdd" tabindex="-1" role="dialog" aria-labelledby="mdCategoryAddLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdCategoryAddLabel">
                        Add Category
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="addedCategory">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                            <div class="form-group col-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" onclick="addCategory()">Save</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdCategoryEdit" tabindex="-1" role="dialog" aria-labelledby="mdCategoryEditLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdCategoryEditLabel">
                        Edit Category
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="editedCategory">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="id" class="id">ID</label>
                                <input type="text" class="form-control" id="id" name="id" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                            <div class="form-group col-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" onclick="saveCategory()">Save</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            initTable();
            $("#editedCategory").submit(function(e) {
                e.preventDefault();
            })
            $("#mdCategoryEdit").on("show.bs.modal", function(e) {
                var id = $(e.relatedTarget).data('bs-id');
                let data = $("#tblCategories").bootstrapTable('getData').filter(data => data.id == id)[0];
                $("#id").val(id);
                console.log(data)
                $("#name").val(data.name);
                $("#title").val(data.title);
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
        });

        function addCategory() {
            $.ajax({
                url: "{{ route('prod.category.add') }}",
                type: "POST",
                data: $("#addedCategory").serialize(),
                success: function(data) {
                    $("#mdCategoryAdd").modal('hide');
                    $("#tblCategories").bootstrapTable('refresh');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function saveCategory() {
            var data = $('#editedCategory').serialize();
            $.ajax({
                url: "{{ route('prod.category.edit') }}",
                type: 'POST',
                data: data,
                success: function(data) {
                    $('#mdCategoryEdit').modal('hide');
                    $('#tblCategories').bootstrapTable('refresh');
                }
            });
        }

        function initTable(reorder = false) {
            $('#tblCategories').bootstrapTable('destroy').bootstrapTable({
                url: `{{ route('prod.category.list') }}`,
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
                    $.post("{{ URL::route('prod.category.event') }}", {
                        type: 'reorder',
                        order: order
                    }, (res) => {
                        $("#tblCategories").bootstrapTable('refresh');
                    })
                },
                columns: [{
                        field: 'id',
                        title: 'id'
                    },
                    {
                        field: 'title',
                        title: 'Title'
                    },
                    {
                        field: 'name',
                        title: 'Name'
                    },
                    {
                        title: 'Active',
                        events: {
                            'click input[name="isActive"]': (e, value, row, index) => {
                                $.post("{{ URL::route('prod.category.event') }}?type=reactivate&id=" + row
                                    .id, (
                                        res) => {
                                        $("#tblCategories").bootstrapTable('refresh');
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
                        title: 'Action',
                        events: {
                            'click #delete-category': function(e, value, row, index) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            url: `{{ route('prod.category.delete') }}`,
                                            type: 'POST',
                                            data: {
                                                id: row.id
                                            },
                                            success: function(res) {
                                                if (res.status) {
                                                    Swal.fire(
                                                        'Deleted!',
                                                        'Your file has been deleted.',
                                                        'success'
                                                    )
                                                    $('#tblCategories').bootstrapTable(
                                                        'refresh');
                                                } else {
                                                    Swal.fire(
                                                        'Error!',
                                                        'Your file has not been deleted.',
                                                        'error'
                                                    )
                                                }
                                            }
                                        });
                                    }
                                })

                            }
                        },
                        formatter: function(value, row, index) {
                            let btn =
                                `<button class="btn btn-danger btn-sm" id="delete-category">Delete</button>`
                            btn +=
                                ` <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#mdCategoryEdit" data-bs-id="${row['id']}">Edit</button>`
                            return btn
                        }
                    },

                ]
            });
        }
    </script>
@endsection
