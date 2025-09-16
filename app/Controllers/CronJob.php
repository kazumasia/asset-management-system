<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AssetMaintenanceModel;
use App\Models\NotificationModel;

class CronJob extends Controller
{
    public function sendMaintenanceReminders()
    {
        $maintenanceModel = new AssetMaintenanceModel();
        $notifModel = new NotificationModel();

        $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

        $upcomingMaintenance = $maintenanceModel
            ->where('jadwal_pemeliharaan <=', $sevenDaysLater)
            ->where('status', 'Dijadwalkan')
            ->findAll();

        foreach ($upcomingMaintenance as $maintenance) {
            $notifModel->insert([
                'user_id' => 1, // ID Admin/teknisi
                'message' => "Reminder: Pemeliharaan aset ID {$maintenance['asset_id']} dijadwalkan pada {$maintenance['jadwal_pemeliharaan']}",
                'status' => 'unread',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        echo "Notifikasi pengingat dikirim.";
    }
}
