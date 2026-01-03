<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function users()
    {
        return User::paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/members/index.th_name') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/members/index.th_email') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/members/index.th_role') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->users as $user)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $user->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $user->name }}"/>

                    <livewire:cell type="text" content="{{ $user->email }}"/>

                    <livewire:cell type="badge" content="{{ $user->role->label() }}" badge-color="{{ $user->role->color() }}"/>

                    <livewire:cell type="button" />
                </tr>
            @empty
                <x-table.empty />
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->users->links() }}
    </div>
</div>
