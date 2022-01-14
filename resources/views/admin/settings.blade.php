@extends('admin.layouts.layout')
@section('title')
    Settings
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-lg-12">
            @include('app_settings::_settings')
        </div>
    </div>
@endsection
