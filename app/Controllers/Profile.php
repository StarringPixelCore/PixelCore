<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Profile extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data['user'] = $userModel->find(session()->get('user_id'));

        return view('user_profile', $data);
    }

    public function uploadPicture()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $file = $this->request->getFile('profile_pic');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $newName = $file->getRandomName();
            $file->move('writable/uploads/profile/', $newName);

            \Config\Services::image()
                ->withFile('writable/uploads/profile/' . $newName)
                ->fit(300, 300)
                ->save('writable/uploads/profile/' . $newName);

            $userModel = new UserModel();
            $userModel->update(session()->get('user_id'), [
                'profile_picture' => $newName
            ]);
        }

        return redirect()->to('/profile')->with('message', 'Profile updated!');
    }
}
