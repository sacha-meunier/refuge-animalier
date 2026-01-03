<?php

use App\Livewire\Forms\AdoptionForm;
use App\Models\Adoption;
use Livewire\Component;

new class extends Component {
    public AdoptionForm $form;
    public Adoption $adoption;
    public array $statuses;

    public function delete()
    {
        $this->dispatch("delete-item", itemId: $this->adoption->id);
    }

    public function notify()
    {
        return null;
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/adoptions/index.title') }}"
        current_page="{{ $adoption->animal?->name }}"
    />

    <x-modal.content>
        {{-- Animal & Adopter row --}}
        <div class="grid grid-cols-3 mb-6">
            {{-- Animal --}}
            <div class="flex items-center gap-4">
                <x-avatar
                    :name="$adoption->animal?->name ?? ''"
                    :image="$adoption->animal?->image"
                    size="sm"
                    shape="circle"
                />
                <div class="flex flex-col">
                    <span class="text-sm text-muted-foreground">
                        {{ __("pages/adoptions/show.animal") }}
                    </span>
                    <span class="text-xl font-semibold">
                        {{ $adoption->animal?->name }}
                    </span>
                </div>
            </div>

            {{-- Heart icon --}}
            <x-svg.heart size="md" class="justify-self-center text-pink-500 mx-6"/>

            {{-- Adopter --}}
            <div class="flex items-center gap-4">
                <div class="flex flex-col text-right">
                    <span class="text-sm text-muted-foreground">
                        {{ __("pages/adoptions/show.adopter") }}
                    </span>
                    <span class="text-xl font-semibold">
                        {{ $adoption->contact?->name }}
                    </span>
                </div>
                <x-avatar
                    :name="$adoption->contact?->name ?? ''"
                    size="sm"
                    shape="circle"
                />
            </div>
        </div>

        {{-- Status & Date row --}}
        <div class="flex items-center justify-between">
            {{-- Status --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-muted-foreground">
                    {{ __("pages/adoptions/show.status") }} :
                </span>
                <x-badge :color="$adoption->status?->color()">
                    {{ $adoption->status?->label() }}
                </x-badge>
            </div>

            {{-- Date --}}
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium">
                    {{ $adoption->created_at?->translatedFormat("d F Y") }}
                </span>
                <span class="text-muted-foreground">•</span>
                <span class="text-sm text-muted-foreground">
                    {{ $adoption->formatted_date }}
                </span>
            </div>
        </div>

        {{-- Separator --}}
        <div class="w-full border-t border-input my-6 flex-shrink-0"></div>

        {{-- Contact details --}}
        <div class="">
            <h3 class="text-sm font-semibold mb-4">
                {{ __("pages/adoptions/show.contact_details") }}
            </h3>

            <div class="flex items-center justify-between py-2">
                <span class="text-sm text-muted-foreground w-32">
                    {{ __("pages/adoptions/show.email") }}
                </span>
                <span class="text-sm flex-1">
                    {{ $adoption->contact?->email }}
                </span>
                <x-copy-button :content="$adoption->contact?->email"/>
            </div>

            <div class="flex items-center justify-between py-2">
                <span class="text-sm text-muted-foreground w-32">
                    {{ __("pages/adoptions/show.phone") }}
                </span>
                <span class="text-sm flex-1">
                    {{ $adoption->contact?->phone }}
                </span>
                <x-copy-button :content="$adoption->contact?->phone"/>
            </div>
        </div>

        {{-- Separator --}}
        <div class="w-full border-t border-input my-6 flex-shrink-0"></div>

        {{-- Message --}}
        <div>
            <h3 class="text-sm font-semibold mb-4">
                {{ __("pages/adoptions/show.message_from", ["name" => $adoption->contact?->name]) }}
            </h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
                {{ $adoption->content ?? __("pages/adoptions/show.no_message") }}
            </p>
        </div>
    </x-modal.content>

    <x-modal.footer>
        @can("update", $adoption)
            <x-button type="button" variant="secondary" size="sm" wire:click="notify">
                {{ __("pages/adoptions/show.notify_by_email", ["name" => $adoption->contact?->name]) }}
                <x-svg.bell size="sm" class="ml-2"/>
            </x-button>

            <x-button
                type="button"
                variant="primary"
                size="sm"
                wire:click="$dispatch('switch-to-edit-mode')"
            >
                {{ __("pages/adoptions/show.change_status") }}
                <x-svg.send size="sm" class="ml-2"/>
            </x-button>
        @endcan
    </x-modal.footer>
</x-modal>
