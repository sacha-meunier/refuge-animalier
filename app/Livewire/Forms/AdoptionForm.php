<?php

namespace App\Livewire\Forms;

use App\Enums\AdoptionStatus;
use App\Models\Adoption;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AdoptionForm extends Form
{
    public ?Adoption $adoption = null;

    public ?string $content = null;

    public string $status = AdoptionStatus::PENDING->value;

    public ?int $animal_id = null;

    public ?int $contact_id = null;

    public function rules(): array
    {
        return [
            'content' => 'nullable|string',
            'status' => ['required', Rule::enum(AdoptionStatus::class)],
            'animal_id' => 'required|exists:animals,id',
            'contact_id' => 'required|exists:contacts,id',
        ];
    }

    public function setAdoption(Adoption $adoption): void
    {
        $this->adoption = $adoption;
        $this->content = $adoption->content;
        $this->status = $adoption->status->value;
        $this->animal_id = $adoption->animal_id;
        $this->contact_id = $adoption->contact_id;
    }

    public function store(): void
    {
        $this->validate();

        Adoption::create($this->only(['content', 'status', 'animal_id', 'contact_id']));
    }

    public function update(): void
    {
        $this->validate();

        $this->adoption->update($this->only(['content', 'status', 'animal_id', 'contact_id']));
    }

    public function delete(Adoption $adoption): void
    {
        $adoption->delete();
    }
}
