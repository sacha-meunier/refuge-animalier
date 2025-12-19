<?php

use Livewire\Component;
use App\Models\Note;

new class extends Component
{
    // Column definitions for each tab
    public function getNotesColumns(): array
    {
        return [
            [
                "key" => "title",
                "label" => "Title",
                "type" => "text",
            ],
            [
                "key" => "animal",
                "label" => "Animal",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "author",
                "label" => "Animal",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
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
    public function getNotesData(): array
    {
        return [
            [
                "id" => 1,
                "title" => "Blessure lors d'une interaction",
                "animal" => "Roscoe",
                "author" => "Justine Marchand",
                "date" => "Il y a 5 minutes",
            ],
            [
                "id" => 1,
                "title" => "Morsure avec un autre chien",
                "animal" => "Jack",
                "author" => "Esteban Ocon",
                "date" => "Il y a 3 jours",
            ],
        ];
    }
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
    <livewire:data-table
        :columns="$this->getNotesColumns()"
        :data="$this->getNotesData()"
        showCheckbox="true"
        showActions="true"
        enablePagination="false"
    />
</div>
