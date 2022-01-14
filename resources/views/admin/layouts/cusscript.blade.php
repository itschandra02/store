@section('cusscript')
    {{-- <script src=":9090/socket.io/socket.io.js"></script> --}}
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js"
        integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous">
    </script>
    @if (Session::has('isAdminLogged'))
        {{-- <script>
            var socket = null;
            // var socket = io(`{{ setting('autoapi') }}`, {
            //     cors: {
            //         origin: "{{ setting('autoapi') }}",
            //         // credentials: true,
            //     },
            //     // transports: ["websocket", "polling"] // use WebSocket first, if available
            // });
            socket.on("connect", () => {
                socket.emit('user-join', {
                    userid: '',
                    username: "{{ Session::get('admin')['username'] }}",
                    type: 'admin',
                    avatar: "{{ Session::get('admin')['profile_pic'] }}"
                })
            })

            socket.on('current-user', (data) => {
                let users = data.filter((value) => value.type === 'user');
                if (users.length > 0) {
                    console.log(users);
                    users.forEach(user => {
                        console.log($('.chatbox').length)
                        if ($('.chatbox').length > 0) {
                            $('.chatbox').each(function() {
                                let chatData = $(this).data('user');
                                if (chatData.username != user.username) {
                                    newUsers(user)
                                } else {
                                    $(this).data('user').id = user.id
                                }
                                console.log($(this).data('user'))
                            })
                        } else {
                            newUsers(user)
                        }
                        if (localStorage.getItem('aMsg-' + user.username)) {
                            let _msgs = JSON.parse(localStorage.getItem('aMsg-' + user.username));
                            console.log('localstorage', _msgs)
                            if (_msgs) {
                                _msgs.forEach(value => {
                                    if (value.username != "{{ Session::get('admin')['username'] }}") {
                                        newMessage(value)
                                    } else {
                                        let chatbox;
                                        $('.chatbox').each(function() {
                                            if ($(this).data('user').username == user
                                                .username) {
                                                chatbox = $(this);
                                            }
                                        })
                                        let msgContainer = chatbox.children(
                                            '.chat-messages');
                                        let $msgHolder = $("<div>", {
                                            class: 'message-box-holder'
                                        })
                                        let $msgBox = $('<div>', {
                                            class: 'message-box',
                                            html: value.message
                                        }).appendTo($msgHolder);
                                        $msgHolder.appendTo(msgContainer);
                                        msgContainer.finish().animate({
                                            scrollTop: msgContainer.prop('scrollHeight')
                                        }, 250);
                                    }
                                })
                            }
                        }
                    });
                }

                $('.chatbox').each(function() {
                    let a = $(this).data('user').username;
                    if ($.inArray(a, users.map(va => va.username)) == -1) {
                        $(this).remove()
                    } else {

                    }
                })
            })

            socket.on('new-message', (data) => {
                console.log(data);
                newMessage(data);
                if (localStorage.length == 0) {
                    let _data = []
                    localStorage.setItem('aMsg-' + data.username, JSON.stringify(_data));
                }
                let _data = JSON.parse(localStorage.getItem('aMsg-' + data.username));
                _data.push(data);
                localStorage.setItem('aMsg-' + data.username, JSON.stringify(_data))
            })

            function newMessage(data) {
                let chatbox;
                $('.chatbox').each(function() {
                    if ($(this).data('user').username == data.username) {
                        chatbox = $(this);
                    }
                })
                if (chatbox.hasClass('chatbox-min')) {
                    chatbox.removeClass('chatbox-min')
                }
                let msgContainer = chatbox.children('.chat-messages');
                let $msgHolder = $("<div>", {
                    class: 'message-box-holder'
                })
                let $msgName = $('<div>', {
                    class: 'message-sender',
                    html: data.username
                }).appendTo($msgHolder);
                let $msgBox = $('<div>', {
                    class: 'message-box message-partner',
                    html: data.message
                }).appendTo($msgHolder);
                $msgHolder.appendTo(msgContainer);

                msgContainer.finish().animate({
                    scrollTop: msgContainer.prop('scrollHeight')
                }, 250);
                console.log(msgContainer)
            }

            function newUsers(data) {
                let $chatBox = $('<div>', {
                    class: 'chatbox chatbox-min',
                });
                $chatBox.data('user', data);
                $chatBox.appendTo(".chatbox-holder");
                // top bar
                let $chatBoxTop = $('<div>', {
                    class: 'chatbox-top'
                }).appendTo($chatBox);
                let $chatBoxAvatar = $('<div>', {
                    class: 'chatbox-avatar'
                }).html(`<img src="${data.avatar}">`).appendTo($chatBoxTop);
                let $chatBoxName = $('<div>', {
                    class: 'chat-partner-name',
                }).html(`<span class="status online"></span> ${data.username}`).appendTo($chatBoxTop);
                let $chatBoxIcons = $('<div>', {
                    class: 'chatbox-icons'
                }).html(`<a href="javascript:void(0);"><i class="fa fa-minus"></i></a>
                    <a href="javascript:void(0);"><i class="fa fa-close"></i></a>`).appendTo($chatBoxTop);

                $('.fa-minus').click(function() {
                    $(this).closest('.chatbox').toggleClass('chatbox-min');
                });
                $('.fa-close').click(function() {
                    $(this).closest('.chatbox').hide();
                });
                // messages
                let $chatMessages = $("<div>", {
                    class: 'chat-messages'
                }).appendTo($chatBox);

                // bottom
                let $chatInput = $('<div>', {
                    class: 'chat-input-holder'
                }).html(
                    `<textarea class="chat-input"></textarea>`
                );
                let $btnSend = $('<button>', {
                    class: 'message-send'
                }).html(`<i class="fa fa-send " ></i>`).click(sendNewMessage).appendTo($chatInput);
                $chatInput.appendTo($chatBox);
            }

            function sendNewMessage(el) {
                let dataUser = $(el.target).closest('.chatbox').data('user');
                let userInput = $(el.target).closest('.chat-input-holder').children('textarea.chat-input');
                var newMessage = userInput.val().replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(
                    /\n/g, '<br>');
                console.log(newMessage);
                if (!newMessage) return;
                let msgContainer = $(el.target).closest('.chatbox').children('.chat-messages');
                let $msgHolder = $("<div>", {
                    class: 'message-box-holder'
                })
                let $msgBox = $('<div>', {
                    class: 'message-box',
                    html: newMessage
                }).appendTo($msgHolder);
                $msgHolder.appendTo(msgContainer);
                let data = {
                    time: (new Date()).getTime(),
                    username: "{{ Session::get('admin')['username'] }}",
                    to: dataUser.username,
                    message: newMessage
                }
                socket.emit('new-message', data);

                if (localStorage.length == 0) {
                    if (localStorage.getItem('aMsg-' + dataUser.username) == '' || localStorage.getItem('msg-' + dataUser
                            .username) == null) {
                        let _data = []
                        localStorage.setItem('aMsg-' + dataUser.username, JSON.stringify(_data));
                    }
                } else {
                    if (localStorage.getItem('aMsg-' + dataUser.username) == '' || localStorage.getItem('msg-' + dataUser
                            .username) == null) {
                        let _data = []
                        localStorage.setItem('aMsg-' + dataUser.username, JSON.stringify(_data));
                    }
                }
                if (localStorage.getItem('aMsg-' + dataUser.username) != '') {
                    let _data = JSON.parse(localStorage.getItem('aMsg-' + dataUser.username));
                    _data.push(data);
                    localStorage.setItem('aMsg-' + dataUser.username, JSON.stringify(_data))
                    console.log(_data);
                }
                msgContainer.finish().animate({
                    scrollTop: msgContainer.prop('scrollHeight')
                }, 250);
                userInput.val('')
                // var userInput = $('.text-box');
                // var newMessage = userInput.html().replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').trim().replace(
                //     /\n/g, '<br>');

                // if (!newMessage) return;

                // var messagesContainer = $('.messages');
                // messagesContainer.append([
                //     '<li class="other">',
                //     newMessage,
                //     '</li>'
                // ].join(''));
                // let data = {
                //     time: (new Date()).getTime(),
                //     user: username,
                //     to: toUser,
                //     message: newMessage
                // };
                // socket.emit('chat-message', data);
                // console.log(data);
                // // clean out old message
                // userInput.html('');
                // // focus on input
                // userInput.focus();
                // messagesContainer.finish().animate({
                //     scrollTop: messagesContainer.prop("scrollHeight")
                // }, 250);
            }
        </script> --}}
    @endif
@endsection
