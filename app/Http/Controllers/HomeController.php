<?php

namespace App\Http\Controllers;

use App\Enums\AnimalStatus;
use App\Models\Animal;

class HomeController extends Controller
{
    public function index()
    {
        // Get some random published animals for the carousel
        $animals = Animal::where('published', true)
            ->with(['breed', 'specie'])
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Statistics for current year
        $currentYear = now()->year;

        $rescuedThisYear = Animal::whereYear('admission_date', $currentYear)->count();

        $adoptedThisYear = Animal::where('status', AnimalStatus::ADOPTED)
            ->whereYear('updated_at', $currentYear)
            ->count();

        $currentAnimals = Animal::where('published', true)
            ->where('status', '!=', AnimalStatus::ADOPTED)
            ->count();

        return view('home', compact('animals', 'rescuedThisYear', 'adoptedThisYear', 'currentAnimals'));
    }
}
