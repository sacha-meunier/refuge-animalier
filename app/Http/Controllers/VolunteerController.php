<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Requests\StoreVolunteerRequest;
use App\Mail\VolunteeringPosted;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
                    'address' => $request->address,
                ]
            );

            // Create message
            $message = Message::create([
                'type' => MessageType::VOLUNTEERING,
                'message' => $request->message,
                'contact_id' => $contact->id,
            ]);

            // Load the contact relation explicitly
            /*$message->load('contact');*/

            Mail::to($message->contact)->send(
                new VolunteeringPosted($message)
            );
        });


        return redirect()
            ->route('volunteer.create')
            ->with('success', __('client.volunteer_success'));
    }
}
