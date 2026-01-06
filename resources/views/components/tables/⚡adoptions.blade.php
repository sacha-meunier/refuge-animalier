<?php

use App\Enums\AdoptionStatus;
use App\Livewire\Forms\AdoptionForm;
use App\Livewire\Traits\WithBulkActions;
use App\Livewire\Traits\WithModal;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination, WithSearch, WithSorting, WithBulkActions, WithModal;

    public AdoptionForm $form;
    public int $paginate = 10;

    protected function getModelClass(): string
    {
        return Adoption::class;
    }

    protected function getItems()
    {
        return $this->adoptions;
    }

    protected function resetItems(): void
    {
        unset($this->adoptions);
    }

    #[Computed]
    public function adoptions()
    {
        return Adoption::query()
            ->when($this->search, function ($query) {
                $query
                    ->where("content", "like", "%".$this->search."%")
                    ->orWhereHas("contact", function ($q) {
                        $q->where("name", "like", "%".$this->search."%");
                    })
                    ->orWhereHas("animal", function ($q) {
                        $q->where("name", "like", "%".$this->search."%");
                    });
            })
            ->when($this->sortField === 'animal', function ($query) {
                $query->join('animals', 'adoptions.animal_id', '=', 'animals.id')
                    ->orderBy('animals.name', $this->sortDirection)
                    ->select('adoptions.*');
            })
            ->when($this->sortField === 'contact', function ($query) {
                $query->join('contacts', 'adoptions.contact_id', '=', 'contacts.id')
                    ->orderBy('contacts.name', $this->sortDirection)
                    ->select('adoptions.*');
            })
            ->when($this->sortField && $this->sortField !== 'animal' && $this->sortField !== 'contact', function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->paginate);
    }


    #[Computed(persist: true)]
    public function animals()
    {
        return Animal::all();
    }

    #[Computed(persist: true)]
    public function contacts()
    {
        return Contact::all();
    }

    #[Computed(persist: true)]
    public function statuses()
    {
        return AdoptionStatus::cases();
    }

    #[On("refresh-adoptions")]
    public function refreshAdoptions()
    {
        $this->resetItems();
        $this->closeModal();
    }

    #[On("open-modal")]
    public function openModal(string $modal, array $params = [])
    {
        if (isset($params["adoption"])) {
            $this->selectedItemId = $params["adoption"];
        }

        $this->modalMode = $modal;
    }
};
?>

<div>
    <table
        class="w-full h-14 border-b border-border"
        x-data="{ hoverAll: false }"
    >
        <thead class="h-14 border-b border-border">
        <tr>
            <x-table.checkbox-header/>

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/adoptions/index.th_animal')"
                :sortable="true"
                sort-field="animal"
                :sort-direction="$sortField === 'animal' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/adoptions/index.th_adopter')"
                :sortable="true"
                sort-field="contact"
                :sort-direction="$sortField === 'contact' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/adoptions/index.th_status')"
                :sortable="true"
                sort-field="status"
                :sort-direction="$sortField === 'status' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/adoptions/index.th_date')"
                :sortable="true"
                sort-field="created_at"
                :sort-direction="$sortField === 'created_at' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                content=""
                class="w-12 pl-4 pr-1"
            />
        </tr>
        </thead>
        <tbody>
        @forelse ($this->adoptions as $adoption)
            <x-table.row :item="$adoption">
                <x-table.checkbox-cell :value="$adoption->id ?? __('dates.not_available')"/>

                <x-cell type="text" :content="$adoption->animal->name ?? __('dates.not_available')"/>

                <x-cell type="text" :content="$adoption->contact->name ?? __('dates.not_available')"/>

                <x-cell
                    type="badge"
                    :content="$adoption->status?->label() ?? __('dates.not_available')"
                    :badge-color="$adoption->status?->color() ?? ''"
                />

                <x-cell type="text" :content="$adoption->formatted_date ?? __('dates.not_available')"/>

                <x-table.actions
                    :item="$adoption"
                    :selectedIds="$selectedIds"
                />
            </x-table.row>
        @empty
            <x-table.empty/>
        @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->adoptions->links() }}
    </div>

    @if ($selectedItemId && $this->selectedItem && $modalMode === "show")
        <livewire:modal.adoption-show
            :adoption="$this->selectedItem"
            :statuses="$this->statuses"
            :key="'adoption-show-'.$selectedItemId"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "edit")
        <livewire:modal.adoption-edit
            :adoption="$this->selectedItem"
            :statuses="$this->statuses"
            :key="'adoption-edit-'.$selectedItemId"
        />
    @endif

    @if ($modalMode === "create")
        <livewire:modal.adoption-create
            :animals="$this->animals"
            :contacts="$this->contacts"
            :statuses="$this->statuses"
            :key="'adoption-create'"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "notify-confirm")
        <livewire:modal.adoption-notify-confirm
            :adoption="$this->selectedItem"
            :key="'adoption-notify-confirm-'.$selectedItemId"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "notify-compose")
        <livewire:modal.adoption-notify-compose
            :adoption="$this->selectedItem"
            :key="'adoption-notify-compose-'.$selectedItemId"
        />
    @endif
</div>
