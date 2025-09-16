const http = require('http');
const socketIo = require('socket.io');
const express = require('express');

const app = express();
app.use(express.json()); 

const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

io.on("connection", (socket) => {
    console.log("User connected: " + socket.id);

    socket.on("maintenance-reminder", (data) => {
        console.log("Notifikasi Pemeliharaan: ", data);
        io.emit("maintenance-reminder", data); 
    });
});

app.post('/send-notification', (req, res) => {
    const data = req.body;
    io.emit('receive-notification', data); 
    console.log('Notification sent:', data);
    res.status(200).send('Notification sent');
});

app.listen(3001, () => {
    console.log('Express server running on port 3001');
});

server.listen(3000, () => {
    console.log('Socket.IO server running on port 3000');
});
