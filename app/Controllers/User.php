<?php

namespace App\Controllers;

use App\Models\PostModel;

class User extends BaseController
{

    protected $PostModel;
    public function __construct()
    {
        $this->PostModel = new PostModel();
    }
    public function index()
    {
        $PostModel = new PostModel();

        $filteredData = $PostModel->paginate(10, 'laporan');

        $pager = $PostModel->pager;

        $data = [
            'laporan' => $filteredData,
            'pager' => $pager,
        ];

        return view('User/index', $data);
    }


    public function forbiden(): string
    {
        return view('forbiden/index');
    }
    public function wait(): string
    {
        return view('user/wait');
    }
    public function tunggu(): string
    {
        return view('user/tunggu');
    }
    public function pst()
    {
        // Tampilkan halaman "Silahkan Ke PST"
        $data['title'] = 'Silahkan Ke PST';
        return view('pst_page', $data);
    }

    public function ruangtunggu()
    {
        $data['title'] = 'Silahkan Menunggu di Ruang Tunggu';
        return view('ruangtunggu_page', $data);
    }









}
