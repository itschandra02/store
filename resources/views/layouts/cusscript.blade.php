@section('cusscript')
    {{-- <script src="/socket.io/socket.io.js" type="text/javascript"> --}}
    </script>
    {{-- <script src=":9090/socket.io/socket.io.js"></script> --}}
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
        integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous">
    </script>
    @if (Session::has('loggedIn'))
        {{-- <script src="{{ URL::to('assets/js/chatApp.js') }}"></script>
        <script>
            // console.log(window.userdata)

            // var socket = io(`{{ setting('autoapi') }}`, {
            //     cors: {
            //         origin: "{{ setting('autoapi') }}",
            //         // credentials: true,
            //     },
            //     // transports: ["websocket", "polling"] // use WebSocket first, if available
            // });
            var socket = null;
            console.log(chatBoxApp)
            const username = "{{ Session::get('username') }}";
            const toUser = "admin";
            socket.on('connect', () => {
                var user = "{{ Session::get('userid') }}"
                socket.emit('user-join', {
                    userid: user,
                    username: "{{ Session::get('username') }}",
                    type: `user`,
                    avatar: "{{ Session::get('avatar') }}",
                })
            })
            socket.on('current-user', (data) => {
                let isAdmin = data.find((value, index) => value.type === 'admin');
                if (localStorage.getItem('msg-' + username)) {
                    let _msgs = JSON.parse(localStorage.getItem('msg-' + username));
                    console.log('localstorage', _msgs)
                    if (_msgs) {
                        _msgs.forEach(value => {
                            if (value.username != "{{ Session::get('username') }}") {
                                var messagesContainer = $('.messages');
                                // if (!chatBoxApp.hasClass('expand')) {
                                //     chatBoxApp.addClass('expand');
                                //     openElement();
                                // }
                                messagesContainer.append([
                                    '<li class="self">',
                                    value.message,
                                    '</li>'
                                ].join(''));
                                messagesContainer.finish().animate({
                                    scrollTop: messagesContainer.prop("scrollHeight")
                                }, 250);
                            } else {
                                var messagesContainer = $('.messages');
                                // if (!chatBoxApp.hasClass('expand')) {
                                //     chatBoxApp.addClass('expand');
                                //     openElement();
                                // }
                                messagesContainer.append([
                                    '<li class="other">',
                                    value.message,
                                    '</li>'
                                ].join(''));
                                messagesContainer.finish().animate({
                                    scrollTop: messagesContainer.prop("scrollHeight")
                                }, 250);
                            }
                        })
                    }
                }
                if (isAdmin) {
                    chatBoxApp.addClass('enter');
                } else {
                    chatBoxApp.removeClass('expand');
                    chatBoxApp.removeClass('enter');
                    var messagesContainer = $('.messages');
                    messagesContainer.html('')
                }
            })
            socket.on('new-message', (data) => {
                console.log(data);
                if (data.username != username && data.to == username) {

                    if (localStorage.length == 0) {
                        if (localStorage.getItem('msg-' + username) == '') {
                            let _data = []
                            localStorage.setItem('msg-' + username, JSON.stringify(_data));
                        }
                    } else {
                        if (localStorage.getItem('msg-' + username) == '') {
                            let _data = []
                            localStorage.setItem('msg-' + username, JSON.stringify(_data));
                        }
                    }
                    if (localStorage.getItem('msg-' + username) != '') {
                        let _data = JSON.parse(localStorage.getItem('msg-' + username));
                        _data.push(data);
                        localStorage.setItem('msg-' + username, JSON.stringify(_data))
                        console.log(_data);
                    }

                    var messagesContainer = $('.messages');
                    if (!chatBoxApp.hasClass('expand')) {
                        chatBoxApp.addClass('expand');
                        openElement();
                    }
                    messagesContainer.append([
                        '<li class="self">',
                        data.message,
                        '</li>'
                    ].join(''));
                    messagesContainer.finish().animate({
                        scrollTop: messagesContainer.prop("scrollHeight")
                    }, 250);
                }
            })
            // socket.on('admin-active', (data) => {
            //     console.log(data);
            //     if (data.length >= 0) {
            //         chatBoxApp.addClass('enter');
            //         const toUser = data;
            //     } else {
            //         chatBoxApp.removeClass('enter');
            //     }
            // })
            // socket.on('user-join', (data) => {
            //     chatBoxApp.addClass('enter');
            // })
            // socket.on('admin-left', (data) => {
            //     chatBoxApp.removeClass('enter');
            // })
            // socket.on('chat-message', (data) => {
            //     console.log(data);
            //     if (data.user != username && data.to == username) {
            //         var messagesContainer = $('.messages');
            //         messagesContainer.append([
            //             '<li class="self">',
            //             data.message,
            //             '</li>'
            //         ].join(''));
            //     }
            // })

            function sendNewMessage() {
                var userInput = $('.text-box');
                var newMessage = userInput.html().replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(
                    /\n/g, '<br>');

                if (!newMessage) return;

                var messagesContainer = $('.messages');
                messagesContainer.append([
                    '<li class="other">',
                    newMessage,
                    '</li>'
                ].join(''));
                let data = {
                    time: (new Date()).getTime(),
                    username: username,
                    to: toUser,
                    message: newMessage
                };

                if (localStorage.length == 0) {
                    if (localStorage.getItem('msg-' + username) == '' || localStorage.getItem('msg-' + username) == null) {
                        let _data = []
                        localStorage.setItem('msg-' + username, JSON.stringify(_data));
                    }
                } else {
                    if (localStorage.getItem('msg-' + username) == '' || localStorage.getItem('msg-' + username) == null) {
                        let _data = []
                        localStorage.setItem('msg-' + username, JSON.stringify(_data));
                    }
                }
                if (localStorage.getItem('msg-' + username) != '') {
                    let _data = JSON.parse(localStorage.getItem('msg-' + username));
                    _data.push(data);
                    localStorage.setItem('msg-' + username, JSON.stringify(_data))
                    console.log(_data);
                }
                socket.emit('new-message', data);
                console.log(data);
                // clean out old message
                userInput.html('');
                // focus on input
                userInput.focus();
                messagesContainer.finish().animate({
                    scrollTop: messagesContainer.prop("scrollHeight")
                }, 250);
            }
        </script> --}}
    @endif
@endsection
