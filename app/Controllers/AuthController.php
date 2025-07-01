<?php

namespace App\Controllers;

require_once ROOTPATH . 'vendor/autoload.php';

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;
use Google_Client;
use Google_Service_Oauth2;

class AuthController extends BaseController
{
    protected $user;
    function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function googleLogin()
    {
        $client = $this->getGoogleClient();
        return redirect()->to($client->createAuthUrl());
    }

    public function googleCallback()
    {
        $client = $this->getGoogleClient();

        if ($this->request->getGet('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
            $client->setAccessToken($token['access_token']);

            $oauth = new \Google_Service_Oauth2($client);
            $user = $oauth->userinfo->get();
            $existingUser = $this->user->where('email', $user->email)->first();

            if (!$existingUser) {
                // Simpan ke database
                $this->user->insert([
                    'username'   => explode('@', $user->email)[0],
                    'email'      => $user->email,
                    'password'   => password_hash('google123', PASSWORD_DEFAULT), // password dummy
                    'role'       => 'member', // bisa diganti ke 'user' sesuai kebutuhan
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                // Ambil data user yang baru ditambahkan
                $existingUser = $this->user->where('email', $user->email)->first();
            }

            // Simpan user ke session (atau DB kalau perlu)
            session()->set([
                'isLoggedIn' => true,
                'username'  => $user->email,
                'nama'      => $user->name,
                'foto'      => $user->picture,
                'role'       => 'user'
            ]);

            return redirect()->to(base_url('/'));
        }

        return redirect()->to('login')->with('failed', 'Login gagal.');
    }

    private function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId('8655619638-eubh8udubg9mfa5pcnkms0hjcen5o47j.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri(base_url('auth/google-callback'));
        $client->addScope('email');
        $client->addScope('profile');
        return $client;
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];
            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        session()->set([
                            'username' => $dataUser['username'],
                            'role'     => $dataUser['role'], // 'admin' atau 'member'
                            'isLoggedIn' => true
                        ]);

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
