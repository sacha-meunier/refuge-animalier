<?php

use Livewire\Component;
use App\Models\Message;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        :title="__('pages/messages/index.title')"
        showAction="false"
    />
    <livewire:actions-bar
        :searchPlaceholder="__('pages/messages/index.action_bar_search_label')"
        :showFilters="true"
    />
    <livewire:tables.messages />
</div>
