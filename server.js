const http = require('http');
const socketIo = require('socket.io');
const express = require('express');

const app = express();
app.use(express.json()); // Untuk membaca body JSON

// Buat HTTP server
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

// Tangkap koneksi socket
io.on("connection", (socket) => {
    console.log("User connected: " + socket.id);

    // Menerima notifikasi pemeliharaan dari PHP
    socket.on("maintenance-reminder", (data) => {
        console.log("Notifikasi Pemeliharaan: ", data);
        io.emit("maintenance-reminder", data); // Kirim ke semua user
    });
});

// Endpoint untuk menerima notifikasi dari PHP
app.post('/send-notification', (req, res) => {
    const data = req.body;
    io.emit('receive-notification', data); // Kirim notifikasi ke semua client
    console.log('Notification sent:', data);
    res.status(200).send('Notification sent');
});

// Jalankan Express server di port 3001
app.listen(3001, () => {
    console.log('Express server running on port 3001');
});

// Jalankan Socket.IO server di port 3000
server.listen(3000, () => {
    console.log('Socket.IO server running on port 3000');
});
