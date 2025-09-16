<?php

namespace App\Controllers;

use App\Models\AssetUsageModel;
use App\Models\AssetAcquisitionModel;
use App\Models\AssetPlanModel;
use CodeIgniter\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin/calendar');
    }

    // public function getEvents()
    // {
    //     $usageModel = new AssetUsageModel();
    //     $acquisitionModel = new AssetAcquisitionModel();
    //     $planModel = new AssetPlanModel();

    //     $events = [];

    //     // Data Penggunaan Aset
    //     $usages = $usageModel->findAll();
    //     foreach ($usages as $usage) {
    //         $events[] = [
    //             'title' => "Digunakan: " . $usage['pegawai'] . " (" . $usage['status'] . ")",
    //             'start' => $usage['tanggal_mulai'],
    //             'end' => $usage['tanggal_selesai'] ?: $usage['tanggal_mulai'], // Pakai tanggal mulai jika tanggal selesai kosong
    //             'color' => $usage['status'] == 'Dikembalikan' ? '#28a745' : '#ffc107'
    //         ];
    //     }

    //     // Data Akuisisi Aset
    //     $acquisitions = $acquisitionModel->findAll();
    //     foreach ($acquisitions as $acq) {
    //         $events[] = [
    //             'title' => "Akuisisi: " . $acq['nama_aset'] . " (" . $acq['status'] . ")",
    //             'start' => $acq['created_at'],
    //             'end' => $acq['updated_at'], // Akuisisi hanya punya 1 tanggal
    //             'color' => $acq['status'] == 'Disetujui' ? '#007bff' : '#dc3545'
    //         ];
    //     }

    //     // Data Perencanaan Aset (Tambahkan Tanggal Selesai jika Ada)
    //     $plans = $planModel->findAll();
    //     foreach ($plans as $plan) {
    //         $events[] = [
    //             'title' => "Perencanaan: " . $plan['nama_aset'],
    //             'start' => $plan['created_at'],
    //             'end' => !empty($plan['updated_at']) ? $plan['updated_at'] : $plan['created_at'], // Pakai tanggal selesai jika ada
    //             'color' => '#17a2b8',
    //             'description' => !empty($plan['deskripsi']) ? $plan['deskripsi'] : 'Tidak ada deskripsi'
    //         ];
    //     }

    //     return $this->response->setJSON($events);
    // }


    public function getEvents()
    {
        $usageModel = new AssetUsageModel();
        $acquisitionModel = new AssetAcquisitionModel();
        $planModel = new AssetPlanModel();

        $events = [];

        // **Data Penggunaan Aset**
        $usages = $usageModel->findAll();
        foreach ($usages as $usage) {
            $startDate = date('Y-m-d\TH:i:s', strtotime($usage['tanggal_mulai']));
            $endDate = !empty($usage['tanggal_selesai']) ? date('Y-m-d\TH:i:s', strtotime($usage['tanggal_selesai'])) : date('Y-m-d\TH:i:s', strtotime($usage['tanggal_mulai'] . ' +1 hour'));

            $events[] = [
                'title' => "Digunakan: " . $usage['pegawai'] . " (" . $usage['status'] . ")",
                'start' => $startDate,
                'end' => $endDate,
                'allDay' => false,
                'color' => $usage['status'] == 'Dikembalikan' ? '#28a745' : '#ffc107',
                'status' => $usage['status']
            ];
        }

        // **Data Akuisisi Aset**
        $acquisitions = $acquisitionModel->findAll();
        foreach ($acquisitions as $acq) {
            $startDate = date('Y-m-d\TH:i:s', strtotime($acq['created_at']));
            $endDate = !empty($acq['updated_at']) ? date('Y-m-d\TH:i:s', strtotime($acq['updated_at'])) : date('Y-m-d\TH:i:s', strtotime($acq['created_at'] . ' +1 hour'));

            $events[] = [
                'title' => "Akuisisi: " . $acq['nama_aset'] . " (" . $acq['status'] . ")",
                'start' => $startDate,
                'end' => $endDate,
                'allDay' => false,
                'color' => $acq['status'] == 'Disetujui' ? '#007bff' : '#dc3545',
                'status' => $acq['status']
            ];
        }

        // **Data Perencanaan Aset**
        $plans = $planModel->findAll();
        foreach ($plans as $plan) {
            $status = $plan['status'];
            $startDate = date('Y-m-d\TH:i:s', strtotime($plan['created_at']));
            $endDate = !empty($plan['updated_at']) ? date('Y-m-d\TH:i:s', strtotime($plan['updated_at'])) : date('Y-m-d\TH:i:s', strtotime($plan['created_at'] . ' +1 hour'));

            if ($status == 'Draft' || $status == 'Pending Approval') {
                $endDate = date('Y-m-d\TH:i:s', strtotime($startDate . ' +1 hour')); // Pastikan tetap ada durasi waktu
                $title = "Perencanaan: " . $plan['nama_aset'] . " (" . $status . ")";
            } else {
                $title = "Perencanaan: " . $plan['nama_aset'] . " (" . $status . ") - Selesai: " . date('d M Y', strtotime($plan['updated_at']));
            }

            $events[] = [
                'title' => $title,
                'start' => $startDate,
                'end' => $endDate,
                'allDay' => false,
                'color' => $status == 'Selesai' ? '#28a745' : ($status == 'Pending Approval' ? '#ffc107' : '#dc3545'),
                'description' => !empty($plan['deskripsi']) ? $plan['deskripsi'] : 'Tidak ada deskripsi',
                'status' => $status
            ];
        }

        return $this->response->setJSON($events);
    }




}
