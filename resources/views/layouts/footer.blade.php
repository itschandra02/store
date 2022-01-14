@section('footer')
    @php
    $nav = [
        [
            'url' => '/',
            'icon' => 'fa fa-home',
            'title' => 'Utama',
        ],
        [
            'url' => '/harga',
            'icon' => 'fas fa-clipboard-list',
            'title' => 'Daftar Harga',
        ],
        [
            'url' => '/contact-us',
            'icon' => 'fas fa-address-card',
            'title' => 'Contact us',
        ],
    ];
    if (!session()->has('loggedIn')) {
        array_push(
            $nav,
            (object) [
                'url' => '/login',
                'icon' => '',
                'title' => 'Login',
            ],
        );
        array_push(
            $nav,
            (object) [
                'url' => '/register',
                'icon' => '',
                'title' => 'Register',
            ],
        );
    } else {
        array_push(
            $nav,
            (object) [
                'url' => '/dashboard',
                'icon' => '',
                'title' => 'Dashboard',
            ],
        );
        array_push(
            $nav,
            (object) [
                'url' => '/topup',
                'icon' => '',
                'title' => 'Topup',
            ],
        );
    }
    $products = DB::table('products')
        ->select('*')
        ->limit(5)
        ->get();
    $nav = json_decode(json_encode($nav), false);
    @endphp

    <footer class="footer mt-auto border-dark bg-dark shadow-lg">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-6">
                    @if (setting()->get('logo'))
                        <img src="{{ setting('logo') }}" alt="LOGO" style="float:left;margin-left:2%;height:40px;
                                                            width:40px; " class="bi me-2">
                    @endif
                    <h5 class="text-uppercase mt-2" style="margin:0">{{ setting('app_name') }}</h5>
                    <div class="mt-2">
                        <p>{{ setting('description') }}</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h5 class="mt-2">Menu</h5>
                    <div class="mt-2">
                        <ul class="nav flex-column">
                            @foreach ($nav as $item)
                                <li class="nav-item">
                                    <a href="{{ $item->url }}"
                                        class="nav-link text-white {{ Route::getCurrentRoute() && Route::getCurrentRoute()->uri() == $item->url ? 'active' : '' }}">
                                        <i class="fas fa-angle-right text-primary"></i>
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <h5 class="mt-2">Layanan lainnya</h5>
                    <div class="mt-2">
                        <ul class="nav flex-column">
                            @foreach ($products as $item)
                                @if ($item->active)
                                    <li class="nav-item">
                                        <a href="{{ route('order_page', $item->slug) }}" class="nav-link text-white">
                                            <i class="fas fa-angle-right text-primary"></i>
                                            {{ $item->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-2">
            <div class="row" id="footer-credit" style="background:#181b1f">
                <div class="col">
                    <div class="container mt-2 mb-2 text-center">
                        <small>
                            Copyright &copy; 2021 by <a href="/" class="text-white">{{ settings('company_name') }}</a>
                            - <a href="{{ route('terms') }}" class="text-white">Terms and
                                conditions</a>
                            - <a href="{{ route('privacy_policy') }}" class="text-white">Privacy Policy</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    @if (Session::has('flash'))
        <script>
            $(document).ready(() => {
                let flash = JSON.parse(@json(Session::get('flash')));
                if (flash.type == 'success') {
                    toastr.success(flash.text, flash.title);
                } else if (flash.type == 'error') {
                    toastr.error(flash.text, flash.title);
                }
                console.log(flash);
            })
        </script>
    @endif
    @if (Session::has('loggedIn'))
        <script async>
            $.getJSON("{{ route('user') }}", (r) => {
                window.userdata = r;
                $("#header_username").text(userdata.username);
                $("#header_saldo").html('<i class="fas fa-wallet"></i>  Rp.' + parseInt(userdata.balance)
                    .toLocaleString());
            })
        </script>
    @endif

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('assets/plugins/bootstrap-table/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('assets/js/switch.js') }}"></script>
    @yield('scripts')

@endsection
