@extends('layouts.layout')
@section('title')
    Lupa Password
@endsection
@section('body')

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card bg-dark shadow">
                    <div class="card-header">
                        <h3 class="card-title text-center">Lupa Password</h3>
                    </div>
                    <div class="card-body">
                        Hai {{ $user->name }}! <br>
                        Silahkan tulis password baru anda!
                        <hr>
                        <form id="frmPassword" class="needs-validation g-3" novalidate method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password baru</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password baru" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password-confirmation" class="form-label">Konfirmasi Password baru</label>
                                <input type="password" name="password-confirmation" id="password-confirmation"
                                    placeholder="Konfirmasi password baru" class="form-control" required>
                            </div>
                            <div class="form-group float-end">
                                <button type="submit" class="btn btn-success">Submit</button>
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
        $(document).ready(function() {
            // $("#frmPassword").submit(function(e) {
            //     e.preventDefault();
            // })
            $("#password-confirmation").keyup(function() {
                if ($(this).val() != $("#password").val()) {
                    $(this).addClass("is-invalid")
                    $(this).removeClass("is-valid")
                } else {
                    $(this).addClass("is-valid")
                    $(this).removeClass("is-invalid")
                }
            })
        })
    </script>
@endsection
