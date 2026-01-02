<?php

use App\Livewire\Forms\NoteForm;
use App\Livewire\Traits\WithBulkActions;
use App\Livewire\Traits\WithModal;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Animal;
use App\Models\Note;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination, WithSearch, WithSorting, WithBulkActions, WithModal;

    public NoteForm $form;
    public int $paginate = 10;

    protected function getModelClass(): string
    {
        return Note::class;
    }

    protected function getItems()
    {
        return $this->notes;
    }

    protected function resetItems(): void
    {
        unset($this->notes);
    }

    #[Computed]
    public function notes()
    {
        return Note::query()
            ->with(["user", "animal"])
            ->when($this->search, function ($query) {
                $query
                    ->where("title", "like", "%" . $this->search . "%")
                    ->orWhere("content", "like", "%" . $this->search . "%")
                    ->orWhereHas("animal", function ($q) {
                        $q->where("name", "like", "%" . $this->search . "%");
                    })
                    ->orWhereHas("user", function ($q) {
                        $q->where("name", "like", "%" . $this->search . "%");
                    });
            })
            ->when($this->sortField, function ($query) {
                if ($this->sortField === "users.name") {
                    $query
                        ->join("users", "notes.user_id", "=", "users.id")
                        ->orderBy("users.name", $this->sortDirection)
                        ->select("notes.*");
                } elseif ($this->sortField === "animals.name") {
                    $query
                        ->join("animals", "notes.animal_id", "=", "animals.id")
                        ->orderBy("animals.name", $this->sortDirection)
                        ->select("notes.*");
                } else {
                    $query->orderBy($this->sortField, $this->sortDirection);
                }
            })
            ->paginate($this->paginate);
    }

    #[Computed(persist: true)]
    public function animals()
    {
        return Animal::all();
    }

    #[On("refresh-notes")]
    public function refreshNotes()
    {
        $this->resetItems();
        $this->closeModal();
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
                <x-table.checkbox-header />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/notes/index.th_note_title')"
                    :sortable="true"
                    sort-field="title"
                    :sort-direction="$sortField === 'title' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/notes/index.th_animal')"
                    :sortable="true"
                    sort-field="animals.name"
                    :sort-direction="$sortField === 'animals.name' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/notes/index.th_author')"
                    :sortable="true"
                    sort-field="users.name"
                    :sort-direction="$sortField === 'users.name' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/notes/index.th_date')"
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
            @forelse ($this->notes as $note)
                <x-table.row :item="$note">
                    <x-table.checkbox-cell :value="$note->id" />

                    <x-cell type="text" :content="$note->title" />

                    <x-cell type="text" :content="$note->animal->name" />

                    <x-cell type="text" :content="$note->user->name" />

                    <x-cell type="text" :content="$note->formatted_date" />

                    <x-table.actions
                        :item="$note"
                        :selectedIds="$selectedIds"
                    />
                </x-table.row>
            @empty
                <x-table.empty />
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->notes->links() }}
    </div>

    @if ($modalMode === "create")
        <livewire:modal.note-create
            :animals="$this->animals"
            :key="'note-create'"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "show")
        <livewire:modal.note-show
            :note="$this->selectedItem"
            :key="'note-show-'.$selectedItemId"
        />
    @endif

    @if ($selectedItemId && $this->selectedItem && $modalMode === "edit")
        <livewire:modal.note-edit
            :note="$this->selectedItem"
            :animals="$this->animals"
            :key="'note-edit-'.$selectedItemId"
        />
    @endif
</div>
