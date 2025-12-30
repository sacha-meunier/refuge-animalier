<?php

namespace App\Livewire\Forms;

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Models\Animal;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AnimalForm extends Form
{
    public ?string $name = null;
    public ?string $description = null;
    public ?string $gender = null;
    public ?string $age = null;
    public ?string $admission_date = null;
    public ?int $breed_id = null;
    public ?int $coat_id = null;
    public string $status = AnimalStatus::IN_PROGRESS->value;

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:60',
            'description' => 'nullable|string',
            'gender' => ['nullable', Rule::enum(AnimalGender::class)],
            'breed_id' => 'nullable|exists:breeds,id',
            'age' => 'nullable|date|before:today',
            'coat_id' => 'nullable|exists:coats,id',
            'admission_date' => 'nullable|date|before_or_equal:today|after_or_equal:age',
            'status' => ['required', Rule::enum(AnimalStatus::class)],
        ];
    }

    public function store()
    {
        $this->validate();
        Animal::create($this->all());
    }

    public function delete(Animal $animal)
    {
        $animal->delete();
    }
}
