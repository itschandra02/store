@extends('layouts.layout')
@section('body')
    @if ($carousels->count() != 0)
        {{-- Mobile --}}
        <div class="row d-lg-none d-inline-block m-0 w-100">
            <div class="col-lg-9 mx-auto p-0">
                <div class="carousel slide shadow" id="carousels_promo" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($carousels as $item)
                            @if ($item->active)
                                <button type="button" data-bs-target="#carousels_promo"
                                    data-bs-slide-to="{{ $loop->index }}" class="active" aria-current="true"
                                    aria-label="Slide {{ $loop->index + 1 }}"></button>
                            @endif
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($carousels as $item)
                            @if ($item->active)
                                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                    <a href="{{ $item->link == '' ? '#' : $item->link }}">
                                        <img src="{{ $item->img }}" alt="" class="d-block w-100">
                                    </a>
                                    {{-- <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $item->title }}</h5>
                                        <p>{{ $item->description }}</p>
                                    </div> --}}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carousels_promo"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousels_promo"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

    @endif
    <div class="container">
        {{-- Desktop --}}
        @if ($carousels->count() != 0)
            <div class="row d-none d-lg-block">
                <div class="col-lg-9 mx-auto">
                    <div class="carousel slide shadow" id="carousels_promo-d" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($carousels as $item)
                                @if ($item->active)
                                    <button type="button" data-bs-target="#carousels_promo-d"
                                        data-bs-slide-to="{{ $loop->index }}" class="active" aria-current="true"
                                        aria-label="Slide {{ $loop->index + 1 }}"></button>
                                @endif
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($carousels as $item)
                                @if ($item->active)
                                    <div class="carousel-item{{ $loop->index == 0 ? ' active' : '' }}">
                                        <a href="{{ $item->link == '' ? '#' : $item->link }}">
                                            <img src="{{ $item->img }}" alt="" class="d-block w-100">
                                        </a>
                                        {{-- <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $item->title }}</h5>
                                            <p>{{ $item->description }}</p>
                                        </div> --}}
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carousels_promo-d"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousels_promo-d"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if ($categories->count() != 0)
            @foreach ($categories as $category)
                @if ($category->active)
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="row mb-4 ">
                                <div class="col-lg-9 mx-auto mt-4">
                                    <h5>{{ $category->title }}</h5>
                                    <div class="strip-primary"></div>
                                </div>
                                <div class="col-lg-9 mx-auto mt-4">
                                    <div class="row row-cols-3 row-cols-md-5 g-4 justify-content-center">

                                        {{-- foreach data product --}}
                                        @foreach ($products as $item)
                                            @if ($item->active)
                                                @if ($item->category == $category->name)

                                                    <div class="col">
                                                        <div class="card bg-dark shadow h-100 rounded">

                                                            <a href="{{ route('order_page', $item->slug) }}"
                                                                class="stretched-link">
                                                                <img src="{{ $item->thumbnail }}" class="card-img-top"
                                                                    alt="{{ $item->slug }}-icon">
                                                            </a>
                                                            <div class="card-body text-center">
                                                                {{-- <small class="text-sm">{{ $item->name }}</small>
                                                                <br>
                                                                <small
                                                                    class="text-sm text-muted">{{ $item->sold }} Terjual</small> --}}
                                                                <small
                                                                    class="text-sm">{{ $item->name }}</small><br>
                                                                <small
                                                                    class="text-sm text-muted">{{ $item->subtitle }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            @endforeach
        @endif
        <div class="row ">
            <div class="col-lg-12">
                <div class="row mb-4 ">
                    <div class="col-lg-9 mx-auto mt-4">
                        <h5>Daftar Layanan</h5>
                        <div class="strip-primary"></div>
                    </div>
                    <div class="col-lg-9 mx-auto mt-4">
                        <div class="row row-cols-3 row-cols-md-5 g-4 justify-content-center">

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
