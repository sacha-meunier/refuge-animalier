<?php

use Livewire\Component;
use App\Models\Animal;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        :title="__('pages/animals/index.title')"
        :showAction="true"
        :actionLabel="__('pages/animals/index.header_action_label')"
        actionPermission="create"
        :actionModel="Animal::class"
    />
    <livewire:actions-bar
        :searchPlaceholder="__('pages/animals/index.action_bar_search_label')"
        :showFilters="true"
    />
    <livewire:tables.animals/>
</div>
