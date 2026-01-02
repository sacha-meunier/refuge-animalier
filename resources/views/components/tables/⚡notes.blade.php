<?php

use App\Livewire\Forms\NoteForm;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Animal;
use App\Models\Note;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination, WithSearch, WithSorting;

    public NoteForm $form;

    public int $paginate = 10;
    public ?string $modalMode = "";
    public ?int $selectedNoteId = null;
    public array $selectedIds = [];
    public bool $selectAll = false;

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

    #[On('open-create-modal')]
    public function createNotes()
    {
        $this->selectedNoteId = null;
        $this->modalMode = "create";
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->selectedAnimalId = null;
        $this->modalMode = null;
    }

    #[On('refresh-notes')]
    public function refreshNotes()
    {
        unset($this->notes);
        $this->closeModal();
    }

    #[Computed]
    public function selectedNote()
    {
        return $this->selectedNoteId
            ? Note::find($this->selectedNoteId)
            : null;
    }

    public function showNote(int $noteId)
    {
        $this->selectedNoteId = $noteId;
        $this->modalMode = "show";
    }

    #[On('delete-note')]
    public function deleteNote(int $noteId)
    {
        $note = Note::findOrFail($noteId);
        $this->authorize('delete', $note);

        $this->form->delete($note);

        $this->closeModal();
        unset($this->notes);
    }

    #[On('switch-to-edit-mode')]
    public function editNote(?int $noteId = null)
    {
        if ($noteId) {
            $this->selectedNoteId = $noteId;
        }
        $this->modalMode = "edit";
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->notes->pluck("id")->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function deleteNoteOrSelected(int $noteId)
    {
        if (count($this->selectedIds) > 0) {
            $this->deleteSelected();
        } else {
            $note = Note::findOrFail($noteId);
            $this->authorize("delete", $note);
            $this->form->delete($note);
            unset($this->note);
        }
    }

    public function deleteSelected()
    {
        foreach ($this->selectedIds as $id) {
            $note = Note::findOrFail($id);
            $this->authorize('delete', $note);
            $this->form->delete($note);
        }

        $this->selectedIds = [];
        $this->selectAll = false;
        unset($this->notes);
    }
};
?>

<div>
    <table class="w-full h-14 border-b border-border" x-data="{ hoverAll: false }">
        <thead class="h-14 border-b border-border">
            <tr>
                <th
                    class="w-12 pl-6 pr-4 text-left text-xs font-medium text-muted-foreground tracking-wider"
                >
                    <input
                        type="checkbox"
                        class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer hover:ring-2 hover:ring-primary/50 transition-all"
                        wire:model.live="selectAll"
                        @mouseenter="hoverAll = true"
                        @mouseleave="hoverAll = false"
                    />
                </th>

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/notes/index.th_note_title') }}"
                    :sortable="true"
                    sort-field="title"
                    :sort-direction="$sortField === 'title' ? $sortDirection : ''"
                    wire:key="th-title-{{ $sortField }}-{{ $sortDirection }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/notes/index.th_animal') }}"
                    :sortable="true"
                    sort-field="animals.name"
                    :sort-direction="$sortField === 'animals.name' ? $sortDirection : ''"
                    wire:key="th-animal-{{ $sortField }}-{{ $sortDirection }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/notes/index.th_author') }}"
                    :sortable="true"
                    sort-field="users.name"
                    :sort-direction="$sortField === 'users.name' ? $sortDirection : ''"
                    wire:key="th-author-{{ $sortField }}-{{ $sortDirection }}"
                />

                <livewire:cell
                    tag="th"
                    type="text"
                    content="{{ __('pages/notes/index.th_date') }}"
                    :sortable="true"
                    sort-field="created_at"
                    :sort-direction="$sortField === 'created_at' ? $sortDirection : ''"
                    wire:key="th-date-{{ $sortField }}-{{ $sortDirection }}"
                />

                <livewire:cell tag="th" type="text" content="" class="w-12 pl-4 pr-1"/>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->notes as $note)
                <tr class="h-14 hover:bg-muted/50 cursor-pointer"
                    wire:key="note-row-{{ $note->id }}-{{ $note->updated_at->timestamp }}"
                    wire:click="showNote({{ $note->id }})"
                >
                    <td class="w-12 pl-6 pr-4" wire:click.stop>
                        <input
                            type="checkbox"
                            class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0 cursor-pointer transition-all"
                            :class="hoverAll ? 'ring-2 ring-primary/50' : 'hover:ring-2 hover:ring-primary/50'"
                            value="{{ $note->id }}"
                            wire:model.live="selectedIds"
                        />
                    </td>

                    <livewire:cell type="text" content="{{ $note->title }}"/>

                    <livewire:cell type="text" content="{{ $note->animal->name }}"/>

                    <livewire:cell type="text" content="{{ $note->user->name }}"/>

                    <livewire:cell type="text" content="{{ $note->formatted_date }}"/>

                    <livewire:cell type="button" wire:click.stop>
                        @can("update", $note)
                            <x-popover-item
                                wire:click="editNote({{ $note->id }})"
                            >
                                <x-svg.square-pen class="size-4"/>
                                {{ __("modals/modals.button_edit") }}
                            </x-popover-item>
                        @endcan

                        @can("delete", $note)
                            <x-popover-item
                                wire:click="deleteNoteOrSelected({{ $note->id }})"
                                wire:confirm="{{ count($selectedIds) ? __('modals/modals.confirm_delete_multiple') : __('modals/modals.confirm_delete') }}"
                                variant="destructive"
                            >
                                <x-svg.trash class="size-4"/>
                                @if (count($selectedIds) > 0)
                                    {{ __("modals/modals.button_delete") }}
                                    ({{ count($selectedIds) }})
                                @else
                                    {{ __("modals/modals.button_delete") }}
                                @endif
                            </x-popover-item>
                        @endcan
                    </livewire:cell>
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
        {{ $this->notes->links() }}
    </div>

    @if ($modalMode === "create")
        <livewire:modal.note-create
            :animals="$this->animals"
            :key="'note-create'"
        />
    @endif

    @if ($selectedNoteId && $this->selectedNote && $modalMode === "show")
        <livewire:modal.note-show
            :note="$this->selectedNote"
            :key="'note-show-'.$selectedNoteId"
        />
    @endif

    @if ($selectedNoteId && $this->selectedNote && $modalMode === "edit")
        <livewire:modal.note-edit
            :note="$this->selectedNote"
            :animals="$this->animals"
            :key="'note-edit-'.$selectedNoteId"
        />
    @endif
</div>
