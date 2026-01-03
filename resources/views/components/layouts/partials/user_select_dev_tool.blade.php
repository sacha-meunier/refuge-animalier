@props([
    'type' => 'list',
    'user',
])
@if(config('app.debug'))

    @switch($type)
        @case('list')
            <section class="flex flex-col gap-2 p-2 bg-yellow-500/10 border border-yellow-500/50 rounded">
                <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">🛠️ Dev Tools</span>
                <div class="flex flex-col gap-1 text-muted-foreground">
                    <a href="{{ route('dev.login-as', 'admin@admin.com') }}"
                       class="text-xs hover:underline hover:text-foreground {{ $user->email === 'admin@admin.com' ? 'text-foreground' : '' }}"
                       wire:navigate>
                        → Admin
                    </a>
                    <a href="{{ route('dev.login-as', 'volunteer@volunteer.com') }}"
                       class="text-xs hover:underline hover:text-foreground {{ $user->email === 'volunteer@volunteer.com' ? 'text-foreground' : '' }}"
                       wire:navigate>
                        → Volunteer
                    </a>
                </div>
            </section>
        @break

        @case('select')
            <section class="flex flex-col gap-2 p-2 bg-yellow-500/10 border border-yellow-500/50 rounded">
                <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">🛠️ Dev Tools</span>
                <select
                    onchange="window.location.href = this.value"
                    class="text-xs p-1 rounded bg-background border"
                >
                    <option disabled>Switch user...</option>
                    <option value="{{ route('dev.login-as', 'admin@admin.com') }}"
                        {{ $user->email === 'admin@admin.com' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="{{ route('dev.login-as', 'volunteer@volunteer.com') }}"
                        {{ $user->email === 'volunteer@volunteer.com' ? 'selected' : '' }}>
                        Volunteer
                    </option>
                </select>
            </section>
        @break
    @endswitch
@endif
