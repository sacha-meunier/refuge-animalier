<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $paginate = 9;

        $query = Animal::query()
            ->where('published', true)
            ->with(['breed', 'specie', 'coat']);

        // Search functionality
        // - allows animal name
        // - allows breed name
        // - allows specie name
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

        // Filter by breed (takes priority over specie since breed implies specie)
        if ($breedId = $request->input('breed_id')) {
            $query->where('breed_id', $breedId);
        }
        // Filter by specie (only if no breed is selected)
        elseif ($specieId = $request->input('specie_id')) {
            $query->where('specie_id', $specieId);
        }

        // Filter by coat
        if ($coatId = $request->input('coat_id')) {
            $query->where('coat_id', $coatId);
        }

        // Retrieve animals with paginate and query string
        $animals = $query->paginate($paginate)->withQueryString();

        // Get filter options with counts (only show options that have published animals)
        $species = Specie::withCount(['animals' => function ($query) {
            $query->where('published', true);
        }])
            ->whereHas('animals', function ($query) {
                $query->where('published', true);
            })
            ->orderBy('name')
            ->get();

        $breeds = Breed::withCount(['animals' => function ($query) {
            $query->where('published', true);
        }])
            ->whereHas('animals', function ($query) {
                $query->where('published', true);
            })
            ->orderBy('name')
            ->get();

        $coats = Coat::withCount(['animals' => function ($query) {
            $query->where('published', true);
        }])
            ->whereHas('animals', function ($query) {
                $query->where('published', true);
            })
            ->orderBy('name')
            ->get();

        return view('pages.client.animals.index', compact('animals', 'species', 'breeds', 'coats'));
    }

    public function show(Animal $animal)
    {
        // Only show published animals
        abort_if(! $animal->published, 404);

        return view('pages.client.animals.show', compact('animal'));
    }
}
