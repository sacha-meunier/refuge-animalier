<?php

use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Note;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination, WithSearch, WithSorting;

    public int $paginate = 10;

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
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
            <tr>
                <livewire:cell tag="th" type="checkbox" class="w-12 pl-6 pr-4"/>

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
                <tr class="h-14 hover:bg-muted/50" wire:key="{{ $note->id }}">
                    <livewire:cell type="checkbox" class="w-12 pl-6 pr-4" />

                    <livewire:cell type="text" content="{{ $note->title }}"/>

                    <livewire:cell type="text" content="{{ $note->animal->name }}"/>

                    <livewire:cell type="text" content="{{ $note->user->name }}"/>

                    <livewire:cell type="text" content="{{ $note->formatted_date }}"/>

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
        {{ $this->notes->links() }}
    </div>
</div>
