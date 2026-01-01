<?php

namespace App\Livewire\Traits;

trait WithSorting
{
    public string $sortField = "";
    public string $sortDirection = "asc";

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->reverseSort()
            : 'asc';
        $this->sortField = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
}
