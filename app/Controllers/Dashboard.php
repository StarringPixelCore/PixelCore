<?php

namespace App\Controllers;

use App\Models\BorrowModel;
use App\Models\EquipmentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $equipmentModel = new EquipmentModel();
        $borrowModel = new BorrowModel();

        // Get total equipment count
        $total_equipment = $equipmentModel->getTotalCount();

        // Get total available items (sum of all available_count)
        $available = $equipmentModel->getTotalAvailableItems();

        // Get borrowed count (equipment that is received but not returned)
        $borrowed = $borrowModel->where('status', 'Received')->countAllResults();

        // Get reservations for today (assuming reservations are borrows with status Pending for today)
        $today = date('Y-m-d');
        $reservations_today = $borrowModel->where('status', 'Pending')
                                          ->where('borrow_date', $today)
                                          ->countAllResults();

        // Get recent borrowings (last 5)
        $recentBorrowings = $borrowModel->orderBy('created_at', 'DESC')
                                       ->limit(5)
                                       ->findAll();

        // Get low stock items
        $lowStockItems = $equipmentModel->getLowStock();

        $data = [
            'active' => 'dashboard',
            'total_equipment' => $total_equipment,
            'available' => $available,
            'borrowed' => $borrowed,
            'reservations_today' => $reservations_today,
            'recentBorrowings' => $recentBorrowings,
            'lowStockItems' => $lowStockItems
        ];

        return view('view_index', $data);
    }

    public function users()
    {
        return view('view_users', ['active' => 'users']);
    }

    public function equipments()
    {
        return view('view_equipments', ['active' => 'equipments']);
    }

    public function reservations()
    {
        return view('view_reservations', ['active' => 'reservations']);
    }

    public function borrowed()
    {
        // Check if user is logged in and is ITSO PERSONNEL
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ITSO PERSONNEL.');
            return redirect()->to('/dashboard');
        }

        $borrowModel = new BorrowModel();
        // Get only active borrows (Pending and Received), exclude Returned/Complete
        $borrows = $borrowModel->where('status !=', 'Returned')
                              ->orderBy('created_at', 'DESC')
                              ->findAll();

        $data = [
            'title' => 'Borrowed Equipment',
            'borrows' => $borrows,
            'active' => 'borrowed'
        ];

        return view('borrow/view_borrowed', $data);
    }

    public function returned()
    {
        // Check if user is logged in and is ITSO PERSONNEL
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ITSO PERSONNEL.');
            return redirect()->to('/dashboard');
        }

        $borrowModel = new BorrowModel();
        // Get all returned/completed borrows
        $returnedBorrows = $borrowModel->where('status', 'Returned')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        $data = [
            'title' => 'Returned Equipment',
            'returnedBorrows' => $returnedBorrows,
            'active' => 'returned'
        ];

        return view('view_returned', $data);
    }
}
