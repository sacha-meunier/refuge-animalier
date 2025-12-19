<?php

use Livewire\Component;
use App\Models\Animal;

new class extends Component
{
    // Column definitions for each tab
    public function getAnimalsColumns(): array
    {
        return [
            [
                "key" => "animal",
                "label" => "Animal",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "age",
                "label" => "Age",
                "type" => "text",
                "muted" => true,
            ],
            [
                "key" => "vaccine",
                "label" => "Vaccines",
                "type" => "text",
            ],
            [
                "key" => "adoption",
                "label" => "Adoption",
                "type" => "badge",
            ],
            [
                "key" => "status",
                "label" => "Status",
                "type" => "badge",
            ],
            [
                "key" => "date",
                "label" => "Date",
                "type" => "text",
                "muted" => true,
            ],
        ];
    }

    // Static data for demo
    public function getAnimalsData(): array
    {
        return [
            [
                "id" => 1,
                "animal" => "Dimitri",
                "age" => "2yo",
                "vaccine" => "ERC",
                "adoption" => "Adopted",
                "status" => "Validated",
                "date" => "Il y a 5 minutes",
            ],
            [
                "id" => 1,
                "animal" => "Jack",
                "age" => "5yo",
                "vaccine" => "ERC",
                "adoption" => "Pending",
                "status" => "Validated",
                "date" => "Il y a 10 heures",
            ],
        ];
    }
};
?>

<div class="w-full">
    <livewire:page-header
        title="{{ __('pages/animals/index.title') }}"
        showAction="true"
        actionLabel="{{ __('pages/animals/index.header_action_label') }}"
        actionPermission="create"
        :actionModel="Animal::class"
    />
    <livewire:actions-bar
        searchPlaceholder="{{ __('pages/animals/index.action_bar_search_label')}}"
        showFilters="true"
    />
    <livewire:data-table
        :columns="$this->getAnimalsColumns()"
        :data="$this->getAnimalsData()"
        showCheckbox="true"
        showActions="true"
        enablePagination="false"
    />
</div>
