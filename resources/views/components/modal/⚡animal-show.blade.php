<?php

use App\Models\Animal;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

new class extends Component {
    public Animal $animal;

    public function delete()
    {
        $this->dispatch("delete-animal", animalId: $this->animal->id);
    }

    public function togglePublish()
    {
        $this->animal->update([
            "published" => ! $this->animal->published,
        ]);

        $this->dispatch("animal-updated");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/animals/index.title') }}"
        current_page="{{ $animal?->name }}"
    />

    <x-modal.content>
        {{-- Name --}}
        <span class="text-2xl mb-5">{{ $animal->name }}</span>

        {{-- Row --}}
        <div class="flex justify-between">
            {{-- Left side --}}
            <div class="flex gap-2">
                {{-- Breed --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->breed?->name ?? __("dates.not_available") }}
                </span>

                {{-- Gender --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->gender?->label() ?? __("dates.not_available") }}
                </span>

                {{-- Age --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->formatted_age ?? __("dates.not_available") }}
                </span>

                {{-- Coat --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->coat?->name ?? __("dates.not_available") }}
                </span>
            </div>

            {{-- Right side --}}
            <div class="flex gap-2">
                {{-- Admission Date --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->formatted_admission_date ?? __("dates.not_available") }}
                </span>

                {{-- Adoption Status --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $animal->status?->label() ?? __("dates.not_available") }}
                </span>
            </div>
        </div>

        <div
            class="bg-input mt-4.5 mb-7 -mx-1 my-1 h-px"
            role="separator"
            aria-orientation="horizontal"
        ></div>

        {{-- Description --}}
        <p class="text-base font-normal text-muted-foreground">
            {{ $animal->description }}
        </p>

        @if ($animal->pictures && ! empty($animal->pictures))
            <div class="mt-7">
                <h3 class="text-sm font-medium mb-4">
                    {{ __("modals/animals/show.gallery") }}
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($animal->pictures as $picture)
                        <img
                            src="{{ Storage::disk("animals")->url(config("image.animals.variants.thumbnail.path") . "/" . $picture["filename"] . ".webp") }}"
                            alt="{{ $animal->name }}"
                            class="w-full h-32 object-cover rounded-lg border border-border"
                        />
                    @endforeach
                </div>
            </div>
        @endif
    </x-modal.content>

    <x-modal.footer>
        @can("update", $animal)
            <x-button
                type="button"
                variant="primary"
                size="sm"
                wire:click="$dispatch('switch-to-edit-mode')"
            >
                {{ __("modals/modals.button_edit") }}
            </x-button>
        @endcan

        @can("publish", $animal)
            <x-button
                size="sm"
                wire:click="togglePublish"
                variant="{{ $animal->published ? 'secondary' : 'default' }}"
            >
                {{ $animal->published ? __("modals/modals.button_unpublish") : __("modals/modals.button_publish") }}
            </x-button>
        @endcan

        @can("delete", $animal)
            <x-button
                variant="destructive"
                size="sm"
                wire:click="delete"
                wire:confirm="{{ __('modals/modals.confirm_delete') }}"
            >
                {{ __("modals/modals.button_delete") }}
            </x-button>
        @endcan
    </x-modal.footer>
</x-modal>
