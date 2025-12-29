<?php

use App\Models\Adoption;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function adoptions()
    {
        return Adoption::paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/adoptions/index.th_animal') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/adoptions/index.th_adopter') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/adoptions/index.th_status') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/adoptions/index.th_date') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->adoptions as $adoption)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $adoption->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $adoption->animal->name }}"/>

                    <livewire:cell type="text" content="{{ $adoption->contact->name }}"/>

                    <livewire:cell type="badge" content="{{ $adoption->status->label() }}" badge-color="{{ $adoption->status->color() }}"/>

                    <livewire:cell type="text" content="{{ $adoption->formatted_date }}" muted="true"/>

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

    <div class="h-14 px-6 flex align-center">
        {{ $this->adoptions->links() }}
    </div>
</div>
