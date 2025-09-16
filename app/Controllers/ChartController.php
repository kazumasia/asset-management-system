<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Controller;

class ChartController extends Controller
{
    public function getMonthlyStats()
    {
        $postModel = new PostModel();
        $monthlyStats = $postModel->getMonthlyStats();

        return $this->response->setJSON($monthlyStats);
    }
}