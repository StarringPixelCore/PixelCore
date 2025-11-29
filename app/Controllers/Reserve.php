<?php

namespace App\Controllers;

use App\Models\ReserveModel;
use App\Models\EquipmentModel;
use App\Models\EquipmentBundleModel;
use App\Models\UserModel;
use App\Services\EmailService;

class Reserve extends BaseController
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
     * Show reserve form for ASSOCIATE only
     */
    public function index()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ASSOCIATE') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ASSOCIATE.');
            return redirect()->to('/dashboard');
        }

        $equipmentModel = new EquipmentModel();
        $availableEquipment = $equipmentModel->getAvailable();

        $data = [
            'title' => 'Reserve Equipment',
            'availableEquipment' => $availableEquipment,
            'active' => 'reserve'
        ];

        return view('reserve/view_reserve', $data);
    }

    /**
     * Submit reserve request
     */
    public function submit()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ASSOCIATE') {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to('/dashboard');
        }

        $validation = service('validation');
        $reserveModel = new ReserveModel();
        $userModel = new UserModel();

        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // Get equipment IDs from form
        $equipmentIds = $this->request->getPost('equipment_id');
        $roomNumber = $this->request->getPost('room_number');
        $reserveDate = $this->request->getPost('reserve_date');
        $reserveTime = $this->request->getPost('reserve_time');

        // Validate equipment_id array separately
        if (empty($equipmentIds) || !is_array($equipmentIds) || empty(array_filter($equipmentIds))) {
            $errors = ['equipment_id' => 'Please select at least one equipment.'];
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }

        // Prepare data for validation (excluding equipment_id array)
        $data = [
            'room_number' => $roomNumber,
            'reserve_date' => $reserveDate,
            'reserve_time' => $reserveTime
        ];

        // Validate other fields
        if (!$validation->run($data, 'reserveSubmit')) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $equipmentModel = new EquipmentModel();
        $emailService = new EmailService();

        // Create reservation record for each equipment
        $equipmentNames = [];
        foreach ($equipmentIds as $equipmentId) {
            $equipment = $equipmentModel->find($equipmentId);
            
            if (!$equipment || $equipment['status'] !== 'Active' || $equipment['available_count'] <= 0) {
                continue; // Skip unavailable equipment
            }

            $equipmentNames[] = $equipment['equipment_name'];

            $reserveData = [
                'user_id' => $userId,
                'id_number' => $user['id_number'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'equipment_id' => $equipmentId,
                'equipment_name' => $equipment['equipment_name'],
                'room_number' => $roomNumber,
                'reserve_date' => $reserveDate,
                'reserve_time' => $reserveTime,
                'status' => 'Pending'
            ];

            $reserveModel->insert($reserveData);
        }

        // Send email notification (send one email with all equipment names)
        if (!empty($equipmentNames)) {
            $equipmentList = implode(', ', $equipmentNames);
            $emailService->sendReserveConfirmationEmail($user, $equipmentList, $roomNumber, $reserveDate, $reserveTime, 'Pending');
        }

        session()->setFlashdata('success', 'Reservation request submitted successfully! Please check your email for confirmation.');
        return redirect()->to('/reserve');
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

        $reserveModel = new ReserveModel();
        $reservation = $reserveModel->find($id);

        if (!$reservation) {
            session()->setFlashdata('error', 'Reservation request not found.');
            return redirect()->to('/reservations');
        }

        if ($reservation['status'] !== 'Pending') {
            session()->setFlashdata('error', 'This reservation request has already been processed.');
            return redirect()->to('/reservations');
        }

        // Update reservation status
        $reserveModel->update($id, ['status' => 'Received']);

        // Decrease available count for parent equipment
        $equipmentModel = new EquipmentModel();
        $equipment = $equipmentModel->find($reservation['equipment_id']);
        if ($equipment) {
            $newAvailableCount = max(0, $equipment['available_count'] - 1);
            $equipmentModel->update($reservation['equipment_id'], [
                'available_count' => $newAvailableCount
            ]);
        }

        // Decrease available count for bundled accessories
        $bundleModel = new EquipmentBundleModel();
        $bundles = $bundleModel->where('parent_equipment_id', $reservation['equipment_id'])->findAll();

        foreach ($bundles as $bundle) {
            $accessory = $equipmentModel->find($bundle['accessory_equipment_id']);
            if (!$accessory) {
                continue;
            }

            $decrementBy = (int) $bundle['quantity_per_parent'];
            $newAccessoryCount = max(0, $accessory['available_count'] - $decrementBy);

            $equipmentModel->update($bundle['accessory_equipment_id'], [
                'available_count' => $newAccessoryCount
            ]);
        }

        session()->setFlashdata('success', 'Successfully marked reservation as received.');
        return redirect()->to('/reservations');
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

        $reserveModel = new ReserveModel();
        $reservation = $reserveModel->find($id);

        if (!$reservation) {
            session()->setFlashdata('error', 'Reservation request not found.');
            return redirect()->to('/reservations');
        }

        if ($reservation['status'] !== 'Received') {
            session()->setFlashdata('error', 'Equipment must be received first before it can be returned.');
            return redirect()->to('/reservations');
        }

        // Update reservation status and set returned date
        $reserveModel->update($id, [
            'status' => 'Complete',
            'returned_at' => date('Y-m-d H:i:s')
        ]);

        // Increase available count for parent equipment
        $equipmentModel = new EquipmentModel();
        $equipment = $equipmentModel->find($reservation['equipment_id']);
        if ($equipment) {
            $newAvailableCount = min($equipment['quantity'], $equipment['available_count'] + 1);
            $equipmentModel->update($reservation['equipment_id'], [
                'available_count' => $newAvailableCount
            ]);
        }

        // Increase available count for bundled accessories
        $bundleModel = new EquipmentBundleModel();
        $bundles = $bundleModel->where('parent_equipment_id', $reservation['equipment_id'])->findAll();

        foreach ($bundles as $bundle) {
            $accessory = $equipmentModel->find($bundle['accessory_equipment_id']);
            if (!$accessory) {
                continue;
            }

            $incrementBy = (int) $bundle['quantity_per_parent'];
            $newAccessoryCount = min($accessory['quantity'], $accessory['available_count'] + $incrementBy);

            $equipmentModel->update($bundle['accessory_equipment_id'], [
                'available_count' => $newAccessoryCount
            ]);
        }

        // Send return confirmation email to the reserver
        $emailService = new EmailService();
        $userData = [
            'firstname' => $reservation['firstname'],
            'lastname' => $reservation['lastname'],
            'email' => $reservation['email'],
            'id_number' => $reservation['id_number']
        ];
        $emailService->sendReserveReturnConfirmationEmail($userData, $reservation['equipment_name'], $reservation['room_number'], $reservation['reserve_date'], $reservation['reserve_time']);

        session()->setFlashdata('success', 'Successfully marked reservation as returned.');
        return redirect()->to('/reservations/returned');
    }

    /**
     * Cancel reservation (ITSO only)
     */
    public function cancel($id)
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

        $reserveModel = new ReserveModel();
        $reservation = $reserveModel->find($id);

        if (!$reservation) {
            session()->setFlashdata('error', 'Reservation request not found.');
            return redirect()->to('/reservations');
        }

        if (!in_array($reservation['status'], ['Pending', 'Received'])) {
            session()->setFlashdata('error', 'Only Pending or Received reservations can be cancelled.');
            return redirect()->to('/reservations');
        }

        // Update reservation status to Cancelled
        $reserveModel->update($id, ['status' => 'Cancelled']);

        // If status was Received, restore available count
        if ($reservation['status'] === 'Received') {
            $equipmentModel = new EquipmentModel();
            $equipment = $equipmentModel->find($reservation['equipment_id']);
            if ($equipment) {
                $newAvailableCount = min($equipment['quantity'], $equipment['available_count'] + 1);
                $equipmentModel->update($reservation['equipment_id'], [
                    'available_count' => $newAvailableCount
                ]);
            }

            // Restore available count for bundled accessories
            $bundleModel = new EquipmentBundleModel();
            $bundles = $bundleModel->where('parent_equipment_id', $reservation['equipment_id'])->findAll();

            foreach ($bundles as $bundle) {
                $accessory = $equipmentModel->find($bundle['accessory_equipment_id']);
                if (!$accessory) {
                    continue;
                }

                $incrementBy = (int) $bundle['quantity_per_parent'];
                $newAccessoryCount = min($accessory['quantity'], $accessory['available_count'] + $incrementBy);

                $equipmentModel->update($bundle['accessory_equipment_id'], [
                    'available_count' => $newAccessoryCount
                ]);
            }
        }

        // Send cancellation email to the reserver
        $emailService = new EmailService();
        $userData = [
            'firstname' => $reservation['firstname'],
            'lastname' => $reservation['lastname'],
            'email' => $reservation['email'],
            'id_number' => $reservation['id_number']
        ];
        $emailService->sendReserveCancellationEmail($userData, $reservation['equipment_name'], $reservation['reserve_date'], $reservation['reserve_time']);

        session()->setFlashdata('success', 'Reservation cancelled successfully. Email notification sent to the associate.');
        return redirect()->to('/reservations');
    }

    /**
     * Show reschedule form (ITSO only)
     */
    public function reschedule($id)
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

        $reserveModel = new ReserveModel();
        $reservation = $reserveModel->find($id);

        if (!$reservation) {
            session()->setFlashdata('error', 'Reservation request not found.');
            return redirect()->to('/reservations');
        }

        if ($reservation['status'] !== 'Pending') {
            session()->setFlashdata('error', 'Only Pending reservations can be rescheduled.');
            return redirect()->to('/reservations');
        }

        $data = [
            'title' => 'Reschedule Reservation',
            'reservation' => $reservation,
            'active' => 'reservations'
        ];

        return view('reserve/view_reschedule', $data);
    }

    /**
     * Process reschedule (ITSO only)
     */
    public function reschedulePost($id)
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

        $reserveModel = new ReserveModel();
        $reservation = $reserveModel->find($id);

        if (!$reservation) {
            session()->setFlashdata('error', 'Reservation request not found.');
            return redirect()->to('/reservations');
        }

        if ($reservation['status'] !== 'Pending') {
            session()->setFlashdata('error', 'Only Pending reservations can be rescheduled.');
            return redirect()->to('/reservations');
        }

        $validation = service('validation');
        $newDate = $this->request->getPost('reserve_date');
        $newTime = $this->request->getPost('reserve_time');
        $newRoomNumber = $this->request->getPost('room_number');

        // Prepare data for validation
        $data = [
            'room_number' => $newRoomNumber,
            'reserve_date' => $newDate,
            'reserve_time' => $newTime
        ];

        // Validate fields
        if (!$validation->run($data, 'reserveSubmit')) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Store old values for email
        $oldDate = $reservation['reserve_date'];
        $oldTime = $reservation['reserve_time'];
        $oldRoomNumber = $reservation['room_number'];

        // Update reservation
        $reserveModel->update($id, [
            'reserve_date' => $newDate,
            'reserve_time' => $newTime,
            'room_number' => $newRoomNumber
        ]);

        // Send reschedule email to the reserver
        $emailService = new EmailService();
        $userData = [
            'firstname' => $reservation['firstname'],
            'lastname' => $reservation['lastname'],
            'email' => $reservation['email'],
            'id_number' => $reservation['id_number']
        ];
        $emailService->sendReserveRescheduleEmail($userData, $reservation['equipment_name'], $oldDate, $oldTime, $oldRoomNumber, $newDate, $newTime, $newRoomNumber);

        session()->setFlashdata('success', 'Reservation rescheduled successfully. Email notification sent to the associate.');
        return redirect()->to('/reservations');
    }
}

