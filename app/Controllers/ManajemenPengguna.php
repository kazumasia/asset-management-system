<?php

// Controller ManajemenPengguna.php
namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;

class ManajemenPengguna extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Menggunakan model yang disediakan MythAuth
        $this->userModel = new UserModel();
    }

    // Menampilkan daftar pengguna
    public function index()
    {
        // Mengambil semua pengguna dari database
        $users = $this->userModel->findAll();
        return view('admin/user_list', ['users' => $users]);
    }

    // Menampilkan form untuk membuat akun baru
    public function create()
    {
        return view('admin/user_create');
    }

    // Menyimpan akun baru
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
        ]);

        if ($this->validate($validation->getRules())) {
            $user = new \Myth\Auth\Entities\User();  // Buat objek User baru
            $user->email = $this->request->getPost('email');
            $user->username = $this->request->getPost('username');
            $user->password = $this->request->getPost('password');
            $user->activate();  // Aktifkan akun setelah dibuat

            if ($this->userModel->save($user)) {
                return redirect()->to('/admin/manajemenpengguna')->with('success', 'Pengguna berhasil dibuat');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat pengguna');
            }
        } else {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }
    }


    // Menampilkan form untuk mengedit akun pengguna
    public function edit($id)
    {
        $user = $this->userModel->find($id); // Mengambil objek pengguna
        if ($user) {
            return view('admin/user_edit', ['user' => $user]); // Kirim objek ke view
        }
        return redirect()->to('/admin/manajemenpengguna')->with('error', 'Pengguna tidak ditemukan');
    }


    // Memperbarui akun pengguna
    public function update($id)
    {
        // Validasi input form
        if (
            !$this->validate([
                'username' => 'permit_empty|min_length[3]|max_length[20]', // Validasi username
                'password' => 'permit_empty|min_length[8]', // Validasi password
            ])
        ) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // Cari pengguna berdasarkan ID
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/manajemenpengguna')->with('error', 'Pengguna tidak ditemukan');
        }

        // Menyimpan perubahan yang valid
        $dataToUpdate = [];

        // Jika ada input username yang valid, update username
        if ($username = $this->request->getPost('username')) {
            $dataToUpdate['username'] = $username;
        }

        // Jika ada input password yang valid, update password
        if ($password = $this->request->getPost('password')) {
            // Hash password baru
            $dataToUpdate['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Pastikan ada data untuk diperbarui
        if (empty($dataToUpdate)) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada perubahan data.');
        }

        // Perbarui record menggunakan metode update() dan kirimkan data yang telah diubah
        if ($this->userModel->update($id, $dataToUpdate)) {
            return redirect()->to('/admin/manajemenpengguna')->with('success', 'Pengguna berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui pengguna');
        }
    }


    // Menghapus akun pengguna
    public function delete($id)
    {
        // Hapus akun dengan MythAuth model
        $this->userModel->delete($id);
        return redirect()->to('/admin/manajemenpengguna')->with('success', 'User deleted successfully');
    }
}
