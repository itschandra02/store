@include('admin.layouts.header')
@include('admin.layouts.body')
@include('admin.layouts.footer')
@include('admin.layouts.cusscript')
<!DOCTYPE html>
<html lang="en">
@yield('header')

<body class="fix-header card-no-border">

    @yield('body')
    @yield('footer')

    <div class="chatbox-holder">

    </div>

    @yield('cusscript')
</body>

</html>
