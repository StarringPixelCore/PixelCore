<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('view_index', ['active' => 'dashboard']);
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
        return view('view_borrowed', ['active' => 'borrowed']);
    }

    public function returned()
    {
        return view('view_returned', ['active' => 'returned']);
    }
}
