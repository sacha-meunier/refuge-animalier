<?php

use App\Enums\UserRole;
use App\Livewire\Forms\MemberForm;
use App\Livewire\Traits\WithBulkActions;
use App\Livewire\Traits\WithFilters;
use App\Livewire\Traits\WithModal;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithSorting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

    public MemberForm $form;
    public int $paginate = 10;

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where("name", "like", "%" . $this->search . "%");
            })
            ->when($this->getFilterValue("role"), function ($query, $role) {
                $query->where("role", $role);
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->paginate);
    }

    #[Computed(persist: true)]
    public function roles()
    {
        return UserRole::cases();
    }

    #[Computed]
    public function roleCounts()
    {
        $counts = User::query()
            ->selectRaw("role, COUNT(*) as count")
            ->groupBy("role")
            ->pluck("count", "role");

        return collect(UserRole::cases())->mapWithKeys(function ($role) use (
            $counts,
        ) {
            return [$role->value => $counts[$role->value] ?? 0];
        });
    }

    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getItems()
    {
        return $this->users;
    }

    protected function resetItems(): void
    {
        unset($this->users);
    }

    #[On('delete-user')]
    public function deleteUser(int $userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        $this->form->delete($user);

        $this->closeModal();
        unset($this->users);
    }

    #[On("refresh-members")]
    public function refreshMembers()
    {
        $this->resetItems();
        $this->closeModal();
    }
};
?>

<div>
    <x-filters-popover>
        <div class="space-y-4">
            {{-- Role Filter --}}
            <div class="space-y-2">
                <label
                    for="roleFilter"
                    class="block text-sm font-medium text-foreground"
                >
                    {{ __("pages/members/index.th_role") }}
                </label>
                <select
                    id="roleFilter"
                    wire:model.live="filters.role"
                    wire:change="closeFilters"
                    class="w-full px-3 py-2 bg-background border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                >
                    <option value="">{{ __("components.all") }}</option>
                    @foreach ($this->roles as $role)
                        <option value="{{ $role->value }}">
                            {{ $role->label() }}
                            ({{ $this->roleCounts[$role->value] }})
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
            <x-table.checkbox-header/>

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/members/index.th_name')"
                :sortable="true"
                sort-field="name"
                :sort-direction="$sortField === 'name' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/members/index.th_email')"
                :sortable="true"
                sort-field="email"
                :sort-direction="$sortField === 'email' ? $sortDirection : ''"
            />

            <x-cell
                tag="th"
                type="text"
                :content="__('pages/members/index.th_role')"
                :sortable="true"
                sort-field="role"
                :sort-direction="$sortField === 'role' ? $sortDirection : ''"
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
        @forelse ($this->users as $user)
            <x-table.row :item="$user">
                <x-table.checkbox-cell :value="$user->id"/>

                <x-cell type="text" :content="$user->name"/>

                <x-cell type="text" :content="$user->email"/>

                <x-cell type="badge" :content="$user->role->label() ?? __('dates.not_available')"
                        :badge-color="$user->role->color() ?? ''"/>

                <x-table.actions
                    :item="$user"
                    :selectedIds="$selectedIds"
                />
            </x-table.row>
        @empty
            <x-table.empty/>
        @endforelse
        </tbody>
    </table>

    <div class="h-14 px-6 flex align-center">
        {{ $this->users->links() }}
    </div>

    @if ($selectedItemId && $this->selectedItem && $modalMode === "show")
        <livewire:modal.member-show
            :member="$this->selectedItem"
            :key="'member-show-'.$selectedItemId"
        />
    @endif

    @if ($modalMode === "create")
        <livewire:modal.member-create
            :roles="$this->roles"
            :key="'member-create'"
        />
    @endif
</div>
