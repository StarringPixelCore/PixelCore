<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowModel extends Model
{
    protected $table = 'tblborrows';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'id_number',
        'firstname',
        'lastname',
        'email',
        'equipment_id',
        'equipment_name',
        'room_number',
        'borrow_date',
        'borrow_time',
        'status',
        'returned_at',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Get all borrow requests
    public function getAllBorrows()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Get borrows by user
    public function getBorrowsByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get borrows by status
    public function getBorrowsByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}

