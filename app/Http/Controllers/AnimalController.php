<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $paginate = 9;

        $query = Animal::query()
            ->where('published', true)
            ->with(['breed', 'specie']);

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('breed', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('specie', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $animals = $query->paginate($paginate)->withQueryString();

        return view('pages.client.animals.index', compact('animals'));
    }

    public function show($id)
    {
        $animal = Animal::findOrFail($id);

        return view('pages.client.animals.show', $animal);
    }
}
