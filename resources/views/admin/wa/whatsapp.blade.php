@extends('admin.layouts.layout')
@section('title')
    Whatsapp gateway
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    Information
                    @if ($status)
                        <a class="btn btn-danger btn-sm float-right text-white" href="{{ route('wa.logout') }}">Logout</a>
                    @endif
                </div>
                <div class="card-body">
                    @if ($status == false)
                        Status : <span class="text-danger">OFF</span> <br>
                        Silahkan Login ulang
                    @else
                        <div class="row">
                            <div class="col-12 text-center">
                                <figure class="text-center">
                                    <img src="" id="avatarWA" class="rounded-circle avatar avatar-128">
                                </figure>
                            </div>
                            <div class="col">

                                <strong>Status</strong>: <span class="text-success">ON</span> <br>
                                @php
                                    $user = json_decode($data->user);
                                    $auth = json_decode($data->auth);
                                @endphp
                                <dl>
                                    <dt>ID</dt>
                                    <dd>{{ $data->id }}</dd>
                                    <dt>Name</dt>
                                    <dd>{{ $user->name }}</dd>
                                    <dt>Number</dt>
                                    <dd>{{ str_replace('@s.whatsapp.net', '', $user->jid) }}</dd>
                                    <dt></dt>
                                </dl>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if ($status)
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header">Test Whatsapp</div>
                    <div class="card-body">
                        <label for="number">Input number</label>
                        <input type="number" name="number" id="number" class="form-control">
                        <label for="txtMessage">Message</label>
                        <textarea name="txtMessage" id="txtMessage" cols="30" rows="5" class="form-control"></textarea>
                        <button class="btn btn-success" onclick="send()">Send</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header">Whatsapp Notification <div class="spinner-border text-primary"
                            id="spinnerGroup" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="card-body">
                        Select whatsapp group for notification
                        <select name="group" id="group" class="form-control">
                            {{-- @foreach ($groups as $item)
                                <option value="{{ $item['jid'] }}" @if ($item['jid'] == setting('wagroup')) selected @endif>
                                    {{ $item['name'] }}</option>
                            @endforeach --}}
                        </select>
                        <button class="btn btn-primary float-right mt-2" onclick="changeGroup()">Change</button>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="card shadow">
                    <div class="card-header">
                        Setup Whatsapp Gateway
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary" onclick="loginUlang();">
                            <div class="spinner-border text-light spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Login Ulang
                        </button>
                        <div id="qr"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @if ($status)
        <script>
            $(document).ready(function() {

                $("#spinnerGroup").show()
                $.getJSON("{{ route('wa.getcontact') }}", (result) => {
                    $("#spinnerGroup").hide()
                    let gCon = result.data.filter(v => v.jid.endsWith("@g.us"))
                    gCon.forEach(element => {
                        if (element.jid == "{{ setting('wagroup') }}") {
                            let $opt = $("<option>", {
                                value: element.jid,
                                text: element.name
                            }).attr('selected', 'selected')
                            $("#group").append($opt)
                        } else {
                            let $opt = $("<option>", {
                                value: element.jid,
                                text: element.name
                            })
                            $("#group").append($opt)
                        }
                    });
                    $.getJSON("{{ setting('wahost') }}/api/profilepic/{{ $data->id }}", {
                        jid: `{{ $user->jid }}`
                    }, (result) => {
                        $("#avatarWA").attr({
                            src: result.data.url
                        })
                    })

                })
            })

            function changeGroup() {
                $.post("{{ route('wa.event') }}", {
                    type: 'changeGroup',
                    jid: $("#group option:selected").val()
                }, (success) => {
                    Swal.fire("Success", "Success change notification group to " + $("#group option:selected").text(),
                        'success')
                });
            }

            function send() {
                let data = {
                    id: "{{ $status == true ? $data->id : null }}",
                    auth: @json($auth),
                }
                console.log(data)
                $.ajax({
                    url: "{{ setting('wahost') }}/api/create",
                    data: JSON.stringify(data),
                    type: "POST",
                    contentType: "application/json",
                    dataType: 'json',
                    success: (result) => {
                        if (result.success) {
                            $.ajax({
                                url: '{{ setting('wahost') }}/api/sendtext/' + data.id,
                                data: JSON.stringify({
                                    jid: $("input#number").val() + "@s.whatsapp.net",
                                    text: $("#txtMessage").val()
                                }),
                                type: "POST",
                                contentType: "application/json",
                                dataType: 'json',
                            })
                            Swal.fire("Success", "Message has been sent", 'success')
                        } else {
                            Swal.fire("Error", result.message, 'error')
                        }
                    }
                });
            }
        </script>
    @else
        <script>
            $(document).ready(function() {
                $(".spinner-border").hide()
                setInterval(() => {
                    console.log("checking")
                    $.getJSON("{{ route('wa.check') }}", (result) => {
                        if (result.success) {
                            location.reload();
                        }
                    })
                }, 2000);
            })
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#number').on('input', function() {
                if (this.value.startsWith('08')) {
                    this.value = "628";
                }
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
        })


        function loginUlang() {

            $(".spinner-border").show()
            $.post("{{ setting('wahost') }}/api/create", {
                callback: "{{ route('wa.callback') }}",
            }).then((result) => {
                if (result.success) {
                    $(".spinner-border").hide()
                    let emb = $("<div>").attr({
                        class: "embed-responsive embed-responsive-1by1"
                    })
                    let fra = $("<iframe>").attr({
                        src: "{{ setting('wahost') }}/qr?id=" + result.data.id +
                            "&callback={{ route('wa.callback') }}",
                        class: "embed-responsive-item"
                    })
                    emb.html(fra)
                    $("#qr").html(emb);
                }
            }).catch((err) => {

            });
        }
    </script>
@endsection
