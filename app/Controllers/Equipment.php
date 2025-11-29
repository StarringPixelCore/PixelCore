<?php

namespace App\Controllers;

use App\Models\EquipmentModel;

class Equipment extends BaseController
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
     * Check if user has write access (ITSO PERSONNEL only)
     */
    private function checkWriteAccess()
    {
        $userRole = session()->get('role');
        if ($userRole !== 'ITSO PERSONNEL') {
            session()->setFlashdata('error', 'Access denied. This section is only available for ITSO PERSONNEL.');
            return redirect()->to('/equipment');
        }
        return null;
    }

    /**
     * Display list of all equipment
     */
    public function index($perpage = 10)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $queryResult = $equipmentModel
            ->orderBy('category', 'ASC')
            ->orderBy('equipment_name', 'ASC')
            ->paginate($perpage);

        $data = [
            'title' => 'Equipment Management',
            'equipments' => $queryResult,
            'pager' => $equipmentModel->pager,
            'active' => 'equipments'
        ];

        return view('equipments/view_equipments', $data);
    }

    /**
     * Show form to add new equipment
     */
    public function add()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        helper('form');
        $data = [
            'title' => 'Add New Equipment',
            'active' => 'equipments'
        ];

        return view('equipments/view_add_equipment', $data);
    }

    /**
     * Insert new equipment into database
     */
    public function insert()
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        $validation = service('validation');
        $equipmentModel = model('EquipmentModel');

        $data = [
            'equipment_name' => $this->request->getPost('equipment_name'),
            'category' => $this->request->getPost('category'),
            'quantity' => $this->request->getPost('quantity'),
            'available_count' => $this->request->getPost('quantity')
        ];

        if (!$validation->run($data, 'equipment')) {
            return redirect()->to('equipment/add')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $equipmentModel->insert($data);
        $this->session->setFlashdata('success', 'Equipment added successfully.');

        return redirect()->to('equipment');
    }

    /**
     * Display equipment details
     */
    public function view($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipment = $equipmentModel->find($id);

        if (!$equipment) {
            $this->session->setFlashdata('error', 'Equipment not found.');
            return redirect()->to('equipment');
        }

        // Parse accessories if stored as JSON
        if (!empty($equipment['accessories'])) {
            $equipment['accessories'] = json_decode($equipment['accessories'], true);
        }

        $data = [
            'title' => 'View Equipment',
            'equipment' => $equipment,
            'active' => 'equipments'
        ];

        return view('equipments/view_equipment', $data);
    }

    /**
     * Show form to edit equipment
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipment = $equipmentModel->find($id);

        if (!$equipment) {
            $this->session->setFlashdata('error', 'Equipment not found.');
            return redirect()->to('equipment');
        }

        helper('form');
        $data = [
            'title' => 'Edit Equipment',
            'equipment' => $equipment,
            'active' => 'equipments'
        ];

        return view('equipments/view_edit_equipment', $data);
    }

    /**
     * Update equipment in database
     */
    public function update($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        $validation = service('validation');
        $equipmentModel = model('EquipmentModel');
        $existingEquipment = $equipmentModel->find($id);

        if (!$existingEquipment) {
            $this->session->setFlashdata('error', 'Equipment not found.');
            return redirect()->to('equipment');
        }

        $data = [
            'equipment_name' => $this->request->getPost('equipment_name'),
            'category' => $this->request->getPost('category'),
            'quantity' => $this->request->getPost('quantity'),
            'available_count' => $this->request->getPost('available_count')
        ];

        if (!$validation->run($data, 'equipmentEdit')) {
            return redirect()->to('equipment/edit/' . $id)
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $equipmentModel->update($id, $data);
        $this->session->setFlashdata('success', 'Equipment updated successfully.');

        return redirect()->to('equipment');
    }

    /**
     * Delete or deactivate equipment
     */
    public function delete($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipment = $equipmentModel->find($id);

        if (!$equipment) {
            $this->session->setFlashdata('error', 'Equipment not found.');
            return redirect()->to('equipment');
        }

        // Soft delete by setting status to Deactivated
        $equipmentModel->update($id, ['status' => 'Deactivated']);
        $this->session->setFlashdata('success', 'Equipment deactivated successfully.');

        return redirect()->to('equipment');
    }

    /**
     * Reactivate deactivated equipment
     */
    public function reactivate($id)
    {
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== null) {
            return $accessCheck;
        }

        $writeCheck = $this->checkWriteAccess();
        if ($writeCheck !== null) {
            return $writeCheck;
        }

        $equipmentModel = model('EquipmentModel');
        $equipment = $equipmentModel->find($id);

        if (!$equipment) {
            $this->session->setFlashdata('error', 'Equipment not found.');
            return redirect()->to('equipment');
        }

        $equipmentModel->update($id, ['status' => 'Active']);
        $this->session->setFlashdata('success', 'Equipment reactivated successfully.');

        return redirect()->to('equipment');
    }
}
