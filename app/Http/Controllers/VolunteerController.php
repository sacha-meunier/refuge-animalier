<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Requests\StoreVolunteerRequest;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    public function create()
    {
        return view('pages.client.volunteer.create');
    }

    /**
     * @throws \Throwable
     */
    public function store(StoreVolunteerRequest $request)
    {
        DB::transaction(function () use ($request) {
            // Create or update contact
            $contact = Contact::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]
            );

            // Create message
            Message::create([
                'type' => MessageType::VOLUNTEERING,
                'message' => $request->message,
                'contact_id' => $contact->id,
            ]);
        });

        return redirect()
            ->route('volunteer.create')
            ->with('success', __('client.volunteer_success'));
    }
}
