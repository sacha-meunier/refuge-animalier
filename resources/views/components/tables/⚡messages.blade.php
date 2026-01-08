<?php

use App\Enums\MessageType;
use App\Livewire\Forms\MessageForm;
use App\Livewire\Traits\WithBulkActions;
use App\Livewire\Traits\WithFilters;
use App\Livewire\Traits\WithModal;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\Message;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination,
        WithSearch,
        WithSorting,
        WithBulkActions,
        WithModal,
        WithFilters;

    public MessageForm $form;
    public int $paginate = 10;

    protected function getModelClass(): string
    {
        return Message::class;
    }

    protected function getItems()
    {
        return $this->messages;
    }

    protected function resetItems(): void
    {
        unset($this->messages);
    }

    #[Computed(persist: true)]
    public function types()
    {
        return MessageType::cases();
    }

    #[Computed]
    public function typeCounts()
    {
        $counts = Message::query()
            ->selectRaw("type, COUNT(*) as count")
            ->groupBy("type")
            ->pluck("count", "type");

        return collect(MessageType::cases())->mapWithKeys(function ($type) use (
            $counts,
        ) {
            return [$type->value => $counts[$type->value] ?? 0];
        });
    }

    #[Computed]
    public function messages()
    {
        return Message::query()
            ->with(["contact"])
            ->when($this->search, function ($query) {
                $query
                    ->where("message", "like", "%" . $this->search . "%")
                    ->orWhereHas("contact", function ($q) {
                        $q->where(
                            "name",
                            "like",
                            "%" . $this->search . "%",
                        )->orWhere("email", "like", "%" . $this->search . "%");
                    });
            })
            ->when($this->getFilterValue("type"), function ($query, $type) {
                $query->where("type", $type);
            })
            ->when($this->sortField, function ($query) {
                if ($this->sortField === "contacts.name") {
                    $query
                        ->join(
                            "contacts",
                            "messages.contact_id",
                            "=",
                            "contacts.id",
                        )
                        ->orderBy("contacts.name", $this->sortDirection)
                        ->select("messages.*");
                } else {
                    $query->orderBy($this->sortField, $this->sortDirection);
                }
            })
            ->paginate($this->paginate);
    }

    #[On("refresh-messages")]
    public function refreshMessages()
    {
        $this->resetItems();
        $this->closeModal();
    }

    #[On("delete-message")]
    public function deleteMessage(int $messageId)
    {
        $message = Message::findOrFail($messageId);
        $this->authorize("delete", $message);

        $message->delete();

        $this->closeModal();
        unset($this->messages);
    }
};
?>

<div>
    <x-filters-popover>
        <div class="space-y-4">
            {{-- Type Filter --}}
            <div class="space-y-2">
                <label
                    for="typeFilter"
                    class="block text-sm font-medium text-foreground"
                >
                    {{ __("pages/messages/index.th_type") }}
                </label>
                <select
                    id="typeFilter"
                    wire:model.live="filters.type"
                    wire:change="closeFilters"
                    class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                >
                    <option value="">{{ __("components.all") }}</option>
                    @foreach ($this->types as $type)
                        <option value="{{ $type->value }}">
                            {{ $type->label() }}
                            ({{ $this->typeCounts[$type->value] }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Filters Button --}}
            @if ($this->hasActiveFilters())
                <div class="pt-2">
                    <x-button
                        type="button"
                        variant="outline"
                        size="sm"
                        wire:click="resetFilters"
                        class="w-full"
                    >
                        {{ __("components.reset_filters") }}
                    </x-button>
                </div>
            @endif
        </div>
    </x-filters-popover>

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
                    :content="__('pages/messages/index.th_type')"
                    :sortable="true"
                    sort-field="type"
                    :sort-direction="$sortField === 'type' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/messages/index.th_sender')"
                    :sortable="true"
                    sort-field="contacts.name"
                    :sort-direction="$sortField === 'contacts.name' ? $sortDirection : ''"
                />

                <x-cell
                    tag="th"
                    type="text"
                    :content="__('pages/messages/index.th_date')"
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
            @forelse ($this->messages as $message)
                <x-table.row :item="$message">
                    <x-table.checkbox-cell :value="$message->id" />

                    <x-cell type="text" :content="$message->type->label()" />

                    <x-cell
                        type="text"
                        :content="$message->contact?->name ?? __('dates.not_available')"
                    />

                    <x-cell type="text" :content="$message->formatted_date" />

                    <x-table.actions
                        :item="$message"
                        :selectedIds="$selectedIds"
                    />
                </x-table.row>
            @empty
                <x-table.empty />
            @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->messages->links() }}
    </div>

    @if ($selectedItemId && $this->selectedItem && $modalMode === "show")
        <livewire:modal.message-show
            :message="$this->selectedItem"
            :key="'message-show-'.$selectedItemId"
        />
    @endif
</div>
