<?php

use App\Models\Breed;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function breeds()
    {
        return Breed::paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/breeds/index.th_preview') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/breeds/index.th_breed_name') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/breeds/index.th_specie') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->breeds as $breed)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $breed->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $breed->name }}"/>

                    <livewire:cell type="text" content="{{ $breed->name }}"/>

                    <livewire:cell type="badge" content="{{ $breed->specie->name }}"/>

                    <livewire:cell type="button" />
                </tr>
            @empty
                <tr>
                    <td class="h-32 text-center text-sm text-muted-foreground">
                        {{ __('pagination.no_data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="h-14 px-6 flex align-center">
        {{ $this->breeds->links() }}
    </div>
</div>
