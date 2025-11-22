<?php
namespace App\Controllers;

class Users extends BaseController {
    
    /**
     * Check if user is logged in and has ITSO PERSONNEL role
     */
    private function checkAccess() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ITSO PERSONNEL.');
            return redirect()->to('/dashboard');
        }
        
        return null;
    }

    public function index($perpage = 5){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $usersModel = model('UserModel');
        $usersModel->orderBy('lastname');
        $queryResult = $usersModel->paginate($perpage);

        $data = array(
            'title' => 'Users List',
            'users' => $queryResult,
            'pager' => $usersModel->pager,
            'active' => 'users'
        );

        return view('users/view_users', $data);
    }

    public function add(){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        helper('form'); // Added this for set_value() to work in view_add.php 
        $data = [
            'title' => 'Add New Users',
            'active' => 'users'
        ];
        
        return view('users/view_add', $data);
    }

    public function insert(){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $validation = service('validation');
        $usersModel = model('UserModel');

        $data = array(
            'id_number' => $this->request->getPost('id_number'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'confirmpassword' => $this->request->getPost('confirmpassword'),
            'role' => $this->request->getPost('role')
        );

        if(! $validation->run($data, 'signup')){
            // If validation fails, reload the signup form
            $data['title'] = 'Add New Users';

            $this->session->setFlashdata('errors', $validation->getErrors());

            return redirect()->to('users/add');
        }

        $user = array(
            'id_number' => $data['id_number'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'],
            'profile_picture' => 'default.jpg',
            'verify_token' => bin2hex(random_bytes(16)),
            'is_verified' => 0
        );

        $usersModel->insert($user);
        $this->session->setFlashdata('success', 'Successfully added a new user account.');

        // Set email contents 

        return redirect()->to('users');
    }

    public function verify($token) {
        $usersModel = model('UserModel');

        $usersModel->where('verify_token', $token);
        $user = $usersModel->first();

        if ($user) {
            $usersModel->update($user['id'], ['is_verified' => 1]);
            $this->session->setFlashdata('success', 'Your account has been verified successfully!');
            return redirect()->to('/login');
        }

        // If token is invalid
        $this->session->setFlashdata('errors', ['Invalid verification token.']);
        return redirect()->to('/login');
    }

    public function view($id){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $usersModel = model('UserModel');
        $user = $usersModel->find($id);

        if (!$user) {
            $this->session->setFlashdata('error', 'User not found.');
            return redirect()->to('users');
        }

        $data = array(
            'title' => 'View User Account',
            'user' => $user,
            'active' => 'users'
        );

        return view('users/view_user', $data);
    }

    public function edit($id){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $usersModel = model('UserModel');
        $user = $usersModel->find($id);

        if (!$user) {
            $this->session->setFlashdata('error', 'User not found.');
            return redirect()->to('users');
        }

        helper('form');
        $data = array(
            'title' => 'Edit User Account',
            'user' => $user,
            'active' => 'users'
        );

        return view('users/view_edit', $data);
    }

    public function update($id) {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $validation = service('validation');
        $usersModel = model('UserModel');
        $existingUser = $usersModel->find($id);

        if (!$existingUser) {
            $this->session->setFlashdata('error', 'User not found.');
            return redirect()->to('users');
        }

        $data = array(
            'id_number' => $this->request->getPost('id_number'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        );

        if(! $validation->run($data, 'editAccount')){
            // If validation fails, reload the edit form
            $data['title'] = 'Edit User Account';
            $data['user'] = $existingUser;

            $this->session->setFlashdata('errors', $validation->getErrors());

            return redirect()->to('users/edit/' . $id);
        }

        // Remove password if left empty (so it won't overwrite)
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            // Hash the password before updating
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $usersModel->update($id, $data);
        $this->session->setFlashdata('success', 'Successfully updated the user account.');

        return redirect()->to('users');
    }

    public function delete($id){
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $usersModel = model('UserModel');
        $user = $usersModel->find($id);

        if (!$user) {
            $this->session->setFlashdata('error', 'User not found.');
            return redirect()->to('users');
        }

        $usersModel->delete($id);
        $this->session->setFlashdata('success', 'Successfully deleted the user account.');
        return redirect()->to('users');
    }
}

?>
