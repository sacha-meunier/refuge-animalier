<?php

namespace App\Livewire\Traits;

use Livewire\Attributes\On;

trait WithSearch
{
    public string $search = '';

    #[On('search-updated')]
    public function updateSearch($search)
    {
        $this->search = $search;
    }
}
