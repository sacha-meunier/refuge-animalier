@php
    $currentRoute = request()
        ->route()
        ->getName();
@endphp

<header
    class="w-full border-b border-border/60 bg-background"
    x-data="{ mobileMenuOpen: false }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a
                href="{{ route("home") }}"
                class="flex items-center gap-2 px-3 py-2 -ml-3 rounded-full hover:bg-accent/40 transition-colors select-none"
                aria-label="{{ config("app.name") }}"
            >
                <x-svg.dog size="md" class="text-foreground" />
                <span class="text-base font-medium hidden sm:inline">
                    {{ config("app.name") }}
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav
                class="hidden md:flex items-center gap-1"
                aria-label="{{ __("client.main_navigation") }}"
            >
                <x-client.nav-link
                    href="{{ route('home') }}"
                    :active="$currentRoute === 'home'"
                >
                    {{ __("client.nav_home") }}
                </x-client.nav-link>

                <x-client.nav-link
                    href="{{ route('animals.index') }}"
                    :active="str_starts_with($currentRoute, 'animals.')"
                >
                    {{ __("client.nav_animals") }}
                </x-client.nav-link>

                <x-client.nav-link
                    href="{{ route('volunteer.create') }}"
                    :active="str_starts_with($currentRoute, 'volunteer.')"
                >
                    {{ __("client.nav_volunteer") }}
                </x-client.nav-link>
            </nav>

            <!-- Contact Button (Desktop) -->
            <div class="hidden md:flex items-center gap-4">
                <a
                    href="{{ route("contact.create") }}"
                    class="px-4 py-2 bg-primary text-primary-foreground rounded-full text-sm font-medium hover:bg-primary/70 transition-colors select-none"
                >
                    {{ __("client.nav_contact") }}
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button
                type="button"
                class="md:hidden p-2 -mr-2 rounded-md hover:bg-accent transition-colors touch-manipulation"
                style="
                    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                    touch-action: manipulation;
                "
                aria-label="{{ __("client.navigation_menu") }}"
                :aria-expanded="mobileMenuOpen.toString()"
                @click="mobileMenuOpen = !mobileMenuOpen"
                aria-controls="mobile-menu"
            >
                <span x-show="!mobileMenuOpen">
                    <x-svg.menu size="md" :open="false" />
                </span>
                <span x-show="mobileMenuOpen" style="display: none">
                    <x-svg.menu size="md" :open="true" />
                </span>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div
            id="mobile-menu"
            class="md:hidden pb-4"
            x-show="mobileMenuOpen"
            x-cloak
            @click.away="mobileMenuOpen = false"
        >
            <nav
                class="flex flex-col gap-1"
                aria-label="{{ __("client.main_navigation") }}"
            >
                <x-client.nav-link
                    href="{{ route('home') }}"
                    :active="$currentRoute === 'home'"
                    class="px-4 py-3"
                >
                    {{ __("client.nav_home") }}
                </x-client.nav-link>

                <x-client.nav-link
                    href="{{ route('animals.index') }}"
                    :active="str_starts_with($currentRoute, 'animals.')"
                    class="px-4 py-3"
                >
                    {{ __("client.nav_animals") }}
                </x-client.nav-link>

                <x-client.nav-link
                    href="{{ route('volunteer.create') }}"
                    :active="str_starts_with($currentRoute, 'volunteer.')"
                    class="px-4 py-3"
                >
                    {{ __("client.nav_volunteer") }}
                </x-client.nav-link>

                <a
                    href="{{ route("contact.create") }}"
                    class="mx-4 mt-2 px-4 py-3 bg-primary text-primary-foreground rounded-full text-sm font-medium text-center hover:bg-primary/70 transition-colors select-none"
                >
                    {{ __("client.nav_contact") }}
                </a>
            </nav>
        </div>
    </div>
</header>
