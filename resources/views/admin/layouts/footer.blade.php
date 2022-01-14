@section('footer')

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    {{-- <script src="{{ asset('assets/admin/assets/plugins/jquery/jquery.min.js') }}"></script> --}}
    <!-- latest jquery on cdn-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/admin/assets/plugins/bootstrap/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/admin/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/admin/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/admin/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('assets/admin/js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('assets/admin/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/admin/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    {{-- <script type="text/javascript"
        src="{{ URL::to('assets/admin/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js') }}">
    </script> --}}
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script> --}}
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://combinatronics.com/Talv/x-editable/develop/dist/bootstrap4-editable/js/bootstrap-editable.js">
    </script>
    
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/editable/bootstrap-table-editable.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/1.0.5/jquery.tablednd.min.js"
        integrity="sha512-uzT009qnQ625C6M8eTX9pvhFJDn/YTYChW+YTOs9bZrcLN70Nhj82/by6yS9HG5TvjVnZ8yx/GTD+qUKyQ9wwQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/group-by-v2/bootstrap-table-group-by.js"></script>
    {{-- <script src="{{ URL::to('assets/admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script> --}}
    {{-- <script
        src="{{ URL::to('assets/admin/assets/plugins/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.js') }}">
    </script> --}}
    {{-- <script src="{{ URL::to('assets/admin/assets/plugins/sweetalert/sweetalert.min.js') }}"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('scripts')
@endsection
