<?php

namespace App\Livewire\Forms;

use App\Models\Message;
use Livewire\Form;

class MessageForm extends Form
{
    public function delete(Message $message)
    {
        $message->delete();
    }
}
