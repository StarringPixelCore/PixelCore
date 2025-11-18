<?php
namespace App\Controllers;

class Reservations extends BaseController
{
    public function index()
    {
        return view('view_reservations');
    }
}
