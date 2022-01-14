@extends('admin.layouts.layout')
@section('title')
    Admin Profile
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        <img src="{{ $data->profile_pic }}" class="img-circle" width="150" />
                        <h4 class="card-title m-t-10">{{ $data->username }}</h4>
                        <h6 class="card-subtitle">{{ $data->status }}</h6>
                    </center>
                </div>
                <hr>
                <div class="card-body">
                    <small class="text-muted">Name </small>
                    <h6>{{ $data->name }}</h6>
                    <small class="text-muted p-t-30 db">Phone Number</small>
                    <h6>{{ $data->number }}</h6>
                    <small class="text-muted p-t-30 db">Email address </small>
                    <h6>{{ $data->email }}</h6>
                    <small class="text-muted p-t-30 db">Created At</small>
                    <h6>{{ $data->created_at }}</h6>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings"
                            role="tab">Settings</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#listAdmin"
                            role="tab">List Admin</a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="settings" role="tabpanel">
                        <div class="card-body">
                            <form class="form-horizontal form-material" id="frmSettings">

                                <div class="form-group">
                                    <label for="image" class="col-md-12">Avatar profile</label>
                                    <input type="file" id="image" class="dropify col-md-12" name="image"
                                        data-default-file="{{ $data->profile_pic }}" />
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-12">
                                        <input type="text" id="name" placeholder="Name"
                                            class="form-control form-control-line" value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Username</label>
                                    <div class="col-md-12">
                                        <input type="text" id="username" placeholder="Username"
                                            class="form-control form-control-line" value="{{ $data->username }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" id="email" placeholder="Email"
                                            class="form-control form-control-line" value="{{ $data->email }}"
                                            name="example-email" id="example-email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" id="password" placeholder="(Leave blank if not changed)"
                                            class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" id="number" placeholder="628xxxx"
                                            class="form-control form-control-line" value="{{ $data->number }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="listAdmin">
                        <div class="card-body">
                            <div id="toolbar">
                                <button class="btn btn-primary" onclick="showAddModal()">Add +</button>
                            </div>
                            <table class="table table-stripped" id="tblAdmins"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- create a bootstrap modal for admin insertion with different id -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-material" id="frmAdd">
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text" id="name" placeholder="Name" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Username</label>
                            <div class="col-md-12">
                                <input type="text" id="username" placeholder="Username"
                                    class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" id="email" placeholder="Email" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password" id="password" placeholder="Password"
                                    class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Phone No</label>
                            <div class="col-md-12">
                                <input type="text" id="number" placeholder="628xxxx" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success">Add Admin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        function showAddModal() {
            $('#modalAdd').modal('show');
        }
        $(document).ready(function() {
            $('.dropify').dropify();
            // for admin addition submit form with json data
            // request with json data
            $('#frmAdd').submit(function(e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('name', $('#frmAdd #name').val());
                formData.append('username', $('#frmAdd #username').val());
                formData.append('email', $('#frmAdd #email').val());
                formData.append('password', $('#frmAdd #password').val());
                formData.append('number', $('#frmAdd #number').val());
                $.ajax({
                    url: "{{ route('admin.profile.add-admin') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#modalAdmin').modal('hide');
                            $('#tblAdmins').bootstrapTable('refresh');
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        toastr.error(data.message);
                    }
                });
            });


            $("#tblAdmins").bootstrapTable({
                toolbar: '#toolbar',
                url: `{{ route('admin.profile.list-admin') }}`,
                showRefresh: true,
                columns: [{
                        title: '#',
                        field: 'id'
                    },
                    {
                        title: 'Avatar',
                        formatter: (value, row, index) => {
                            return `<img src="${row['profile_pic']}" class="img-fluid img-circle" width='32px'></img>`
                        }
                    },
                    {
                        title: 'Username',
                        field: 'username'
                    },
                    {
                        title: 'Email',
                        field: 'email'
                    },
                    {
                        title: 'Status',
                        field: 'status'
                    },
                    {
                        title: 'Action',
                        events: {
                            'click #deleteAdmin': (e, value, row, index) => {
                                // delete admin ajax request return message using Swal
                                // with parameter username
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
                                            url: `{{ route('admin.profile.delete-admin') }}`,
                                            type: 'POST',
                                            data: {
                                                username: row['username']
                                            },
                                            success: function(data) {
                                                if (data.status == 'success') {
                                                    initTable();
                                                    toastr.success(data
                                                        .message);
                                                } else {
                                                    toastr.error(data.message);
                                                }
                                            },
                                            error: function(data) {
                                                toastr.error(data.message);
                                            }
                                        });
                                    }
                                })
                            }
                        },
                        formatter: (value, row, index) => {
                            let uname = $(".u-text h4").text();
                            if (uname != row.username) {
                                return `<button class="btn btn-danger btn-sm" id='deleteAdmin'>Delete</button>`
                            }
                        }
                    }
                ]
            })
            $("#frmSettings").submit(function(e) {
                e.preventDefault();

                var frmData = new FormData();
                frmData.append("profile_pic", $("#image")[0].files[0]);
                frmData.append("name", $("input#name").val());
                frmData.append("username", $("input#username").val());
                frmData.append("email", $("input#email").val());
                frmData.append("passwd", $("input#password").val());
                frmData.append("phone", $("input#number").val());

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.profile.set') }}",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: frmData,
                    success: function(resp) {
                        // resetFormEdit();
                        location.reload();
                    }
                })
            })
        })
    </script>
@endsection
