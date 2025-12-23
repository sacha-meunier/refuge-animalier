<?php

use App\Models\Animal;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function animals()
    {
        return Animal::paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_animal_name') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_age') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_gender') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_status') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/animals/index.th_admission_date') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->animals as $animal)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $animal->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $animal->name }}"/>

                    <livewire:cell type="text" content="{{ $animal->formatted_age }}"/>

                    <livewire:cell type="text" content="{{ $animal->gender->label() }}"/>

                    <livewire:cell type="badge" content="{{ $animal->status->label() }}"/>

                    <livewire:cell type="text" content="{{ $animal->formatted_admission_date }}"/>

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
        {{ $this->animals->links() }}
    </div>
</div>
