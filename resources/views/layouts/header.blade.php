@section('header')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="theme-color" content="#2d3238">
        <meta name="title" content="{{ settings('app_name') }}">
        @yield('metatag')
        <meta name="description" content="{{ settings('description') }}">
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if (setting()->get('favicon'))
            <link rel="icon" href="{{ setting('favicon') }}?v=2">
        @endif

        @if (Route::getCurrentRoute() && Route::getCurrentRoute()->uri() != '/')
            <title>@yield('title') - {{ setting('app_name') }}</title>
        @else
            <title>{{ setting('app_name') }}</title>
        @endif
        <link rel="stylesheet" href="{{ mix('assets/scss/app.css') }}">
        <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('assets/scss/chatbox.css') }}">

        <script src="{{ mix('assets/js/app.js') }}"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <style>
            #searchProds {
                width: 60px;
                transition: width .5s ease
            }

            #searchProds:focus {
                width: 240px
            }

        </style>
        <script>
            $(document).ready(function() {

                $(".search_input").focusout(function() {
                    setTimeout(() => {
                        $(this).parent().dropdown("hide");
                    }, 300);
                    let $parent = $(this).parent(".mini").parent().parent().parent().parent();
                    setTimeout(() => {
                        $parent.find(".form-check").fadeIn(50);
                    }, 300);
                    $parent.parent().parent().find(".navbar-toggler").toggle("slide:left");
                });
                $(".search_input").focusin(function() {
                    let $parent = $(this).parent(".mini").parent().parent().parent().parent();
                    $parent.find(".form-check").fadeOut(50);
                    $parent.parent().parent().find(".navbar-toggler").toggle("slide:left");

                });
                $(".search_input").keyup(function(e) {
                    console.log(e.currentTarget)
                    if (e.keyCode == 13) {
                        $(this).parent().parent().submit();
                    }
                    var search = $(this).val();
                    $.ajax({
                        url: "{{ route('api.search') }}",
                        type: "POST",
                        data: {
                            q: search,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                $(e.currentTarget).parent().dropdown("show");
                                console.log($(e.currentTarget).parent());
                                $(e.currentTarget).parent().siblings("#dropDownSearchResults").html(
                                    "")
                                let _results = [];
                                var sorted = {};
                                for (var i = 0, max = data.length; i < max; i++) {
                                    if (sorted[data[i].category] == undefined) {
                                        sorted[data[i].category] = [];
                                    }
                                    sorted[data[i].category].push(data[i]);
                                }
                                for (category in sorted) {
                                    _results.push(
                                        `<li><span class="dropdown-item-text"><b>${category.toUpperCase()}</b></span></li>`
                                    );
                                    sorted[category].forEach(element => {
                                        _results.push(`
                                            <li><a class="dropdown-item" href="{{ route('order_page', ':slug') }}">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img src="${element.thumbnail}" alt="" class="img-fluid">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <b>${ element.name}</b>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small>${ element.subtitle }</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a></li>`
                                            .replace(':slug', element.slug))
                                    })
                                }

                                $(e.currentTarget).parent().siblings("#dropDownSearchResults")
                                    .append(_results
                                        .join(
                                            `<hr class="dropdown-divider">`));
                            } else {
                                $(e.currentTarget).parent().dropdown("hide");
                            }
                        }
                    });
                });
            })
        </script>
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800&display=swap"> --}}
        @yield('top-scripts')

    </head>
@endsection

@section('navbar')
    @php
    $nav = json_decode(
        json_encode([
            [
                'url' => route('index'),
                'icon' => 'fa fa-home',
                'title' => 'Home',
            ],
            [
                'url' => route('status'),
                'icon' => 'fas fa-search',
                'title' => 'Cek Invoice',
            ],
            [
                'url' => route('harga'),
                'icon' => 'fas fa-clipboard-list',
                'title' => 'Daftar Harga',
            ],
        ]),
        false,
    );
    @endphp
    <header class="mb-5">
        <nav class="navbar navbar-expand-lg fixed-top  navbar-dark bg-dark shadow ">
            <div class="container">
                <div class="d-flex">
                    <span class="w-100 d-lg-none d-block">
                        <!-- hidden spacer to center brand on mobile -->
                    </span>
                    <a class="navbar-brand d-none d-lg-inline-block" href="{{ route('index') }}">
                        @if (setting()->get('logo'))
                            <img src="{{ setting('logo') }}" alt="LOGO" height="40px" class="bi me-2">
                        @endif
                        {{ setting('app_name') }}
                    </a>
                    <a class="navbar-brand mx-auto d-lg-none d-inline-block" href="{{ route('index') }}">
                        {{-- <img src="//placehold.it/40?text=LOGO" alt="logo"> --}}
                        @if (setting()->get('logo'))
                            <img src="{{ setting('logo') }}" alt="LOGO" height="40px" class="bi me-2">
                        @else
                            {{ setting('app_name') }}
                        @endif
                    </a>
                </div>
                <div class="d-flex">
                    <div class="form-check float-start form-switch ms-auto mt-3 me-3">
                        <label class="form-check-label ms-3" for="lightSwitch">
                        </label>
                        <input class="form-check-input" type="checkbox" id="lightSwitch" />
                    </div>
                    <div class="d-lg-none d-block dropdown">
                        <form action="{{ route('search') }}" method="get">
                            <div class="input-group me-3 search-bar mini" aria-haspopup="true" id="dropsearchdown">
                                <input type="text" name="q" placeholder="Search products..." id="searchProds"
                                    class="form-control search_input" autocomplete="off">

                                <button type="submit" class="btn btn-success" id="btnSearchProds">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-dark position-absolute shadow navbar-nav-scroll"
                                aria-labelledby="dropsearchdown" id="dropDownSearchResults">
                            </ul>
                        </form>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                    aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-right" id="navbarTogglerDemo03">
                    <ul class="navbar-nav ms-auto nav-stacked">
                        @foreach ($nav as $item)
                            <li class="nav-item">
                                <a href="{{ $item->url }}"
                                    class="nav-link {{ Route::getCurrentRoute() && Route::getCurrentRoute()->uri() == $item->url ? 'active' : '' }}">
                                    <i class="{{ $item->icon }}"></i>
                                    {{ $item->title }}</a>
                            </li>
                        @endforeach

                        @if (Session::has('loggedIn'))
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navUser" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    {{-- <img class="avatar avatar-16 rounded-circle" src="{{$user->avatar}}" /> --}}
                                    <span id="header_username"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark shadow mb-2" aria-labelledby="navUser">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                                class="fas fa-home"></i> Dashboard</a></li>
                                    <li><a href="{{ route('settings') }}" class="dropdown-item"><i
                                                class="fas fa-user-edit"></i> Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('topup') }}" id="header_saldo">Saldo</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                                class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item pe-md-2 dropdown d-lg-inline-block d-none">
                            <form action="{{ route('search') }}" method="get">
                                <div class="input-group me-3 search-bar" aria-haspopup="true" id="dropsearchdown">
                                    <input type="text" name="q" placeholder="Search products..." id="searchProds"
                                        class="form-control search_input" autocomplete="off">

                                    <button type="submit" class="btn btn-success" id="btnSearchProds">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-dark position-absolute shadow navbar-nav-scroll"
                                    aria-labelledby="dropsearchdown" id="dropDownSearchResults">
                                </ul>
                            </form>
                        </li>
                    </ul>
                    <div class="d-flex my-2">
                        @if (!Session::has('loggedIn'))
                            <a class="btn btn-primary" href="{{ URL::route('login') }}"><i
                                    class="fas fa-sign-in-alt"></i>
                                Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
@endsection
