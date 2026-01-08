<?php

use App\Enums\UserRole;
use App\Livewire\Forms\MemberForm;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public MemberForm $form;
    public array $roles;

    public function save()
    {
        $this->authorize("create", User::class);
        $this->form->store();

        $this->dispatch("close-modal");
        $this->dispatch("refresh-members");
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/members/index.title') }}"
        current_page="{{ __('modals/members/create.breadcrumb_create') }}"
    />

    <x-modal.content>
        <form wire:submit="save">
            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">
                    {{ __("modals/members/edit.field_name") }}
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model="form.name"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.name")
                        <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">
                    {{ __("modals/members/edit.field_email") }}
                </label>
                <input
                    type="email"
                    id="email"
                    wire:model="form.email"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background"
                />
                <div>
                    @error("form.email")
                        <span class="text-destructive">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Roles --}}
            @if ($this->roles)
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        {{ __("modals/members/edit.field_role") }}
                    </label>
                    <div class="flex flex-col gap-2">
                        @foreach ($this->roles as $role)
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                                wire:key="role-{{ $role->value }}"
                            >
                                <input
                                    type="radio"
                                    name="role"
                                    value="{{ $role->value }}"
                                    wire:model="form.role"
                                    class="w-4 h-4 text-primary border-border focus:ring-primary"
                                />
                                <x-badge :color="$role->color() ?? ''">
                                    {{ $role->label() }}
                                </x-badge>
                            </label>
                        @endforeach
                    </div>
                    <div>
                        @error("form.role")
                            <span class="text-destructive">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            @endif
        </form>
    </x-modal.content>

    <x-modal.footer>
        <x-button type="button" variant="primary" size="sm" wire:click="save">
            {{ __("modals/modals.button_save") }}
        </x-button>
    </x-modal.footer>
</x-modal>
