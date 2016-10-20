var http = require('http') ;
var fs = require('fs') ;

// Chargement du fichier index.html affiché au client
var server = http.createServer(function(req, res) {
    fs.readFile('./index.html', 'utf-8', function(error, content) {
        res.writeHead(200, {"Content-Type": "text/html"}) ;
        res.end(content) ;
    });
});

// Chargement de socket.io
var io = require('socket.io').listen(server) ;

var listUsers = [] ;

// Quand un client se connecte, on le note dans la console
io.sockets.on('connection', function (socket) {
    // Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
    socket.on('username', function(pseudo) {
        var ID = Math.random().toString(16).slice(5) ;
        listUsers.push({
            "socket" : socket,
            "pseudo" : pseudo,
            "ID": ID
        });
        socket.broadcast.emit('username', pseudo) ;
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('message', function (message) {
        var userIndice = getUser(socket) ;
        socket.broadcast.emit('message', {pseudo: listUsers[userIndice]['pseudo'], message: message}) ;
    });

    socket.on('disconnect', function() {
        var userIndice = getUser(socket) ;
        userPseudo = listUsers[userIndice]['pseudo'] ;
        listUsers.splice(userIndice, 1) ;
        socket.broadcast.emit('dc', userPseudo) ;
    });

});

function getUser(socket) {
    var l = listUsers.length ;
    for (var i=0 ; i<l ; i++) {
        if (listUsers[i]['socket'] == socket) {
            return i ;
        }
    }
    return -1 ;
}

server.listen(8080) ;