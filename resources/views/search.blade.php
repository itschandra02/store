@extends('layouts.layout')

@section('title')
    Search products
@endsection
@section('body')
    @php
    $products = DB::table('products')
        ->select('*')
        ->orderBy('ordered')
        ->where('name', 'like', '%' . request()->get('q') . '%')
        ->orWhere('name', 'like', '%' . request()->get('q') . '%')
        ->orWhere('name', 'like', '%' . request()->get('q') . '%')
        ->get();
    @endphp
    <div class="container">
        <div class="row ">
            <div class="col-lg-12">
                <div class="row mb-4 ">
                    <div class="col-lg-9 mx-auto mt-4">
                        <h5>Hasil Pencarian: {{ request()->get('q') }}</h5>
                        <div class="strip-primary"></div>
                        <div class="float-end">
                            <form id="searchForm">
                                <div class="input-group me-3">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" name="q" id="searchInput" class="form-control"
                                        placeHolder="Cari disini...">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-9 mx-auto mt-4">
                        <div class="row row-cols-3 row-cols-md-5 g-4" id="searchResults">

                            {{-- foreach data product --}}
                            @foreach ($products as $item)
                                @if ($item->active)

                                    <div class="col">
                                        <div class="card bg-dark shadow h-100 rounded">

                                            <a href="{{ route('order_page', $item->slug) }}" class="stretched-link">
                                                <img src="{{ $item->thumbnail }}" class="card-img-top"
                                                    alt="{{ $item->slug }}-icon">
                                            </a>
                                            <div class="card-body text-center">
                                                <small class="text-sm">{{ $item->name }}</small>
                                                <br>
                                                <small class="text-sm text-muted">{{ $item->subtitle }}</small>
                                                {{-- <h5 class="card-title">{{ $item->name }}</h5>
                                                <p class="card-text ">{{ $item->subtitle }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#searchInput').keyup(function() {
                $('#searchResults').html('');
                for (let index = 0; index < 5; index++) {
                    $("#searchResults").append(`<div class="col">
                                <div class="card bg-dark shadow h-100 rounded" aria-hidden="true">
                                    <svg class="bd-placeholder-img card-img-top" xmlns="http://www.w3.org/2000/svg"
                                        role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice"
                                        focusable="false">
                                        <title>Placeholder</title>
                                        <rect width="100%" height="100%" fill="#868e96"></rect>
                                    </svg>
                                    <p class="card-text placeholder-glow p-1">
                                        <span class="placeholder col-6"></span>
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-4"></span>
                                        <span class="placeholder col-4"></span>
                                    </p>
                                </div>
                            </div>`)

                }
                setTimeout(() => {
                    $('#searchResults').html('');
                    $.ajax({
                        url: `{{ route('api.search') }}`,
                        type: 'post',
                        data: {
                            'q': $('#searchInput').val()
                        },
                        success: function(data) {
                            $("#searchResults").html("");
                            if (data.length > 0) {
                                data.forEach(element => {
                                    let _html = `<div class="col">
                                        <div class="card bg-dark shadow h-100 rounded">

                                            <a href="{{ route('order_page', ':slug') }}" class="stretched-link">
                                                <img src=":thumbnail" class="card-img-top"
                                                    alt=":slug-icon">
                                            </a>
                                            <div class="card-body text-center">
                                                <small class="text-sm">:name</small>
                                                <br>
                                                <small class="text-sm text-muted">:subtitle</small>
                                            </div>
                                        </div>
                                    </div>`.replace(':slug', element.slug)
                                        .replace(':name', element.name)
                                        .replace(':subtitle', element.subtitle)
                                        .replace(':thumbnail', element
                                            .thumbnail);
                                    $('#searchResults').append(_html);
                                })
                            } else {
                                //show not found
                                $('#searchResults').html(
                                    '<div class="col-12"><h3 class="text-center">Product not found</h3></div>'
                                );
                            }
                        }
                    });
                }, 500);
            });
        });
    </script>
@endsection
