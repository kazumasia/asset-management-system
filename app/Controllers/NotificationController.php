<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NotificationModel;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notificationModel = new NotificationModel();

        // Ambil notifikasi terbaru yang belum dibaca
        $notifications = $notificationModel->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON($notifications);
    }

    public function markAsRead($id)
    {
        log_message('debug', "markAsRead() called with ID: $id");

        $notificationModel = new NotificationModel();
        $notif = $notificationModel->find($id);

        if (!$notif) {
            log_message('error', "Notification ID $id not found");
            return $this->response->setJSON(['status' => 'error', 'message' => 'Notifikasi tidak ditemukan.']);
        }

        $notificationModel->update($id, ['status' => 'read']);

        log_message('debug', "Notification ID $id marked as read");

        return $this->response->setJSON(['status' => 'success', 'message' => 'Notifikasi ditandai sebagai dibaca.']);
    }


    public function markAllAsRead()
    {
        log_message('debug', "markAllAsRead() called");

        if (!session()->get('logged_in')) {
            log_message('error', "Akses ditolak: user belum login.");
            return $this->response->setJSON(['status' => 'error', 'message' => 'Anda harus login untuk mengakses ini.']);
        }

        $notificationModel = new NotificationModel();
        $notificationModel->where('status', 'unread')->set(['status' => 'read'])->update();

        log_message('debug', "All notifications marked as read");

        return $this->response->setJSON(['status' => 'success', 'message' => 'Semua notifikasi ditandai sebagai dibaca.']);
    }



    public function addNotification()
    {
        $notificationModel = new NotificationModel();

        $message = $this->request->getPost('message');

        $notificationModel->insert([
            'message' => $message,
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['success' => true]);
    }

}
