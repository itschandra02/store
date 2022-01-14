@extends('layouts.layout')
@section('title')
    Data Deletion
@endsection
@section('body')
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-lg-7 mx-auto mt-5">
                <div class="card shadow bg-dark">
                    <div class="card-body">
                        <div class="row">
                            @if ($success)
                                <span class="avatar avatar-64 rounded-circle mx-auto"><i
                                        class="far fa-check-circle"></i></span>
                                <div class="col-12 text-center">
                                    <span class="h1">Congratulations!</span>
                                    <p>This account has been deleted!</p>
                                    <p>The user that login with <i>{{ $data->provider }}</i> in this site. Has been
                                        deleted
                                        on {{ $data->created_at }}</p>
                                </div>
                            @else
                                <span class="avatar avatar-64 rounded-circle mx-auto">
                                    <i class="far fa-question-circle"></i>
                                </span>
                                <div class="col-12 text-center">
                                    <span class="h1">Not Found!</span>
                                    <p>The deleted user that you find is not found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
