<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

trait WithModal
{
    public ?int $selectedItemId = null;
    public ?string $modalMode = null;

    #[On('open-create-modal')]
    public function openCreateModal(): void
    {
        $this->selectedItemId = null;
        $this->modalMode = 'create';
    }

    #[On('close-modal')]
    public function closeModal(): void
    {
        $this->selectedItemId = null;
        $this->modalMode = null;
    }

    public function showItem(int $itemId): void
    {
        $this->selectedItemId = $itemId;
        $this->modalMode = 'show';
    }

    #[On('switch-to-edit-mode')]
    public function editItem(?int $itemId = null): void
    {
        if ($itemId) {
            $this->selectedItemId = $itemId;
        }
        $this->modalMode = 'edit';
    }

    #[Computed]
    public function selectedItem(): ?Model
    {
        if (!$this->selectedItemId) {
            return null;
        }

        $modelClass = $this->getModelClass();

        return $modelClass::find($this->selectedItemId);
    }

    #[On('delete-item')]
    public function deleteItem(int $itemId): void
    {
        $modelClass = $this->getModelClass();

        $item = $modelClass::findOrFail($itemId);
        $this->authorize('delete', $item);

        $this->form->delete($item);

        $this->closeModal();
        $this->resetItems();
    }

    /**
     * Get the model class (must be implemented by the component)
     */
    abstract protected function getModelClass(): string;

    /**
     * Reset the items computed property (must be implemented by the component)
     */
    abstract protected function resetItems(): void;
}
