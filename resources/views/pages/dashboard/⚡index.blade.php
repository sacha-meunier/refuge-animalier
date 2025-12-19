<?php

use Livewire\Component;

new class extends Component {
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
                "id" => 0,
                "animal" => "Dimitri",
                "age" => "2yo",
                "vaccine" => "ERC",
                "adoption" => "Adopted",
                "status" => "Validated",
                "date" => "5 min ago",
            ],
            [
                "id" => 1,
                "animal" => "Jack",
                "age" => "5yo",
                "vaccine" => "ERC",
                "adoption" => "Pending",
                "status" => "Validated",
                "date" => "10 hours ago",
            ],
        ];
    }

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
                "id" => 0,
                "animal" => "Dimitri",
                "adopter" => "Bruno Marée",
                "status" => "In treatment",
                "date" => "5 min ago",
            ],
            [
                "id" => 1,
                "animal" => "Daniel",
                "adopter" => "Jack",
                "status" => "Accepted",
                "date" => "3 days ago",
            ],
        ];
    }

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
                "id" => 0,
                "title" => "Roscoe has a broken leg",
                "animal" => "Roscoe",
                "author" => "Justine Marchand",
                "date" => "5 min ago",
            ],
            [
                "id" => 1,
                "title" => "Jack needs to be vaccinated",
                "animal" => "Jack",
                "author" => "Esteban Ocon",
                "date" => "3 days ago",
            ],
        ];
    }
};
?>

<div class="w-full">
    <livewire:page-header title="{{ __('pages/dashboard/index.title') }}"/>
    {{-- Stats--}}
    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_stats') }}</h2>
        <div class="grid grid-cols-3 gap-6">
            <div class="p-6 flex flex-col gap-1.5 bg-card border border-border rounded-2xl">
                <p class="text-sm text-muted-foreground">{{ __('pages/dashboard/index.stats_title_card_1') }}</p>
                <span class="text-3xl text-card-foreground">256</span> {{-- TODO add dynamic number --}}
            </div>
            <div class="p-6 flex flex-col gap-1.5 bg-card border border-border rounded-2xl">
                <p class="text-sm text-muted-foreground">{{ __('pages/dashboard/index.stats_title_card_2') }}</p>
                <span class="text-3xl text-card-foreground">256</span> {{-- TODO add dynamic number --}}
            </div>
            <div class="p-6 flex flex-col gap-1.5 bg-card border border-border rounded-2xl">
                <p class="text-sm text-muted-foreground">{{ __('pages/dashboard/index.stats_title_card_3') }}</p>
                <span class="text-3xl text-card-foreground">256</span> {{-- TODO add dynamic number --}}
            </div>
        </div>
    </section>

    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_animals') }}</h2>
        <div class="flex flex-col gap-1.5 bg-card border border-border rounded-2xl overflow-hidden">
            <livewire:data-table
                :columns="$this->getAnimalsColumns()"
                :data="$this->getAnimalsData()"
                showCheckbox="true"
                showActions="true"
                enablePagination="false"
            />
        </div>
    </section>

    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_adoptions') }}</h2>
        <div class="flex flex-col gap-1.5 bg-card border border-border rounded-2xl overflow-hidden">
        <livewire:data-table
            :columns="$this->getAdoptionsColumns()"
            :data="$this->getAdoptionsData()"
            showCheckbox="true"
            showActions="true"
            enablePagination="false"
        />
        </div>
    </section>

    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_notes') }}</h2>
        <div class="flex flex-col gap-1.5 bg-card border border-border rounded-2xl overflow-hidden">
        <livewire:data-table
            :columns="$this->getNotesColumns()"
            :data="$this->getNotesData()"
            showCheckbox="true"
            showActions="true"
            enablePagination="false"
        />
        </div>
    </section>
</div>
