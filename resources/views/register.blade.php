@extends('layouts.layout')
@section('title')
    Register
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card bg-dark shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                <input required type="text" name="name" id="name" class="form-control" placeholder="Name"
                                    aria-label="Name" aria-describedby="name" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                                <input required type="text" class="form-control" placeholder="Username"
                                    aria-label="Username" aria-describedby="username" id="username" name="username"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                <input required type="email" class="form-control" placeholder="Email" aria-label="Email"
                                    aria-describedby="email" id="email" name="email" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                <input required type="text" name="number" id="number" class="form-control"
                                    placeholder="Whatsapp number [628xxxxxxx]">
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password" required placeholder="Password"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input required type="checkbox" name="tac" id="tac" class="form-check-input">
                                <label for="tac" class="form-check-label">
                                    <i>
                                        I agree to <a href="{{ route('terms') }}" target="_blank">Terms
                                            and conditions</a>
                                    </i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="g-recaptcha" data-sitekey="{{ setting('captcha_sitekey') }}"></div>
                        <div class="text-end">
                            <button class="btn btn-primary" onclick="check();">
                                <i class="fas fa-sign-in-alt"></i>
                                Register
                            </button>
                        </div>
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
        })

        function check() {
            data = {
                username: $("input[name='username']").val(),
                number: $("input[name='number']").val(),
            };
            console.log(data);
            $.ajax({
                url: "{{ route('register.check') }}",
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: (r) => {
                    Swal.fire('Loading');
                    Swal.showLoading()
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
                            confirmButtonText: 'Register',
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
                name: $("input[name='name']").val(),
                email: $("input[name='email']").val(),
                number: $("input[name='number']").val(),
                otp: otp,
                password: $("input[name='password']").val(),
                captcha_response: $("#g-recaptcha-response").val()
            }
            $.ajax({
                url: "{{ route('register.verification') }}",
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
                        window.location = "{{ route('login') }}"
                    } else {
                        window.location = "{{ route('register') }}"
                    }
                }
            })
        }
    </script>
@endsection
