var express = require('express')();
var fs = require('fs');

var options = {
    key: fs.readFileSync(__dirname + '/file.pem'),
    cert: fs.readFileSync(__dirname + '/file.crt')
};
// var server = require('https').Server(express, options);
var https = require('https');
var server = https.createServer({
    key: fs.readFileSync(__dirname + '/file.pem'),
    cert: fs.readFileSync(__dirname + '/file.crt'),
    requestCert: false,
    rejectUnauthorized: false
}, express);

var io = require('socket.io')(server, {
    cors: {
        origin: '*'
    }
});

var sockets = []
io.on('connection', function (socket) {
    sockets.push({
        id: socket.id,
        type: '',
        username: '',
        avatar: '',
    });
    socket.on('user-join', function (data) {
        let a = sockets.find((value, index) => value.id === socket.id)
        a.type = data.type;
        a.username = data.username;
        a.avatar = data.avatar;
        io.emit('current-user', sockets);
        console.log(sockets)
    })
    socket.on('disconnect', () => {
        let _id = socket.id;
        sockets.splice(sockets.findIndex(value => value.id === _id), 1);
        io.emit('current-user', sockets);
        console.log('disconnected', socket.id)
    })
    socket.on('new-message', (data) => {
        console.log(data);
        socket.broadcast.emit('new-message', data);
    })
})


// var sockets = [];
// var users = [];
// var ids = [];
// var chats = [];
// io.on('connection', function (socket) {

//     sockets.push(socket);
//     console.log(socket.id)
//     socket.on("user-join", function (data) {
//         if (data.type == 'admin') {
//             ids.push(socket.id)
//         } else {
//             users.push(socket.id)
//         }
//         console.log(data)
//         let _data = data;
//         _data.admins = ids.length;
//         _data.users = users.length;
//         io.emit('user-join', data);
//         io.emit('admin-active', _data);
//         io.emit('user-active', users);
//     })
//     socket.on('disconnect', () => {
//         console.log("got disconnect")
//         let _id = ids.indexOf(socket.id);
//         if (_id) {
//             ids.splice(_id, 1)
//             io.emit('admin-left', ids)
//         }
//         let _user = users.indexOf(socket.id);
//         if (_user) {
//             users.splice(_user, 1)
//             io.emit('user-left', users)
//         }
//         var i = sockets.indexOf(socket);
//         sockets.splice(i, 1);
//         console.log(ids)
//     })
//     socket.on('chat-message', (data) => {
//         console.log(data);
//         io.emit('chat-message', data);
//     })
// });



server.listen(9090, function () {
    console.log("Socket.io server listen at 9090");
});