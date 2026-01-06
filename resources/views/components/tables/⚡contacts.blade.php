<?php

use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $paginate = 10;

    #[Computed]
    public function contacts()
    {
        return Contact::withCount("adoptions")->paginate($this->paginate);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

                <livewire:cell tag="th" type="text" content="{{ __('pages/contacts/index.th_name') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/contacts/index.th_email') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/contacts/index.th_phone') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/contacts/index.th_adoptions') }}" />

                <livewire:cell tag="th" type="text" content="{{ __('pages/contacts/index.th_created_at') }}" />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->contacts as $contact)
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $contact->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $contact->name }}"/>

                    <livewire:cell type="text" content="{{ $contact->email }}"/>

                    <livewire:cell type="text" content="{{ $contact->phone }}"/>

                    <livewire:cell type="text" content="{{ $contact->adoptions_count }}"/>

                    <livewire:cell type="text" content="{{ $contact->formatted_date }}" muted="true"/>

                    <livewire:cell type="button" />
                </tr>
            @empty
                <x-table.empty />
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->contacts->links() }}
    </div>
</div>
