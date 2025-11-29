<?php

namespace App\Controllers;

use App\Models\BorrowModel;
use App\Models\EquipmentModel;
use App\Models\ReserveModel;
use App\Models\EquipmentBundleModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Only ITSO PERSONNEL can access dashboard
        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            // Redirect STUDENT to borrow page
            if ($userRole === 'STUDENT') {
                return redirect()->to('/borrow');
            }
            // Redirect ASSOCIATE to borrow page
            if ($userRole === 'ASSOCIATE') {
                return redirect()->to('/borrow');
            }
            // Redirect other roles to login
            return redirect()->to('/login');
        }

        $equipmentModel = new EquipmentModel();
        $borrowModel = new BorrowModel();

        // Get total equipment count
        $total_equipment = $equipmentModel->getTotalCount();

        // Get total available items (sum of all available_count)
        $available = $equipmentModel->getTotalAvailableItems();

        // Get borrowed count (equipment that is received but not returned)
        $borrowed = $borrowModel->where('status', 'Received')->countAllResults();

        // Get pending reservations
        $reserveModel = new ReserveModel();
        $reservations_today = $reserveModel->where('status', 'Pending')
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
        // Check if user is logged in and is ITSO PERSONNEL
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ITSO PERSONNEL.');
            return redirect()->to('/dashboard');
        }

        $reserveModel = new \App\Models\ReserveModel();
        $bundleModel = new EquipmentBundleModel();
        
        // Get only active reservations (Pending and Received), exclude Complete and Cancelled
        $reservations = $reserveModel->where('status !=', 'Complete')
                              ->where('status !=', 'Cancelled')
                              ->orderBy('created_at', 'DESC')
                              ->findAll();

        // Attach accessories to each reservation
        foreach ($reservations as &$reservation) {
            $reservation['accessories'] = $bundleModel->getAccessoriesForEquipment($reservation['equipment_id']);
        }

        $data = [
            'title' => 'Reservations',
            'reservations' => $reservations,
            'active' => 'reservations'
        ];

        return view('reserve/view_reservations', $data);
    }

    public function reservationsReturned()
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

        $reserveModel = new \App\Models\ReserveModel();
        $bundleModel = new EquipmentBundleModel();
        
        // Get all completed reservations
        $returnedReservations = $reserveModel->where('status', 'Complete')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        // Attach accessories to each reservation
        foreach ($returnedReservations as &$reservation) {
            $reservation['accessories'] = $bundleModel->getAccessoriesForEquipment($reservation['equipment_id']);
        }

        $data = [
            'title' => 'Returned Reservations',
            'returnedReservations' => $returnedReservations,
            'active' => 'reservations'
        ];

        return view('reserve/view_reservations_returned', $data);
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
        $bundleModel = new EquipmentBundleModel();
        
        // Get only active borrows (Pending and Received), exclude Returned/Complete
        $borrows = $borrowModel->where('status !=', 'Returned')
                              ->orderBy('created_at', 'DESC')
                              ->findAll();

        // Attach accessories to each borrow
        foreach ($borrows as &$borrow) {
            $borrow['accessories'] = $bundleModel->getAccessoriesForEquipment($borrow['equipment_id']);
        }

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
        $bundleModel = new EquipmentBundleModel();
        
        // Get all returned/completed borrows
        $returnedBorrows = $borrowModel->where('status', 'Returned')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        // Attach accessories to each borrow
        foreach ($returnedBorrows as &$borrow) {
            $borrow['accessories'] = $bundleModel->getAccessoriesForEquipment($borrow['equipment_id']);
        }

        $data = [
            'title' => 'Returned Equipment',
            'returnedBorrows' => $returnedBorrows,
            'active' => 'returned'
        ];

        return view('view_returned', $data);
    }
}
