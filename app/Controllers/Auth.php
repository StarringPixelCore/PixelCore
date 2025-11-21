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
            'role'           => 'ITSO Personnel',
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

    //for profile view

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



//profile picture edit

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

//delete profile picture

    public function removePicture()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $currentPic = $user['profile_picture'];

        if ($currentPic !== 'default.jpg') {

            $filePath = FCPATH . "public/uploads/profile/" . $currentPic;

            if (file_exists($filePath)) {
                unlink($filePath); // delete the image file
            }
        }

        $userModel->update($userId, [
            'profile_picture' => 'default.jpg'
        ]);

        return redirect()->to('/profile');
    }


//change password in profile center

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
