// var app = require('express')()
//   , httpApp = require('express')()
//   , fs = require('fs')  
//   , https = require('https')
//   , options = {
// 	    key: fs.readFileSync('/etc/nginx/ssl/example.local/server.key'),
//     	cert: fs.readFileSync('/etc/nginx/ssl/example.local/server.crt')
// 	};

// app.use((req, res, next) => {
//     res.header("Access-Control-Allow-Origin", "https://example.local");
//     res.header("Access-Control-Allow-Credentials", "true");
//     res.header("Access-Control-Allow-Headers", "X-Requested-With");
//     res.header("Access-Control-Allow-Headers", "Content-Type");
//     res.header("Access-Control-Allow-Methods", "PUT, GET, POST, DELETE, OPTIONS");
//     next();
// });

// var server = https.createServer(options,app).listen(3000, () => console.log("start on : 3000" ));
// var io = require('socket.io').listen(server);

// httpApp.get('*',(req,res) => res.redirect('https://127.0.0.1:3000'+req.url));

// var Redis = require('ioredis');
// var redis = new Redis();

// redis.psubscribe('*',(err, count) => {});

// redis.on('pmessage', (subscribed, channel, data) => {
//    	console.log('Channel: ' + channel);
//     console.log('Subscribed To: ' + subscribed);
//     console.log('Message Recieved: ' + data);
//     console.log('###############################################:');
//    	data = JSON.parse(data);
//     io.emit(channel + ':' + data.event, data.data);
// });


// 'use strict';
// var app = require('express')();
// var server = require('http').Server(app);
// var io = require('socket.io')(server);
// require('dotenv').config();

// var redisPort = process.env.REDIS_PORT;
// var redisHost = process.env.REDIS_HOST;
// var ioRedis = require('ioredis');
// var redis = new ioRedis(redisPort, redisHost);
// redis.subscribe('action-channel-one');
// redis.on('message', function (channel, message) {
//   message  = JSON.parse(message);
//   io.emit(channel + ':' + message.event, message.data);
// });

// var broadcastPort = process.env.BROADCAST_PORT;
// server.listen(broadcastPort, function () {
//   console.log('Socket server is running.');
// });