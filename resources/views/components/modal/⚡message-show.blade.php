<?php

use App\Models\Message;
use Livewire\Component;

new class extends Component {
    public Message $message;

    public function delete()
    {
        $this->dispatch("delete-message", messageId: $this->message->id);
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/messages/index.title') }}"
        current_page="{{ __('pages/messages/index.message_title') }}"
    />

    <x-modal.content>
        {{-- Message type badge --}}
        <div class="flex gap-2 mb-5">
            <span
                class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
            >
                {{ $message->type->label() }}
            </span>
        </div>

        {{-- Row --}}
        <div class="flex justify-between items-center flex-wrap gap-2">
            {{-- Left side --}}
            <div class="flex gap-2 flex-wrap">
                {{-- Sender name --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $message->contact?->name ?? __("dates.not_available") }}
                </span>

                {{-- Sender email --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $message->contact?->email ?? __("dates.not_available") }}
                </span>

                {{-- Sender phone --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $message->contact?->phone ?? __("dates.not_available") }}
                </span>

                {{-- Sender address --}}
                @if ($message->contact?->address)
                    <span
                        class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                    >
                        {{ $message->contact->address }}
                    </span>
                @endif
            </div>

            {{-- Right side --}}
            <div class="flex gap-2">
                {{-- Created at --}}
                <span
                    class="h-6 px-2 inline-flex items-center justify-center bg-secondary border border-border rounded-md text-xs font-medium"
                >
                    {{ $message->formatted_date }}
                </span>
            </div>
        </div>

        {{-- Separator --}}
        <div
            class="bg-input mt-4.5 mb-7 -mx-1 my-1 h-px"
            role="separator"
            aria-orientation="horizontal"
        ></div>

        {{-- Message content --}}
        <p class="text-base font-normal text-muted-foreground">
            {{ $message->message }}
        </p>
    </x-modal.content>

    <x-modal.footer>
        @can("delete", $message)
            <x-button
                variant="destructive"
                size="sm"
                wire:click="delete"
                wire:confirm="{{ __('modals/modals.confirm_delete_messages') }}"
            >
                {{ __("modals/modals.button_delete") }}
            </x-button>
        @endcan
    </x-modal.footer>
</x-modal>
