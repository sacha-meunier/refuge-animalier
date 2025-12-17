<?php

use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Note;
use App\Models\User;
use Livewire\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }
};
?>

<nav class="bg-sidebar text-sidebar-foreground w-2xs flex flex-col gap-7 p-4">
    <header>
        <a class="flex items-center gap-2 h-8 px-2 rounded-lg hover:bg-sidebar-accent/60 hover:text-sidebar-accent-foreground transition-all duration-150"
           href="{{ route('dashboard') }}" wire:navigate>
            <x-app-logo-icon class="size-5"/>
            <span class="text-base">Refuge Animalier</span>
        </a>
    </header>

    <main class="flex flex-col gap-6 h-full">
        <section class="flex flex-col gap-2">
            <x-sidebar_link route="{{ route('dashboard') }}" page="dashboard" icon="dashboard"/>

            @can('view-any', Animal::class)
                <x-sidebar_link route="{{ route('animals.index') }}" page="animals" icon="dog"/>
            @endcan

            @can('view-any', Adoption::class)
                <x-sidebar_link route="{{ route('adoptions.index') }}" page="adoptions" icon="messages"/>
            @endcan

            @can('view-any', Note::class)
                <x-sidebar_link route="{{ route('notes.index') }}" page="notes" icon="files"/>
            @endcan
        </section>

        @if(Auth()->user()->isAdmin())
            <section class="flex flex-col">
                <span class="h-7 px-1.5 text-muted-foreground text-sm">Admin</span>
                <div class="flex flex-col gap-2">
                    <x-sidebar_link route="{{ route('members.index') }}" page="members" icon="users"/>
                    <x-sidebar_link route="{{ route('database.index') }}" page="database" icon="database"/>
                </div>
            </section>
        @endif

    </main>

    <x-layouts.partials.user_select_dev_tool :user="$user"/>

    <footer class="flex flex-col gap-2">
        <div x-data="{ open: false }" class="relative">
            <button
                @click="open = !open"
                class="flex w-full items-center gap-2 px-2 py-2 transition-all duration-150 rounded-lg hover:bg-sidebar-accent/60 hover:text-sidebar-accent-foreground"
                type="button" aria-haspopup="menu" aria-expanded="true" aria-controls="user_modal">
                <x-avatar
                    name="{{ $user->name }}"
                    image="{{ $user->avatar }}"
                    size="sm"
                    shape="square"
                />
                <div class="grid w-full text-left">
                    <span class="text-sm truncate"> {{ $user->name }}</span>
                    <span class="text-xs truncate">{{ $user->email }}</span>
                </div>
                <x-svg.chevron-up-down class="size-4"/>
            </button>

            <div x-show="open"
                 x-cloak
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute bottom-full left-0 mb-2 bg-popover w-60 text-popover-foreground z-50 border border-border p-1 shadow-md rounded-md"
                 aria-labelledby="user_modal">
                <div class="flex w-full items-center gap-2 px-2 py-2">
                    <x-avatar
                        name="{{ $user->name }}"
                        image="{{ $user->avatar }}"
                        size="sm"
                        shape="square"
                    />
                    <div class="grid w-full text-left">
                        <span class="text-sm truncate"> {{ $user->name }}</span>
                        <span class="text-xs truncate">{{ $user->email }}</span>
                    </div>
                </div>

                <div class="bg-input -mx-1 my-1 h-px" role="separator" aria-orientation="horizontal"></div>

                <x-sidebar_link route="{{ route('settings.index') }}" page="settings" icon="settings"/>

                <div class="bg-input -mx-1 my-1 h-px" role="separator" aria-orientation="horizontal"></div>

                <form method="POST" action="{{ route("logout") }}" class="w-full">
                    @csrf
                    <button type="submit" class="
                    flex items-center gap-2
                    text-sm capitalize
                    h-8 px-2 w-full
                    transition-all duration-150
                    rounded-lg
                    hover:bg-sidebar-accent/60 hover:text-sidebar-accent-foreground
                    cursor-pointer
                ">
                        <x-svg.logout class="text-muted-foreground"/>
                        <span class="translate-y-0.5">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </footer>
</nav>
