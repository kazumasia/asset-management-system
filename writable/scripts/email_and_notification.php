<?php

use Config\Services;

require_once __DIR__ . '/../../vendor/autoload.php';

// Decode data dari parameter
$data = json_decode(base64_decode($argv[1]), true);

// Inisialisasi layanan email
$email = Services::email();

// Kirim email
$email->setFrom('broalok009@gmail.com', 'Sistem Pengaduan');
$email->setTo('gataumales009@gmail.com');
$email->setSubject('Pengaduan Baru');
$email->setMessage("
    <h3>Pengaduan Baru v2</h3>
    <p>Nama: {$data['nama']}</p>
    <p>Deskripsi: {$data['deskripsi']}</p>
");
$email->send();

// Kirim notifikasi realtime
$url = 'http://localhost:3001/send-notification';
$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode(['message' => 'Laporan baru dari: ' . $data['nama']]),
    ],
];
$context = stream_context_create($options);
file_get_contents($url, false, $context);

