<?php

namespace App\Livewire\Forms;

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Livewire\Traits\HandleFileUpload;
use App\Models\Animal;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AnimalForm extends Form
{
    use HandleFileUpload;

    public ?Animal $animal;

    public ?string $name = null;

    public mixed $image = null;

    public ?string $image_path = null;

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
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
        ];
    }

    public function setAnimal(Animal $animal)
    {
        $this->animal = $animal;
        $this->name = $animal->name;
        $this->description = $animal->description;
        $this->gender = $animal->gender?->value;
        $this->breed_id = $animal->breed?->id;
        $this->age = $animal->age?->format('Y-m-d');
        $this->coat_id = $animal->coat?->id;
        $this->admission_date = $animal->admission_date?->format('Y-m-d');
        $this->status = $animal->status->value;
        $this->image_path = $animal->image_path;
    }

    public function store()
    {
        $this->validate();

        $data = $this->all();

        $animal = Animal::create($data);

        if ($this->image) {
            $filename = $this->uploadAnimalImage($this->image, $animal->id);
            $animal->update(['image_path' => $filename]);
        }

        // Gérer l'upload de l'image
//        if ($this->image) {
//            // On crée d'abord l'animal pour avoir son ID
//            $animal = Animal::create($data);
//            $filename = $this->uploadAnimalImage($this->image, $animal->id);
//            if ($filename) {
//                $animal->update(['image_path' => $filename]);
//            }
//        } else {
//            Animal::create($data);
//        }
    }

    public function update()
    {
        $this->validate();

        $data = $this->all();

        if ($this->image) {
            // Replace old image
            if ($this->animal->image_path) {
                $this->deleteAnimalImages($this->animal->image_path);
            }
            // Upload new image
            $filename = $this->uploadAnimalImage($this->image, $this->animal->id);
            $data['image_path'] = $filename;
        }

        $this->animal->update($data);
    }

    public function delete(Animal $animal)
    {
        $animal->delete();
    }
}
