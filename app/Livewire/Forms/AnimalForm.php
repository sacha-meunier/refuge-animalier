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

    public ?Animal $animal = null;

    public ?string $name = null;

    public array $images = [];

    public ?array $pictures = null;

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
            'images.*' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
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
        $this->pictures = $animal->pictures;
    }

    public function store()
    {
        $this->validate();

        $data = $this->all();
        unset($data['images']);

        $animal = Animal::create($data);

        // Handle image uploads
        if (! empty($this->images)) {
            $pictures = [];
            foreach ($this->images as $image) {
                $uploadedImage = $this->uploadAnimalImage($image, $animal->id);
                if ($uploadedImage) {
                    $pictures[] = $uploadedImage;
                }
            }
            if (! empty($pictures)) {
                $animal->update(['pictures' => $pictures]);
            }
        }
    }

    public function update()
    {
        $this->validate();

        $data = $this->all();
        unset($data['images']);

        // Handle new image uploads
        if (! empty($this->images)) {
            $pictures = $this->pictures ?? [];

            foreach ($this->images as $image) {
                $uploadedImage = $this->uploadAnimalImage($image, $this->animal->id);
                if ($uploadedImage) {
                    $pictures[] = $uploadedImage;
                }
            }
            $data['pictures'] = $pictures;
        }

        $this->animal->update($data);
    }

    public function delete(Animal $animal)
    {
        // Delete all associated images
        if ($animal->pictures && ! empty($animal->pictures)) {
            $this->deleteAllAnimalImages($animal->pictures);
        }

        $animal->delete();
    }

    public function addImageInput(): void
    {
        $this->images[] = null;
    }

    public function removeImageInput(int $index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeExistingImage(int $index): void
    {
        if ($this->pictures && isset($this->pictures[$index])) {
            $filename = $this->pictures[$index]['filename'] ?? null;
            if ($filename) {
                $this->deleteAnimalImage($filename);
            }
            unset($this->pictures[$index]);
            $this->pictures = array_values($this->pictures);
        }
    }
}
