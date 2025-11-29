<?php

namespace App\Controllers;

use App\Models\EquipmentModel;
use App\Models\BorrowModel;
use App\Models\UserModel;

class Reports extends BaseController
{
    /**
     * Check if user is logged in and has ITSO PERSONNEL role
     */
    private function checkAccess()
    {
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

    /**
     * Reports Dashboard - Choose report type
     */
    public function index()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $data = [
            'title' => 'Reports',
            'active' => 'reports'
        ];

        return view('view_reports', $data);
    }

    /**
     * Active Equipment List Report
     */
    public function activeEquipment()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipments = $equipmentModel->where('status', 'Active')
                                     ->orderBy('category', 'ASC')
                                     ->orderBy('equipment_name', 'ASC')
                                     ->findAll();

        $data = [
            'title' => 'Active Equipment Report',
            'equipments' => $equipments,
            'active' => 'reports'
        ];

        return view('equipments/view_active_equipment', $data);
    }

    /**
     * Export Active Equipment to CSV (Excel)
     */
    public function exportActiveEquipment()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipments = $equipmentModel->where('status', 'Active')
                                     ->orderBy('category', 'ASC')
                                     ->orderBy('equipment_name', 'ASC')
                                     ->findAll();

        $filename = 'Active_Equipment_Report_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for Excel UTF-8 recognition
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Headers
        fputcsv($output, ['ID', 'Equipment Name', 'Category', 'Total Quantity', 'Available', 'Status', 'Created Date']);
        
        // Data rows
        foreach ($equipments as $equipment) {
            fputcsv($output, [
                $equipment['id'],
                $equipment['equipment_name'],
                $equipment['category'],
                $equipment['quantity'],
                $equipment['available_count'],
                $equipment['status'],
                $equipment['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Unusable Equipment Report (Deactivated/Damaged)
     */
    public function unusableEquipment()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipments = $equipmentModel->where('status', 'Deactivated')
                                     ->orderBy('category', 'ASC')
                                     ->orderBy('equipment_name', 'ASC')
                                     ->findAll();

        $data = [
            'title' => 'Unusable Equipment Report',
            'equipments' => $equipments,
            'active' => 'reports'
        ];

        return view('equipments/view_unusable_equipment', $data);
    }

    /**
     * Export Unusable Equipment to CSV (Excel)
     */
    public function exportUnusableEquipment()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipments = $equipmentModel->where('status', 'Deactivated')
                                     ->orderBy('category', 'ASC')
                                     ->orderBy('equipment_name', 'ASC')
                                     ->findAll();

        $filename = 'Unusable_Equipment_Report_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for Excel UTF-8 recognition
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Headers
        fputcsv($output, ['ID', 'Equipment Name', 'Category', 'Quantity', 'Status', 'Deactivated Date']);
        
        // Data rows
        foreach ($equipments as $equipment) {
            fputcsv($output, [
                $equipment['id'],
                $equipment['equipment_name'],
                $equipment['category'],
                $equipment['quantity'],
                $equipment['status'],
                $equipment['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * User Borrowing History Report
     */
    public function borrowingHistory()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $borrowModel = model('BorrowModel');
        
        // Get filter parameters
        $userId = $this->request->getGet('user_id');

        // Build query
        $query = $borrowModel->orderBy('created_at', 'DESC');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $borrowings = $query->findAll();

        // Get all users for filter dropdown
        $userModel = model('UserModel');
        $users = $userModel->findAll();

        $data = [
            'title' => 'Borrowing History Report',
            'borrowings' => $borrowings,
            'users' => $users,
            'active' => 'reports'
        ];

        return view('borrow/view_borrowing_history', $data);
    }

    /**
     * Export Borrowing History to CSV (Excel)
     */
    public function exportBorrowingHistory()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $borrowModel = model('BorrowModel');
        
        // Get filter parameters
        $userId = $this->request->getGet('user_id');

        // Build query
        $query = $borrowModel->orderBy('created_at', 'DESC');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $borrowings = $query->findAll();

        $filename = 'Borrowing_History_Report_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for Excel UTF-8 recognition
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Headers
        fputcsv($output, ['ID', 'User Name', 'ID Number', 'Equipment', 'Room Number', 'Borrow Date', 'Borrow Time', 'Returned At', 'Status']);
        
        // Data rows
        foreach ($borrowings as $borrow) {
            fputcsv($output, [
                $borrow['id'],
                $borrow['firstname'] . ' ' . $borrow['lastname'],
                $borrow['id_number'],
                $borrow['equipment_name'],
                $borrow['room_number'],
                $borrow['borrow_date'],
                $borrow['borrow_time'],
                $borrow['returned_at'] ?? 'Not Returned',
                $borrow['status']
            ]);
        }
        
        fclose($output);
        exit;
    }
}