<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Show login page
    public function login()
    {
        return view('view_login');
    }

    // Process login form
    public function loginPost()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

       
        session()->set('user_id', $user['id']);

        return redirect()->to('/dashboard');
    }


    // Show register page
    public function register()
    {
        return view('view_register');
    }

    
    public function registerPost()
    {
        $userModel = new UserModel();

        $data = [
            'id_number' => $this->request->getPost('id_number'),
            'firstname'       => $this->request->getPost('firstname'),
            'lastname'       => $this->request->getPost('lastname'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => 'Student',
            'profile_picture'=> 'default.png' 
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('message', 'Account created! Please log in.');
    }


    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
