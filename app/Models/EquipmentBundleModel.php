<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentBundleModel extends Model
{
    protected $table = 'tblequipment_bundles';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'parent_equipment_id',
        'accessory_equipment_id',
        'quantity_per_parent',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    /**
     * Get accessories for a parent equipment
     * Returns array of accessory equipment names
     */
    public function getAccessoriesForEquipment($parentEquipmentId)
    {
        $equipmentModel = new EquipmentModel();
        $bundles = $this->where('parent_equipment_id', $parentEquipmentId)->findAll();
        $accessories = [];
        
        foreach ($bundles as $bundle) {
            $accessory = $equipmentModel->find($bundle['accessory_equipment_id']);
            if ($accessory) {
                $accessories[] = $accessory['equipment_name'];
            }
        }
        
        return $accessories;
    }
}


