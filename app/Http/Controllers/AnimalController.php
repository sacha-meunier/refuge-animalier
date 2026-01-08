<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Http\Requests\StoreAdoptionRequest;
use App\Mail\AdoptionPosted;
use App\Mail\AdoptionRequestReceived;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Contact;
use App\Models\Specie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    /**
     * @throws \Throwable
     */
    public function store(StoreAdoptionRequest $request, Animal $animal)
    {
        // Create adoption in transaction
        $adoption = DB::transaction(function () use ($request, $animal) {
            // Create or update contact
            $contact = Contact::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]
            );

            // Create adoption request
            return Adoption::create([
                'content' => $request->message,
                'status' => AdoptionStatus::PENDING,
                'animal_id' => $animal->id,
                'contact_id' => $contact->id,
            ]);
        });

        // Load relations for emails (outside transaction)
        $adoption->load(['contact', 'animal.specie', 'animal.breed']);

        // Send confirmation email to contact
        // Currently commented because of the mailtrap limitations
        /*Mail::to($adoption->contact)->send(
            new AdoptionPosted($adoption)
        );*/

        // Send notification email to users who opted in and have permission
        $eligibleUsers = User::where('receive_adoption_emails', true)
            ->get()
            ->filter(fn($user) => $user->can('manageEmailNotifications', $user));

        foreach ($eligibleUsers as $user) {
            Mail::to($user)->send(
                new AdoptionRequestReceived($adoption)
            );
        }

        return redirect()
            ->route('client.animals.show', $animal)
            ->with('success', __('client.adoption_success'));
    }
}
