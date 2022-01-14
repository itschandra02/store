@extends('layouts.layout')
@section('title')
    Cek invoice
@endsection
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mb-5">
                <div class="card bg-dark shadow">
                    <div class="card-header">
                        <h5>Cek invoice</h5>
                    </div>
                    <div class="card-body">
                        Invoice Number:
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                            <input type="number" name="invnum" id="invnum" class="form-control" placeholder="9534xxxxxx">
                        </div>
                        <button class="btn btn-primary mt-3 float-end" onclick="checkk();">Check</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function checkk() {
            let value = $("#invnum").val();
            window.location.href = `{{ route('invoice', '') }}/${value}`;
        }
    </script>
@endsection
