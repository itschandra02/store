@section('header')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ setting('description') }}">
        <meta name="author" content="{{ setting('company_name') }}">

        @if (setting()->get('favicon'))
            <link rel="icon" href="{{ setting('favicon') }}?v=2">
        @endif
        @if (Route::getCurrentRoute()->uri() != URL::route('admin'))
            <title>@yield('title') - {{ setting('app_name') }}</title>
        @else
            <title>{{ setting('app_name') }}</title>
        @endif
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('assets/admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}"
            rel="stylesheet">
        <link href="{{ asset('assets/admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}"
            rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/admin/assets/plugins/dropify/dist/css/dropify.min.css') }}">
        <!-- xeditable css -->
        {{-- <link
            href="{{ asset('assets/admin/assets/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}"
            rel="stylesheet" /> --}}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet"
            href="https://combinatronics.com/Talv/x-editable/develop/dist/bootstrap4-editable/css/bootstrap-editable.css">
        <link rel="stylesheet"
            href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css">
        <link rel="stylesheet"
            href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/group-by-v2/bootstrap-table-group-by.css">
        {{-- <link rel="stylesheet" href="{{ URL::to('assets/admin/assets/plugins/sweetalert/sweetalert.css') }}"> --}}
        <!-- Custom CSS -->
        <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('assets/scss/chatbox.css') }}">
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('assets/admin/css/colors/blue.css') }}" id="theme" rel="stylesheet">
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-avatar@latest/dist/avatar.min.css" rel="stylesheet">

        <!-- include toastr css and js -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/chat-style.css') }}">
        <style>
            .floating-chat .chat .footer-chat {
                flex-shrink: 0;
                display: flex;
                padding-top: 10px;
                max-height: 90px;
                background: transparent;
                left: 0px;
                position: absolute;
                bottom: 0;
                right: 0;
                padding: 17px 15px;
            }

            .floating-chat .chat .footer-chat .text-box {
                border-radius: 3px;
                background: rgba(25, 147, 147, 0.2);
                min-height: 100%;
                width: 100%;
                margin-right: 5px;
                color: #0EC879;
                overflow-y: auto;
                padding: 2px 5px;
            }

        </style>
        @yield("top-scripts")
    </head>
@endsection
