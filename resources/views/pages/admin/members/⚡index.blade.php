<?php

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        title="{{ __('pages/members/index.title') }}"
        showAction="true"
        actionLabel="{{ __('pages/members/index.header_action_label') }}"
        actionPermission="create"
        :actionModel="User::class"
    />
    <livewire:actions-bar
        searchPlaceholder="{{ __('pages/members/index.action_bar_search_label')}}"
        showFilters="true"
    />
    <livewire:tables.members/>
</div>
