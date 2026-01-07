<?php

use App\Enums\UserRole;
use App\Livewire\Forms\MemberForm;
use App\Livewire\Traits\WithBulkActions;
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
    use WithPagination, WithSearch, WithSorting, WithBulkActions, WithModal;

    public MemberForm $form;
    public int $paginate = 10;

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where("name", "like", "%".$this->search."%");
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
