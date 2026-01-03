@php
    $currentRoute = request()
        ->route()
        ->getName();
@endphp

<footer class="w-full border-t border-border/40 bg-background mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="space-y-4">
                <x-client.app-logo/>
            </div>

            <!-- Navigation -->
            <div class="space-y-4" id="footer-navigation">
                <h3 class="text-sm font-medium text-foreground">
                    {{ __('client.footer_navigation') }}
                </h3>
                <nav
                    class="flex flex-col gap-2"
                    aria-label="{{ __('client.aria_footer_nav') }}"
                >
                    <a
                        href="{{ route('home') }}"
                        class="text-sm text-muted-foreground hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.nav_home') }}
                    </a>
                    <a
                        href="{{ route('animals.index') }}"
                        class="text-sm text-muted-foreground hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.nav_animals') }}
                    </a>
                    <a
                        href="{{ route('volunteer.create') }}"
                        class="text-sm text-muted-foreground hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.nav_volunteer') }}
                    </a>
                    <a
                        href="{{ route('contact.create') }}"
                        class="text-sm text-muted-foreground hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.nav_contact') }}
                    </a>
                </nav>
            </div>

            <!-- Contact -->
            <div class="space-y-4">
                <h3 class="text-sm font-medium text-foreground">
                    {{ __('client.footer_contact') }}
                </h3>
                <div class="flex flex-col gap-2 text-sm text-muted-foreground">
                    <a
                        href="tel:+32493334161"
                        class="hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.phone') }}
                    </a>
                    <a
                        href="mailto:{{ __('client.email') }}"
                        class="hover:text-foreground transition-colors select-none"
                    >
                        {{ __('client.email') }}
                    </a>
                </div>
            </div>

            <!-- Address & Schedule -->
            <div class="space-y-4">
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-foreground">
                        {{ __('client.footer_address') }}
                    </h3>
                    <address class="text-sm text-muted-foreground not-italic">
                        {{ __('client.address_street') }}<br />
                        {{ __('client.address_city') }}
                    </address>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-foreground">
                        {{ __('client.footer_schedule') }}
                    </h3>
                    <div class="text-sm text-muted-foreground space-y-1">
                        <p>{{ __('client.schedule_weekday') }}</p>
                        <p>{{ __('client.schedule_weekend') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-12 pt-8 border-t border-border/40">
            <p class="text-sm text-muted-foreground text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
