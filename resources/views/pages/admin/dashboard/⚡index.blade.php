<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
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
            <livewire:tables.animals :paginate="5"/>
        </div>
    </section>

    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_adoptions') }}</h2>
        <div class="flex flex-col gap-1.5 bg-card border border-border rounded-2xl overflow-hidden">
            <livewire:tables.adoptions :paginate="5"/>
        </div>
    </section>

    <section class="p-6 flex flex-col gap-2">
        <h2 class="">{{ __('pages/dashboard/index.section_title_notes') }}</h2>
        <div class="flex flex-col gap-1.5 bg-card border border-border rounded-2xl overflow-hidden">
            <livewire:tables.notes :paginate="5"/>
        </div>
    </section>
</div>
