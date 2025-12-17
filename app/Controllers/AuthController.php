<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasswordResetModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function loginProcess()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Email atau password salah!');
        }

        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'user_role' => $user['role']
        ]);

        if ($user['role'] === 'Admin') {
            return redirect()->to('/admin/dashboard');
                } else {
            return redirect()->to('/');
        }

    }

    public function register()
    {
        return view('auth/register', ['title' => 'Register']);
    }

    public function registerProcess()
    {
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if ($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Password dan konfirmasi tidak sama.');
        }

        $userModel = new UserModel();

        // cek email sudah terdaftar
        if ($userModel->where('email', $this->request->getPost('email'))->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar.');
        }
        
        $userModel = new UserModel();

        $userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'Customer'
        ]);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat 👍');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // --------------------------
    // FORGOT PASSWORD
    // --------------------------
    public function forgotPassword()
    {
        return view('auth/forgot_password', ['title' => 'Forgot Password']);
    }

     public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        $userModel = new UserModel();
        $resetModel = new PasswordResetModel();

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.')->withInput();
        }

        // generate token
        $token = bin2hex(random_bytes(32));

        // simpan token
        $resetModel->save([
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Langsung redirect ke halaman reset password
        return redirect()->to("/reset-password/{$token}")
                         ->with('success', 'Token reset password berhasil dibuat. Silakan buat password baru.');
    }

    // RESET PASSWORD FORM
    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak ditemukan.');
        }

        $resetModel = new PasswordResetModel();
        $data = $resetModel->where('token', $token)->first();

        if (!$data) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid.');
        }

        // cek token expired (10 menit = 600 detik)
        if (strtotime($data['created_at']) < time() - 600) {
            $resetModel->delete($data['id']);
            return redirect()->to('/forgot-password')->with('error', 'Token sudah kedaluwarsa.');
        }

        return view('auth/reset_password', [
            'title' => 'Reset Password',
            'token' => $token
        ]);
    }

    // PROCESS RESET PASSWORD
    public function processResetPassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if ($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Password dan konfirmasi tidak sama.');
        }

        $resetModel = new PasswordResetModel();
        $userModel = new UserModel();

        $data = $resetModel->where('token', $token)->first();

        if (!$data) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid!');
        }

        // update password user
        $userModel->where('email', $data['email'])
                  ->set(['password' => password_hash($password, PASSWORD_DEFAULT)])
                  ->update();

        // hapus token
        $resetModel->delete($data['id']);

        return redirect()->to('/login')->with('success', 'Password berhasil direset! Silakan login.');
    }
}