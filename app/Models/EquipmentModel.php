<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table = 'tblequipment';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'equipment_name',
        'category',
        'quantity',
        'available_count',
        'status',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Helper method to get available equipment
    public function getAvailable()
    {
        return $this->where('status', 'Active')
                    ->where('available_count >', 0)
                    ->findAll();
    }

    // Helper method to get low stock items (less than 2 available)
    public function getLowStock()
    {
        return $this->where('status', 'Active')
                    ->where('available_count <', 2)
                    ->findAll();
    }

    // Helper method to get equipment by category
    public function getByCategory($category)
    {
        return $this->where('category', $category)
                    ->where('status', 'Active')
                    ->findAll();
    }

    // Helper method to get total equipment count
    public function getTotalCount()
    {
        return $this->where('status', 'Active')->countAllResults();
    }

    // Helper method to get available count
    public function getAvailableCount()
    {
        return $this->where('status', 'Active')
                    ->where('available_count >', 0)
                    ->countAllResults();
    }
}
