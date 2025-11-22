<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{
    /**
     * Check if ID number exists in database
     */
    public function id_number_exists(string $str, string &$error = null): bool
    {
        $model = new UserModel();
        $user = $model->where('id_number', $str)->first();

        if (!$user) {
            $error = 'The ID number you entered is not connected to an account.';
            return false;
        }
        return true;
    }

    /**
     * Validate password matches the user's password
     * 
     * @param string $str The password to validate
     * @param string $fields The field name to check (id_number)
     * @param array $data All form data
     * @param string|null $error Error message reference
     */
    public function valid_password(string $str, string $fields, array $data, string &$error = null): bool
    {
        $model = new UserModel();

        $id_number = $data['id_number'] ?? '';
        $user = $model->where('id_number', $id_number)->first();

        if (!$user) {
            // ID number already checked by id_number_exists rule, so just return true
            return true;
        }

        // Use password_verify to compare plain password with hashed password
        if (!password_verify($str, $user['password'])) {
            $error = 'Your password is incorrect.';
            return false;
        }

        return true;
    }
}