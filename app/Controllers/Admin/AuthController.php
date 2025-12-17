<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Halaman login admin
     */
    public function login()
    {
        // ✅ Kalau sudah login admin, langsung ke dashboard
        if (session()->get('is_admin')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login');
    }

    /**
     * Proses login admin
     */
    public function loginProcess()
    {
        $userModel = new UserModel();

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak ditemukan.');
        }

        // ⚠️ Password admin belum di-hash (sesuai kondisi kamu)
        if ($password !== $user['password']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah.');
        }

        // ❌ Bukan admin → tolak
        if ($user['role'] !== 'Admin') {
            return redirect()->back()
                ->with('error', 'Akses ditolak. Ini bukan akun admin.');
        }

        // ✅ SET SESSION ADMIN (KUNCI UTAMA)
        session()->set([
            'is_admin'  => true,
            'admin_id'  => $user['id'],
            'admin_name'=> $user['username'] ?? $user['email']
        ]);

        // ✅ Masuk dashboard admin
        return redirect()->to('/admin/dashboard');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->remove([
            'is_admin',
            'admin_id',
            'admin_name'
        ]);

        return redirect()->to('/admin/login')
            ->with('success', 'Berhasil logout');
    }
}
