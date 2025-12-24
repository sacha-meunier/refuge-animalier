<?php

use Livewire\Component;
use App\Models\Note;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        title="{{ __('pages/notes/index.title') }}"
        showAction="true"
        actionLabel="{{ __('pages/notes/index.header_action_label') }}"
        actionPermission="create"
        :actionModel="Note::class"
    />
    <livewire:actions-bar
        searchPlaceholder="{{ __('pages/notes/index.action_bar_search_label')}}"
        showFilters="true"
    />
    <livewire:tables.notes/>
</div>
