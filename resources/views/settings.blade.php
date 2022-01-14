@extends('layouts.layout')
@section('title')
    Edit Profile
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto mt-5">
                <div class="card shadow bg-dark">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>
                        <form id="formEdit" enctype="multipart/form-data">
                            @if ($user->number == '')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                        aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <strong>Halo!</strong> Tolong isi nomor telepon agar dapat melakukan pembayaran.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <script>
                                    $(document).ready(() => {
                                        $("#number").focus();
                                    })
                                </script>
                            @endif
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                        class="avatar avatar-128 rounded-circle text-white p-2">
                                </div>
                            </div>
                            {{-- <div class="row mt-2">
                                <div class="col-4"><strong>Avatar</strong></div>
                                <div class="col">
                                    <input class="form-control" type="file" id="avatar" name="avatar" accept="image/jpeg">
                                </div>
                            </div> --}}
                            <div class="row mt-2">
                                <div class="col-4"><strong>Name</strong></div>
                                <div class="col"><input placeholder="name" type="text" name="name" id="name"
                                        value="{{ $user->name }}" class="form-control"></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4"><strong>Username</strong></div>
                                <div class="col"><input placeholder="username" type="text" name="username"
                                        value="{{ $user->username }}" id="username" class="form-control"></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4"><strong>Email</strong></div>
                                <div class="col"><input placeholder="Email xx@xx.com" type="text" name="email"
                                        id="email" value="{{ $user->email }}" class="form-control"></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4"><strong>Number</strong></div>
                                <div class="col"><input placeholder="Whatsapp number [628xxx]" type="text"
                                        name="number" id="number" value="{{ $user->number }}" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4"><strong>Password</strong></div>
                                <div class="col"><input type="password" name="password" id="password"
                                        placeholder="(Enter if want to changed)" class="form-control"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary" type="submit">Edit Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('#number').on('input', function() {
                if (this.value.startsWith('08')) {
                    this.value = "628";
                }
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
            $("#formEdit").submit((e) => {
                e.preventDefault();
                var frm = new FormData(document.getElementById("formEdit"));
                $.ajax({
                    url: "{{ URL::route('settings.edit') }}",
                    method: "POST",
                    data: frm,
                    contentType: false,
                    processData: false,
                    success: (success) => {
                        Swal.fire({
                            title: 'Edit Success',
                            icon: 'success'
                        }).then(r => {
                            window.location = `{{ route('dashboard') }}`
                        })
                    }
                })
            })
        })
    </script>
@endsection
