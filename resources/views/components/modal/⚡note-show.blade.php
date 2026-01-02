<?php

use App\Models\Animal;
use App\Models\Note;
use Livewire\Component;

new class extends Component {
    public Note $note;

    public function delete()
    {
        $this->dispatch("delete-note", noteId: $this->note->id);
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/notes/index.title') }}"
        current_page="{{ $note?->title }}"
    />

    <x-modal.content>
        {{-- Note title --}}
        <span class="text-2xl mb-5">{{ $note->title }}</span>

        {{-- Row --}}
        <div class="flex justify-between">
            {{-- Left side --}}
            <div class="flex gap-2">
                {{-- Animal --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $note->animal?->name ?? __("dates.not_available") }}
                </span>

                {{-- Author --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $note->user?->name ?? __("dates.not_available") }}
                </span>
            </div>

            {{-- Right side --}}
            <div class="flex gap-2">
                {{-- Created at --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $note->formatted_date ?? __("dates.not_available") }}
                </span>
            </div>
        </div>

        {{-- Separator --}}
        <div
            class="bg-input mt-4.5 mb-7 -mx-1 my-1 h-px"
            role="separator"
            aria-orientation="horizontal"
        ></div>

        {{-- Content --}}
        <p class="text-base font-normal text-muted-foreground">
            {{ $note->content }}
        </p>
    </x-modal.content>

    <x-modal.footer>
        @can("update", $note)
            <x-button
                type="button"
                variant="primary"
                size="sm"
                wire:click="$dispatch('switch-to-edit-mode')"
            >
                {{ __("modals/modals.button_edit") }}
            </x-button>
        @endcan

        @can("delete", $note)
            <x-button
                variant="destructive"
                size="sm"
                wire:click="delete"
                wire:confirm="{{ __('modals/modals.confirm_delete_notes') }}"
            >
                {{ __("modals/modals.button_delete") }}
            </x-button>
        @endcan
    </x-modal.footer>
</x-modal>
