<?php

use Livewire\Component;

new class extends Component
{
    // Column definitions for each tab
    public function getAdoptionsColumns(): array
    {
        return [
            [
                "key" => "animal",
                "label" => "Animal",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "adopter",
                "label" => "Adoptant",
                "type" => "text",
            ],
            [
                "key" => "status",
                "label" => "Statut",
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
    public function getAdoptionsData(): array
    {
        return [
            [
                "id" => 1,
                "animal" => "Dimitri",
                "adopter" => "Bruno Marée",
                "status" => "En traitement",
                "date" => "Il y a 5 minutes",
            ],
            [
                "id" => 1,
                "animal" => "Morsure avec un autre chien",
                "adopter" => "Jack",
                "status" => "Esteban Ocon",
                "date" => "Il y a 3 jours",
            ],
        ];
    }
};
?>

<div class="w-full">
    <livewire:page-header title="{{ __('pages/adoptions/index.title') }}"/>
    <livewire:actions-bar
        searchPlaceholder="{{ __('pages/adoptions/index.action_bar_search_label')}}"
        showFilters="true"
    />
    <livewire:data-table
        :columns="$this->getAdoptionsColumns()"
        :data="$this->getAdoptionsData()"
        showCheckbox="true"
        showActions="true"
        enablePagination="false"
    />
</div>
