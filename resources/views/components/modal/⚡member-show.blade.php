<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public User $member;

    public function delete()
    {
        $this->dispatch("delete-member", memberId: $this->member->id);
    }
};
?>

<x-modal>
    <x-modal.header
        old_page="{{ __('pages/members/index.title') }}"
        current_page="{{ $member?->name }}"
    />

    <x-modal.content>
        <div class="space-y-6">
            {{-- Member Info --}}
            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-1">
                        {{ __("modals/members/show.field_name") }}
                    </label>
                    <p class="text-lg font-semibold text-foreground">
                        {{ $member->name }}
                    </p>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-1">
                        {{ __("modals/members/show.field_email") }}
                    </label>
                    <p class="text-foreground">{{ $member->email }}</p>
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-1">
                        {{ __("modals/members/show.field_role") }}
                    </label>
                    <x-badge class="w-fit" color="{{ $member->role->color() }}">
                        {{ $member->role->label() }}
                    </x-badge>
                </div>

                {{-- Account Status --}}
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-1">
                        {{ __("modals/members/show.field_status") }}
                    </label>
                    <div class="flex items-center gap-2">
                        @if ($member->email_verified_at)
                            <x-badge color="green">
                                {{ __("modals/members/show.status_verified") }}
                            </x-badge>
                            <span class="text-xs text-muted-foreground">
                                {{ $member->email_verified_at->format("d/m/Y") }}
                            </span>
                        @else
                            <x-badge color="orange">
                                {{ __("modals/members/show.status_not_verified") }}
                            </x-badge>
                        @endif
                    </div>
                </div>

                {{-- Member Since --}}
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-1">
                        {{ __("modals/members/show.field_member_since") }}
                    </label>
                    <p class="text-foreground">
                        {{ $member->created_at->format("d/m/Y") }}
                        <span class="text-xs text-muted-foreground">
                            ({{ $member->created_at->diffForHumans() }})
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </x-modal.content>

    <x-modal.footer>
        @can("delete", $member)
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
