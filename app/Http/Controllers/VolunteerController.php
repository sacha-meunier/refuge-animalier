<?php

namespace App\Http\Controllers;

class VolunteerController extends Controller
{
    public function create()
    {
        return view('pages.client.volunteer.create');
    }
}
