<?php

namespace App\Livewire\Forms;

use App\Models\Note;
use Livewire\Form;

class NoteForm extends Form
{
    public ?Note $note;

    public ?string $title = null;

    public ?string $content = null;

    public ?int $animal_id = null;

    public ?int $user_id = null;

    public function rules()
    {
        return [
            'title' => 'required|min:2|max:64',
            'content' => 'nullable|string',
            'animal_id' => 'required|exists:animals,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function setNote(Note $note)
    {
        $this->note = $note;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->animal_id = $note->animal_id;
        $this->user_id = $note->user_id;
    }

    public function store()
    {
        $this->validate();

        Note::create($this->all());
    }

    public function update()
    {
        $this->validate();

        $this->note->update($this->all());
    }

    public function delete(Note $note)
    {
        $note->delete();
    }
}
