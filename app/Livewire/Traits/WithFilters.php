<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

trait WithFilters
{
    public bool $showFilters = false;
    public array $filters = [];

    #[On("toggle-filters")]
    public function toggleFilters(): void
    {
        $this->showFilters = !$this->showFilters;
    }

    public function closeFilters(): void
    {
        $this->showFilters = false;
    }

    public function resetFilters(): void
    {
        $this->filters = [];
        $this->showFilters = false;
        $this->resetItems();
    }

    public function setFilter(string $key, mixed $value): void
    {
        $this->filters[$key] = $value;
        $this->showFilters = false;
        $this->resetItems();
    }

    protected function hasActiveFilters(): bool
    {
        return !empty(array_filter($this->filters, fn($value) => $value !== null && $value !== ''));
    }

    protected function getFilterValue(string $key): mixed
    {
        return $this->filters[$key] ?? null;
    }
}
