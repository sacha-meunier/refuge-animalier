<?php

use App\Models\Animal;
use Livewire\Component;

new class extends Component {
    public Animal $animal;
};
?>

<x-modal>
    <x-modal.header
        :breadcrumb="[
            ['label' => __('pages/animals/index.title'), /*'route' => 'animals.index'*/],
            ['label' => $animal?->name]
        ]"
    />

    <x-modal.content>
        {{-- Name --}}
        <span class="text-2xl mb-5">{{ $animal->name }}</span>

        {{-- Row --}}
        <div class="flex justify-between">
            {{-- Left side --}}
            <div class="flex gap-2">
                {{-- Breed --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
            ">{{ $animal->breed->name }}</span>

                {{-- Gender --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
            ">{{ $animal->gender->label() }}</span>

                {{-- Breed --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
            ">{{ $animal->formatted_age }}</span>

                {{-- Coat --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
                ">{{ $animal->coat->name }}</span>
            </div>

            {{-- Right side--}}
            <div class="flex gap-2">
                {{-- Admission Date --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
            ">{{ $animal->formatted_admission_date }}</span>

                {{-- Adoption Status --}}
                <span class="
                h-6 px-2 inline-flex items-center justify-center
                bg-secondary border border-border rounded-md text-xs font-medium
            ">{{ $animal->status->label() }}</span>
            </div>
        </div>

        <div class="bg-input mt-4.5 mb-7 -mx-1 my-1 h-px" role="separator" aria-orientation="horizontal"></div>

        {{-- Description --}}
        <p class="text-base font-normal text-muted-foreground">{{ $animal->description }}</p>
    </x-modal.content>

    <x-modal.footer>
        @can("update", $animal)
            <x-button
                type="button"
                variant="primary"
                size="sm"
            >
                {{ __('modals/modals.button_edit') }}
            </x-button>
        @endcan

        @can("publish", $animal)
            @if ($animal->status->value === "in_progress")
                <x-button
                    size="sm"
                    {{--wire:click="publish"--}}
                >
                    {{ __('modals/modals.button_publish') }}
                </x-button>
            @endif
        @endcan

        @can("delete", $animal)
            <x-button
                variant="destructive"
                size="sm"
                wire:confirm="{{ __('modals/modals.confirm_delete') }}"
            >
                {{ __('modals/modals.button_delete') }}
            </x-button>
        @endcan
    </x-modal.footer>
</x-modal>
