<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactPosted;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.client.contact.create');
    }

    /**
     * @throws \Throwable
     */
    public function store(StoreContactRequest $request)
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
            $message = Message::create([
                'type' => MessageType::CONTACT,
                'message' => $request->message,
                'contact_id' => $contact->id,
            ]);

            // Send mail
            Mail::to($message->contact)->send(
                new ContactPosted($message)
            );
        });

        return redirect()
            ->route('contact.create')
            ->with('success', __('client.contact_success'));
    }
}
