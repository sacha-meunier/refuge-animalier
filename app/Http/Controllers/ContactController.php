<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.client.contact.create');
    }
}
