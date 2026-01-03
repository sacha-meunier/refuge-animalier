@php
    $currentRoute = request()
        ->route()
        ->getName();
@endphp

<header class="w-full border-b border-border/60 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <x-client.app-logo />

            <!-- Desktop Navigation -->
            <nav
                class="hidden md:flex items-center gap-1"
                aria-label="{{ __("client.aria_main_nav") }}"
            >
                <x-client.nav-link
                    href="{{ route('home') }}"
                    :active="$currentRoute === 'home'"
                >
                    {{ __("client.nav_home") }}
                </x-client.nav-link>

                <x-client.nav-link
                    href="{{ route('client.animals.index') }}"
                    :active="str_starts_with($currentRoute, 'client.animals.')"
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
            <a
                href="#footer-navigation"
                class="md:hidden p-2 -mr-2 rounded-md hover:bg-accent transition-colors touch-manipulation"
                style="
                    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                    touch-action: manipulation;
                "
                aria-label="{{ __("client.aria_nav_menu") }}"
            >
                <x-svg.menu size="md" :open="false" />
            </a>
        </div>
    </div>
</header>
