<?php

use App\Models\Specie;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function species()
    {
        return Specie::withCount("breeds")->paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/species/index.th_preview') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/species/index.th_specie_name') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/species/index.th_associated_breeds') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->species as $specie)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $specie->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $specie->name }}"/>

                    <livewire:cell type="text" content="{{ $specie->name }}"/>

                    <livewire:cell type="text" content="{{ $specie->breeds_count }}"/>

                    <livewire:cell type="button" />
                </tr>
            @empty
                <tr>
                    <td class="h-32 text-center text-sm text-muted-foreground">
                        {{ __("No data available") }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->species->links() }}
    </div>
</div>
