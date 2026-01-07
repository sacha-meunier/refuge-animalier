<?php

use Livewire\Component;
use App\Models\Adoption;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        :title="__('pages/adoptions/index.title')"
        :showAction="true"
        :actionLabel="__('pages/adoptions/index.header_action_label')"
        actionPermission="create"
        :actionModel="Adoption::class"
    />
    <livewire:actions-bar
        :searchPlaceholder="__('pages/adoptions/index.action_bar_search_label')"
        :showFilters="true"
    />
    <livewire:tables.adoptions/>
</div>
