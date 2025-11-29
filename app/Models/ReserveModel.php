<?php

namespace App\Models;

use CodeIgniter\Model;

class ReserveModel extends Model
{
    protected $table = 'tblreservations';

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
        'reserve_date',
        'reserve_time',
        'status',
        'returned_at',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Get all reservation requests
    public function getAllReservations()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Get reservations by user
    public function getReservationsByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get reservations by status
    public function getReservationsByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}

