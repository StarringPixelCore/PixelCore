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

    // Helper method to get available count (number of equipment types)
    public function getAvailableCount()
    {
        return $this->where('status', 'Active')
                    ->where('available_count >', 0)
                    ->countAllResults();
    }

    // Helper method to get total available items (sum of available_count)
    public function getTotalAvailableItems()
    {
        $result = $this->selectSum('available_count')
                      ->where('status', 'Active')
                      ->first();
        return (int) ($result['available_count'] ?? 0);
    }
}
