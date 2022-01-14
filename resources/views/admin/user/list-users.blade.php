@extends('admin.layouts.layout')
@section('title')
    List Users
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div id="toolbar">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#mdUserRoles">User Roles</button>
                    </div>
                    <table class="table table-stripped" id="userTable"></table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdUserRoles" tabindex="-1" role="dialog" aria-labelledby="mdUserRolesLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdUserRolesLabel">Edit User Roles</h4>
                    <button class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="row">
                        <div class="col">
                            <label for="#role_type">Role Type</label>
                            <input type="text" name="role_type" id="role_type" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <button class="btn btn-primary" id="btnAddRole" onclick="addRole()">Add</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <table class="table table-stripped" id="roleTable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="mdUserEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mdUserEditLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdUserEditLabel">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="editedUser">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="userId">ID</label>
                                <input type="text" name="userId" id="userId" readonly class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="number">Number</label>
                                <input type="text" name="number" id="number" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="balance">Balance</label>
                                <input type="text" name="balance" id="balance" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="status">Status</label>
                                @php
                                    $uType = DB::table('usertype')->get();
                                @endphp
                                <select name="status" id="status" class="form-control">
                                    @foreach ($uType as $item)
                                        <option value="{{ $item->type }}">{{ $item->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" onclick="saveUser()">Save</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            initTable()
            initRoleTable()
            $("#editedUser").submit(function(e) {
                e.preventDefault();
            })
            $("#mdUserEdit").on("show.bs.modal", function(e) {
                let $btn = $(e.relatedTarget);
                let userID = $btn.data('bs-id');
                let that = $(this);
                $.get(`{{ route('api.user') }}`, {
                    id: userID
                }, (resp) => {
                    if (resp.success) {
                        let data = resp.data;
                        $(this).find("#userId").val(userID);
                        that.find("#name").val(data.name);
                        that.find("#username").val(data.username);
                        that.find("#number").val(data.number);
                        that.find("#balance").val(data.balance);
                        that.find("#status").val(data.status);
                    }
                });
            })
        })

        function saveUser() {
            let data = {
                id: $("#userId").val(),
                name: $("#name").val(),
                username: $("#username").val(),
                number: $("#number").val(),
                balance: $("#balance").val(),
                status: $("#status option:selected").val(),
            }
            $.post(`{{ route('admin.profile.save-user') }}`, data, (res) => {
                if (res.success) {
                    initTable()
                    $("#mdUserEdit").modal('hide');
                    Swal.fire("Success", "User has edited!", 'success')
                }
            })
        }

        function editRole(id) {
            console.log(id);
            $.get(`{{ route('api.usertype') }}`, {
                id: id
            }, (resp) => {
                let data = resp;
                $("#mdUserRoles .modal-title").text("Edit User Role");
                $("#role_id").val(id);
                $("#role_type").val(data.type);
                // set button to edit
                // and add cancel edit button for clear role id and role type
                $("#btnAddRole").text("Edit");
                $("#btnAddRole").attr("onclick", "saveRole()");
                $("#btnAddRole").next().remove();
                $("#btnAddRole").after(
                    `<button type="button" class="btn btn-danger" onclick="clearRole()">Cancel</button>`);
            });
        }

        function saveRole() {
            let data = {
                id: $("#role_id").val(),
                type: $("#role_type").val(),
            }
            $.post(`{{ route('admin.profile.save-role') }}`, data, (res) => {
                if (res.success) {
                    initRoleTable()
                    $("#mdUserRoles").modal('hide');
                    clearRole();
                    Swal.fire("Success", "User Role has edited!", 'success')
                }
            })
        }

        function clearRole() {
            $("#mdUserRoles .modal-title").text("Add User Role");
            $("#role_id").val("");
            $("#role_type").val("");
            // set button to add
            // and remove cancel edit button for clear role id and role type
            $("#btnAddRole").text("Add");
            $("#btnAddRole").attr("onclick", "addRole()");
            $("#btnAddRole").next().remove();
        }

        function addRole() {
            let data = {
                id: $("#role_id").val(),
                type: $("#role_type").val(),
            }
            $.post(`{{ route('admin.profile.add-role') }}`, data, (res) => {
                if (res.success) {
                    initRoleTable()
                    $("#mdUserRoles").modal('hide');
                    $("#role_id").val("");
                    $("#role_type").val("");

                    Swal.fire("Success", "User Role has added!", 'success')
                }
            })
        }

        function removeRole(id) {
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
                    $.post(`{{ route('admin.profile.remove-role') }}`, {
                        id: id
                    }, (res) => {
                        if (res.success) {
                            initRoleTable()
                            Swal.fire("Success", "User Role has removed!", 'success')
                        }
                    })
                }
            })
        }


        function initRoleTable() {
            actionFormatter = function(value, row, index) {
                // add edit and remove with text and font awesome icon small button
                // based row id
                return [
                    `<button type="button" class="btn btn-info btn-sm" onclick="editRole(${row.id})"><i class="fa fa-edit"></i></button>`,
                    `<button type="button" class="btn btn-danger btn-sm" onclick="removeRole(${row.id})"><i class="fa fa-trash"></i></button>`
                ].join('');

            }
            $("#roleTable").bootstrapTable('destroy').bootstrapTable({
                url: `{{ route('api.usertype') }}`,
                columns: [{
                    field: 'id',
                    title: 'ID',
                    align: 'center',
                    valign: 'middle',
                    sortable: true,
                    visible: false
                }, {
                    field: 'type',
                    title: 'Type',
                    align: 'center',
                    valign: 'middle',
                    sortable: true,
                    visible: true
                }, {
                    field: 'action',
                    title: 'Action',
                    align: 'center',
                    valign: 'middle',
                    sortable: true,
                    visible: true,
                    formatter: actionFormatter
                }]
            })
        }

        function initTable() {
            $("#userTable").bootstrapTable('destroy').bootstrapTable({
                url: `{{ route('admin.profile.list') }}`,
                pagination: true,
                toolbar: "#toolbar",
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                search: true,
                showColumns: true,
                showColumnsToggleAll: true,
                searchHighlightFormatter: true,
                columns: [{
                        title: '#',
                        field: 'id'
                    },
                    {
                        title: 'Avatar',
                        field: 'avatar',
                        formatter: (val, row, index) =>
                            `<img src="${val}" class="img-fluid img-circle" width="32px" />`
                    },
                    {
                        title: 'Name',
                        field: 'name'
                    },
                    {
                        title: 'Username',
                        field: 'username'
                    },
                    {
                        title: 'Number',
                        field: 'number'
                    },
                    {
                        title: 'balance',
                        field: 'balance',
                        formatter: (val, row, index) => "Rp." + parseInt(val).toLocaleString()
                    },
                    {
                        title: 'status',
                        field: 'status'
                    },
                    {
                        title: 'action',
                        events: {
                            'click #delete-user': (e, val, row, index) => {
                                Swal.fire({
                                    title: 'Are your sure?',
                                    text: `User ${row.username} will be deleted`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: `Yes, Delete!`,
                                    cancelButtonText: `No, cancel!`
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.post(`{{ route('admin.profile.remove-user') }}`,
                                            row,
                                            (resp) => {
                                                initTable()
                                                Swal.fire({
                                                    title: 'Success',
                                                    text: resp.message,
                                                    icon: 'success'
                                                })
                                            })
                                    }
                                });
                            }
                        },
                        formatter: (val, row, index) => {
                            let btn =
                                `<button class="btn btn-danger btn-sm" id="delete-user">Delete</button>`
                            btn +=
                                ` <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#mdUserEdit" data-bs-id="${row['id']}">Edit</button>`
                            return btn
                        }
                    }
                ]
            });

        }
    </script>
@endsection
