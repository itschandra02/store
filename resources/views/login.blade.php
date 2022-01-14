@extends('layouts.layout')
@section('title')
    Login
@endsection
@section('top-scripts')
    <style>
        .login-panel {
            display: none;
        }

        .login-panel.active {
            display: block;
        }

        .forgot-panel {
            display: none;
        }

        .forgot-panel.active {
            display: block;
        }

    </style>
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card bg-dark shadow-lg login-panel active">
                    <div class="card-header">
                        <h3 class="card-title text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="frmLogin">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="username"><i class="far fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="username" id="username" name="username">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="password"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" placeholder="password"
                                        aria-label="password" aria-describedby="password" id="password" name="password">
                                </div>
                                <small class="text-muted">Lupa password? <a href="javascript:void(0);"
                                        onclick="toForget();">Klik
                                        disini</a></small>
                            </div>
                            <div class="g-recaptcha" data-sitekey="{{ setting('captcha_sitekey') }}"></div>
                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </button>
                            </div>
                            <div class="text-end">
                                <small class=" text-muted">
                                    <i>Belum punya akun? <a href="{{ route('register') }}">daftar
                                            disini</a></i>
                                </small>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-12">
                                <div class="text-center">Atau login dengan</div>
                            </div>
                            <div class="col-6 mt-3 mb-3">
                                <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-primary"><i
                                        class="fab fa-facebook"></i> Facebook</a>
                            </div>
                            <div class="col-6 mt-3 mb-3">
                                <a href="{{ route('social.oauth', 'google') }}" class="btn btn-danger"><i
                                        class="fab fa-google"></i> Google</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card bg-dark shadow-lg forgot-panel">
                    <div class="card-header">
                        <i onclick="toForget();" type="button" class="fas fa-arrow-left float-start mt-2"></i>
                        <h3 class="card-title text-center">Lupa Password</h3>
                    </div>
                    <div class="card-body">
                        <form id="frmForgot">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="username"><i class="far fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="username" id="username" name="username">
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Submit
                                </button>
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
            $("#frmLogin").submit(function(e) {
                e.preventDefault();
                login();
            })
            $("#frmForgot").submit(function(e) {
                e.preventDefault();
                forgotPass()
            })
        })

        function login() {
            let data = {
                'username': $("#frmLogin input[name='username']").val(),
                'password': $("input[name='password']").val(),
                captcha_response: $("#g-recaptcha-response").val()
            };
            $.ajax({
                url: `{{ route('login.auth.verification') }}`,
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: (r) => {
                    if (r.success) {
                        window.location = "{{ route('index') }}"
                    } else {
                        window.location = "{{ route('login') }}"
                    }
                }
            })
        }

        function forgotPass() {
            let data = {
                username: $("#frmForgot input[name='username']").val(),
            }
            $.ajax({
                url: `{{ route('login.auth.forgot') }}`,
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: (r) => {
                    if (r.success) {
                        Swal.fire({
                            title: 'Lupa Password',
                            text: r.message,
                            icon: 'success'
                        })
                    }
                }
            })
        }

        function toForget() {
            if ($(".login-panel").hasClass('active')) {
                $(".login-panel").toggle("slide", function() {
                    $(".login-panel").removeClass('active');
                })
                $(".forgot-panel").toggle("slide", function() {
                    $('.forgot-panel').addClass('active');
                })
            } else if ($('.forgot-panel').hasClass('active')) {

                $(".forgot-panel").toggle("slide", function() {
                    $(".forgot-panel").removeClass('active');
                })
                $(".login-panel").toggle("slide", function() {
                    $('.login-panel').addClass('active');
                })
            }
        }
    </script>
    {{-- // Login with otp
        function login() {
            let data = {
                'username': $("input[name='username']").val()
            };
            $.ajax({
                url: "{{ URL::to('login/check') }}",
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: (r) => {
                    if (r.success) {
                        Swal.fire({
                            title: 'Input OTP',
                            text: r.message,
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            confirmButtonText: 'Login',
                            showCancelButton: true,
                            inputPlaceholder: 'Input OTP From Whatsapp',
                            allowOutsideClick: () => !Swal.isLoading(),
                            preConfirm: verif
                        })
                    } else {
                        Swal.fire({
                            title: r.message,
                            icon: 'error'
                        })
                    }
                }
            })
        }

        function verif(otp) {
            let data = {
                username: $("input[name='username']").val(),
                otp: otp
            }
            $.ajax({
                url: "{{ URL::to('login/verification') }}",
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: (r) => {
                    if (r.success) {
                        window.location = "{{ URL::to('/') }}"
                    } else {
                        window.location = "{{ URL::to('login') }}"
                    }
                }
            })
        } --}}
@endsection
