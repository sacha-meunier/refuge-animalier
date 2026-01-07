<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
};
?>

<div class="w-full">
    <livewire:page-header
        :title="__('pages/contacts/index.title')"
    />
    <livewire:actions-bar
        :searchPlaceholder="__('pages/contacts/index.action_bar_search_label')"
        :showFilters="false"
    />
    <livewire:tables.contacts/>
</div>
