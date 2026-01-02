<?php

namespace App\Livewire\Traits;

trait WithBulkActions
{
    public array $selectedIds = [];
    public bool $selectAll = false;

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedIds = $this->getItems()->pluck('id')->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function updatedSelectedIds(): void
    {
        $this->selectAll = count($this->selectedIds) === $this->getItems()->count()
            && count($this->selectedIds) > 0;
    }

    public function deleteSelected(): void
    {
        foreach ($this->selectedIds as $id) {
            $item = $this->getModelClass()::findOrFail($id);
            $this->authorize('delete', $item);
            $this->form->delete($item);
        }

        $this->selectedIds = [];
        $this->selectAll = false;
        $this->resetItems();
    }

    public function deleteItemOrSelected(int $itemId): void
    {
        if (count($this->selectedIds) > 0) {
            $this->deleteSelected();
        } else {
            $item = $this->getModelClass()::findOrFail($itemId);
            $this->authorize('delete', $item);
            $this->form->delete($item);
            $this->resetItems();
        }
    }

    /**
     * Get the items collection (must be implemented by the component)
     */
    abstract protected function getItems();

    /**
     * Get the model class (must be implemented by the component)
     */
    abstract protected function getModelClass(): string;

    /**
     * Reset the items computed property (must be implemented by the component)
     */
    abstract protected function resetItems(): void;
}
