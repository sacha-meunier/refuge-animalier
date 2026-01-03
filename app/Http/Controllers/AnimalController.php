<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $animals = Animal::all();

        return view('pages.client.animals.index', compact('animals'));
    }

    public function show($id)
    {
        $animal = Animal::findOrFail($id);

        return view('pages.client.animals.show', $animal);
    }
}
