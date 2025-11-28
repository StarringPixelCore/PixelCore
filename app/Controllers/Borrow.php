<?php

namespace App\Controllers;

use App\Models\BorrowModel;
use App\Models\EquipmentModel;
use App\Models\UserModel;
use App\Services\EmailService;

class Borrow extends BaseController
{
    /**
     * Check if user is logged in
     */
    private function checkAccess()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        return null;
    }

    /**
     * Show borrow form for STUDENT and ASSOCIATE
     */
    public function index()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['STUDENT', 'ASSOCIATE'])) {
            session()->setFlashdata('error', 'Access denied. This section is only available for STUDENT and ASSOCIATE.');
            return redirect()->to('/dashboard');
        }

        $equipmentModel = new EquipmentModel();
        $availableEquipment = $equipmentModel->getAvailable();

        $data = [
            'title' => 'Borrow Equipment',
            'availableEquipment' => $availableEquipment,
            'active' => 'borrow'
        ];

        return view('borrow/view_borrow', $data);
    }

    /**
     * Submit borrow request
     */
    public function submit()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['STUDENT', 'ASSOCIATE'])) {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to('/dashboard');
        }

        $validation = service('validation');
        $borrowModel = new BorrowModel();
        $userModel = new UserModel();

        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // Get equipment IDs from form
        $equipmentIds = $this->request->getPost('equipment_id');
        $roomNumber = $this->request->getPost('room_number');
        $borrowDate = $this->request->getPost('borrow_date');
        $borrowTime = $this->request->getPost('borrow_time');

        // Validate equipment_id array separately (CodeIgniter doesn't handle array validation well)
        if (empty($equipmentIds) || !is_array($equipmentIds) || empty(array_filter($equipmentIds))) {
            $errors = ['equipment_id' => 'Please select at least one equipment.'];
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }

        // Prepare data for validation (excluding equipment_id array)
        $data = [
            'room_number' => $roomNumber,
            'borrow_date' => $borrowDate,
            'borrow_time' => $borrowTime
        ];

        // Validate other fields
        if (!$validation->run($data, 'borrowSubmit')) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $equipmentModel = new EquipmentModel();
        $emailService = new EmailService();

        // Create borrow record for each equipment
        foreach ($equipmentIds as $equipmentId) {
            $equipment = $equipmentModel->find($equipmentId);
            
            if (!$equipment || $equipment['status'] !== 'Active' || $equipment['available_count'] <= 0) {
                continue; // Skip unavailable equipment
            }

            $borrowData = [
                'user_id' => $userId,
                'id_number' => $user['id_number'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'equipment_id' => $equipmentId,
                'equipment_name' => $equipment['equipment_name'],
                'room_number' => $roomNumber,
                'borrow_date' => $borrowDate,
                'borrow_time' => $borrowTime,
                'status' => 'Pending'
            ];

            $borrowModel->insert($borrowData);
        }

        // Send email notification
        $emailService->sendBorrowConfirmationEmail($user);

        session()->setFlashdata('success', 'Borrow request submitted successfully! Please check your email for confirmation.');
        return redirect()->to('/borrow');
    }

    /**
     * Mark equipment as received (ITSO only)
     */
    public function received($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to('/dashboard');
        }

        $borrowModel = new BorrowModel();
        $borrow = $borrowModel->find($id);

        if (!$borrow) {
            session()->setFlashdata('error', 'Borrow request not found.');
            return redirect()->to('/borrowed');
        }

        if ($borrow['status'] !== 'Pending') {
            session()->setFlashdata('error', 'This borrow request has already been processed.');
            return redirect()->to('/borrowed');
        }

        // Update borrow status
        $borrowModel->update($id, ['status' => 'Received']);

        // Decrease available count
        $equipmentModel = new EquipmentModel();
        $equipment = $equipmentModel->find($borrow['equipment_id']);
        if ($equipment) {
            $newAvailableCount = max(0, $equipment['available_count'] - 1);
            $equipmentModel->update($borrow['equipment_id'], [
                'available_count' => $newAvailableCount
            ]);
        }

        session()->setFlashdata('success', 'Equipment marked as received. Available count updated.');
        return redirect()->to('/borrowed');
    }

    /**
     * Mark equipment as returned (ITSO only)
     */
    public function returned($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to('/dashboard');
        }

        $borrowModel = new BorrowModel();
        $borrow = $borrowModel->find($id);

        if (!$borrow) {
            session()->setFlashdata('error', 'Borrow request not found.');
            return redirect()->to('/borrowed');
        }

        if ($borrow['status'] !== 'Received') {
            session()->setFlashdata('error', 'Equipment must be received first before it can be returned.');
            return redirect()->to('/borrowed');
        }

        // Update borrow status and set returned date
        $borrowModel->update($id, [
            'status' => 'Returned',
            'returned_at' => date('Y-m-d H:i:s')
        ]);

        // Increase available count
        $equipmentModel = new EquipmentModel();
        $equipment = $equipmentModel->find($borrow['equipment_id']);
        if ($equipment) {
            $newAvailableCount = min($equipment['quantity'], $equipment['available_count'] + 1);
            $equipmentModel->update($borrow['equipment_id'], [
                'available_count' => $newAvailableCount
            ]);
        }

        // Send return confirmation email to the borrower
        $emailService = new EmailService();
        $userData = [
            'firstname' => $borrow['firstname'],
            'lastname' => $borrow['lastname'],
            'email' => $borrow['email']
        ];
        $emailService->sendReturnConfirmationEmail($userData, $borrow['equipment_name']);

        session()->setFlashdata('success', 'Equipment marked as returned. Available count updated. Return confirmation email sent to borrower.');
        return redirect()->to('/returned');
    }
}

