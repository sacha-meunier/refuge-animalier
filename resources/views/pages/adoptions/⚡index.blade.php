<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header title="{{ __('pages/adoptions/index.title') }}"/>
    <livewire:actions-bar
        searchPlaceholder="{{ __('pages/adoptions/index.action_bar_search_label')}}"
        showFilters="true"
    />
    <livewire:tables.adoptions/>
</div>
