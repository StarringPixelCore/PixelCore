<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\EmailService;

class Auth extends BaseController
{
    // Show login page
    public function login()
    {
        return view('view_login');
    }

    // Process login form
    public function loginPost()
    {
        $session = session();
        $validation = service('validation');
        $userModel = new UserModel();

        // Get form data
        $data = [
            'id_number' => $this->request->getPost('id_number'),
            'password' => $this->request->getPost('password')
        ];

        // Validate using the 'login' rules - pass $data, not $user!
        if (!$validation->run($data, 'login')) {
            // Validation failed
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Validation passed, get the user
        $user = $userModel->where('id_number', $data['id_number'])->first();
        
        // User is valid, set session
        $session->set([
            'user_id' => $user['id'],
            'id_number' => $user['id_number'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'role' => $user['role'],
            'profile_picture' => $user['profile_picture'],
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard');
    }

    // Show register page
    public function register()
    {
        return view('view_register');
    }

    
    public function registerPost()
    {
        helper('form');
        $validation = service('validation');
        $userModel = new UserModel();

        $data = [
            'id_number' => $this->request->getPost('id_number'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'confirmpassword' => $this->request->getPost('confirmpassword'),
            'role'      => 'USER'
        ];

        if(! $validation->run($data, 'signup')){
            $data['title'] = 'Sign Up';
            $this->session->setFlashdata('errors', $validation->getErrors());

            return redirect()->to('/register');
        }

        $user = [
            'id_number'       => $data['id_number'],
            'firstname'       => $data['firstname'],
            'lastname'        => $data['lastname'],
            'email'           => $data['email'],
            'password'        => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'            => 'USER', // default role for public sign ups
            'profile_picture' => 'default.jpg',
            'verify_token'    => bin2hex(random_bytes(16)),
            'is_verified'     => 0,
            'reset_token'     => null,
            'reset_token_expires_at' => null
        ];

        $userModel->insert($user);

        $emailService = new EmailService();
        $emailService->sendVerificationEmail($user);

        $this->session->setFlashdata('success', 'Successfully created your account! Please check your email to verify your account.');
        return redirect()->to('/login');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        return view('view_forgot_password');
    }

    // For handling forgot password form submission
    public function forgotPasswordPost()
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiry

            $userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_token_expires_at' => $expiresAt
            ]);

            $emailService = new EmailService();
            $emailService->sendPasswordResetEmail($user, $token);
        }

        return redirect()->back()->with('success', 'Successfully sent a reset link to your email address.');
    }

    // For showing reset password form
    public function resetPassword($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user || empty($user['reset_token_expires_at']) || strtotime($user['reset_token_expires_at']) < time()) {
            return redirect()->to('/forgot-password')->with('error', 'The reset link is invalid or has expired.');
        }

        return view('view_reset_password', ['token' => $token]);
    }

    // For handling reset password form submission
    public function resetPasswordPost($token)
    {
        $validation = service('validation');

        if (! $validation->run($this->request->getPost(), 'resetPassword')) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user || empty($user['reset_token_expires_at']) || strtotime($user['reset_token_expires_at']) < time()) {
            return redirect()->to('/forgot-password')->with('error', 'The reset link is invalid or has expired.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->to('/login')->with('success', 'Your password has been reset. You can now log in.');
    }

    // For profile view

   public function profile()
   {
    if (!session()->has('user_id')) {
        return redirect()->to('/login');
    }

    $userModel = new UserModel();
    $user = $userModel->find(session()->get('user_id'));

    if (!empty($user['profile_picture']) &&
        file_exists(FCPATH . "public/uploads/profile/" . $user['profile_picture'])) {

        $profilePicUrl = "public/uploads/profile/" . $user['profile_picture'];
    } else {
        $profilePicUrl = "public/uploads/profile/default.jpg";
    }

    return view('view_profile', [
        'user' => $user,
        'profilePicUrl' => $profilePicUrl,
        'active' => 'profile'
    ]);
}

    // For updating profile picture

    public function updatePicture()
    {
    $userId = session()->get('user_id');
    $userModel = new UserModel();

    $file = $this->request->getFile('profile_picture');

    if ($file->isValid() && !$file->hasMoved()) {

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'public/uploads/profile/';  

        
        $file->move($uploadPath, $newName);

       
        \Config\Services::image()
            ->withFile($uploadPath . $newName)
            ->fit(300, 300, 'center')
            ->save($uploadPath . $newName);

        // Update DB
        $userModel->update($userId, [
            'profile_picture' => $newName
        ]);
    }

    return redirect()->to('/profile');
}

    // For deleting profile picture

    public function removePicture()
        {
        $userId = session()->get('user_id');
        $userModel = new UserModel();

        $user = $userModel->find($userId);
        $oldPic = $user['profile_picture'];

       
        $uploadPath = FCPATH . "public/uploads/profile/";

        if (!empty($oldPic) && $oldPic !== 'default.jpg') {
            if (file_exists($uploadPath . $oldPic)) {
                unlink($uploadPath . $oldPic);  
            }
        }

        $userModel->update($userId, [
            'profile_picture' => 'default.jpg'
        ]);

        return redirect()->to('/profile')->with('success', 'Profile picture removed.');
    }


    // For changing password in profile center

    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $current = $this->request->getPost('current_password');
        $new = $this->request->getPost('new_password');
        $confirm = $this->request->getPost('confirm_password');

        if (!password_verify($current, $user['password'])) {
            return redirect()->back()->with('error', 'Current password incorrect.');
        }

        if ($new !== $confirm) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $userModel->update($userId, [
            'password' => password_hash($new, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }


}
