<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    // Column definitions for each tab
    public function getMembersColumns(): array
    {
        return [
            [
                "key" => "name",
                "label" => "Name",
                "type" => "avatar-text",
                "avatarKey" => "avatar",
            ],
            [
                "key" => "email",
                "label" => "Email",
                "type" => "text",
                "muted" => true,
            ],
            [
                "key" => "planning",
                "label" => "Planning",
                "type" => "text",
                "muted" => true,
            ],
            [
                "key" => "role",
                "label" => "role",
                "type" => "badge",
            ],
        ];
    }

    // Static data for demo
    public function getMembersData(): array
    {
        return [
            [
                "id" => 1,
                "name" => "Caleb Porzio",
                "email" => "porziocaleb@gmail.com",
                "planning" => "LMMJVSD",
                "role" => "Admin",
            ],
            [
                "id" => 2,
                "name" => "Caleb Porzio",
                "email" => "porziocaleb@gmail.com",
                "planning" => "LMMJVSD",
                "role" => "Admin",
            ],
        ];
    }

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
    <livewire:data-table
        :columns="$this->getMembersColumns()"
        :data="$this->getMembersData()"
        showCheckbox="true"
        showActions="true"
        enablePagination="false"
    />
</div>
