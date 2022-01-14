<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
@include('layouts.footer')
@include('layouts.cusscript')
@yield('header')
<style>
    .wave {
        min-height: 100%;
        background-attachment: scroll;
        background-image: url("{{ asset('assets/img/wave.svg') }}");
        background-repeat: no-repeat;
        background-position: bottom left, bottom right;
    }

    .wave2 {
        min-height: 100%;
        background-attachment: fixed;
        background-image: url("{{ asset('assets/img/wave2.svg') }}");
        background-repeat: no-repeat;
        background-position: top left, top right;
    }

</style>

<body style="background-color: #2d3238" class="d-flex flex-column min-vh-100  text-white">
    @yield('navbar')

    <div class="wrapper wave2 pt-4">
        <br>
        @yield('body')

    </div>
    @yield('footer')

    {{-- <div class="floating-chat">
        <i class="fa fa-comments" aria-hidden="true"></i>
        <div class="chat">
            <div class="header">
                <span class="title">
                    Ada yang mau di tanyain bos?
                </span>
                <button>
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

            </div>
            <ul class="messages">

            </ul>
            <div class="footer">
                <div class="text-box" contenteditable="true" disabled="true"></div>
                <button id="sendMessage">send</button>
            </div>
        </div>
    </div> --}}
    @yield('cusscript')
</body>

</html>
