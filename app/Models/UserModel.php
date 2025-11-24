<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tblusers';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'id_number',
        'firstname',
        'lastname',
        'email',
        'password',
        'role',
        'profile_picture',
        'created_at',
        'verify_token',
        'is_verified',
        'reset_token',
        'reset_token_expires_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
}
