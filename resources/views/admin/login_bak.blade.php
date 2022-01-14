<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{URL::to('assets/admin/img/basic/favicon.ico')}}" type="image/x-icon">
    <title>Admin Login - {{setting('app_name')}}</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{URL::to('assets/admin/css/app.css')}}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }

    </style>
    <!-- Js -->
    <!--
    --- Head Part - Use Jquery anywhere at page.
    --- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
    -->
    <script>
        (function(w, d, u) {
            w.readyQ = [];
            w.bindReadyQ = [];

            function p(x, y) {
                if (x == "ready") {
                    w.bindReadyQ.push(y);
                } else {
                    w.readyQ.push(x);
                }
            };
            var a = {
                ready: p,
                bind: p
            };
            w.$ = w.jQuery = function(f) {
                if (f === d || f === u) {
                    return a
                } else {
                    p(f)
                }
            }
        })(window, document)

    </script>
</head>

<body class="light">
    <!-- Pre loader -->
    <div id="loader" class="loader">
        <div class="plane-container">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
        <main>
            <div id="primary" class="p-t-b-100 height-full ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 mx-md-auto">
                            @if (Session::has('login_flash'))
                                <div class="toast"
                                data-title="{{Session::get('login_flash')['title']}}"
                                data-message="{{Session::get('login_flash')['message']}}"
                                data-type="{{Session::get('login_flash')['type']}}">
                                </div>
                            @endif
                            <div class="text-center">
                                <img src="{{URL::to('assets/admin/img/dummy/u5.png')}}" alt="">
                                <h3 class="mt-2">Welcome Back Admin!</h3>
                                {{-- <p class="p-t-b-20">Hey admin welcome back signin now there is lot of new stuff
                                    waiting
                                    for you</p> --}}
                            </div>
                            <form action="{{URL::route('admin.login')}}" method="POST">
                                @csrf
                                <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                    <input name="username" type="text" class="form-control form-control-lg" placeholder="Email Address">
                                </div>
                                <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                    <input name="password" type="password" class="form-control form-control-lg" placeholder="Password">
                                </div>
                                <input type="submit" class="btn btn-success btn-lg btn-block" value="Log In">
                                {{-- <p class="forget-pass">Have you forgot your username or password ?</p> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #primary -->
        </main>
        
        <!-- /.right-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
        <div class="control-sidebar-bg shadow white fixed"></div>
    </div>
    <!--/#app -->
    <script src="{{URL::to('assets/admin/js/app.js')}}"></script>




    <!--
--- Footer Part - Use Jquery anywhere at page.
--- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
-->
    <script>
        (function($, d) {
            $.each(readyQ, function(i, f) {
                $(f)
            });
            $.each(bindReadyQ, function(i, f) {
                $(d).bind("ready", f)
            })
        })(jQuery, document)

    </script>
</body>

</html>
