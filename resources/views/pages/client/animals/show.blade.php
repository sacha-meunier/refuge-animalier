<x-client.layout>
    <x-slot:title>
        {{ $animal->name }} - {{ config("app.name") }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        {{-- Breadcrumb --}}
        <x-client.breadcrumb
            :items="[
                ['label' => __('client.nav_home'), 'url' => route('home')],
                ['label' => __('client.nav_animals'), 'url' => route('client.animals.index')],
                ['label' => $animal->name, 'url' => ''],
            ]"
        />

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Left Column: Image Gallery --}}
            <div class="space-y-4">
                {{-- Main Image --}}
                <div class="aspect-square bg-muted rounded-2xl overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                        <x-svg.dog size="2xl" class="opacity-50 w-32 h-32" />
                    </div>
                </div>

                {{-- Thumbnail Gallery (placeholder for now) --}}
                <div class="grid grid-cols-4 gap-2">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="aspect-square bg-muted rounded-lg overflow-hidden">
                            <div class="w-full h-full flex items-center justify-center">
                                <x-svg.dog size="sm" class="opacity-30" />
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Right Column: Animal Info --}}
            <div class="space-y-6">
                {{-- Header --}}
                <div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-foreground mb-2">
                        {{ $animal->name }}
                    </h1>
                    <p class="text-xl text-muted-foreground">
                        {{ $animal->breed?->name ?? __("client.unknown_breed") }}
                    </p>
                </div>

                {{-- Key Info Grid --}}
                <div class="grid grid-cols-2 gap-4">
                    @if ($animal->specie)
                        <div class="bg-card border border-border rounded-lg p-4">
                            <div class="text-sm text-muted-foreground mb-1">
                                {{ __("client.animal_specie") }}
                            </div>
                            <div class="font-medium">
                                {{ $animal->specie->name }}
                            </div>
                        </div>
                    @endif

                    @if ($animal->gender)
                        <div class="bg-card border border-border rounded-lg p-4">
                            <div class="text-sm text-muted-foreground mb-1">
                                {{ __("client.animal_gender") }}
                            </div>
                            <div class="font-medium">
                                {{ $animal->gender->label() }}
                            </div>
                        </div>
                    @endif

                    @if ($animal->age)
                        <div class="bg-card border border-border rounded-lg p-4">
                            <div class="text-sm text-muted-foreground mb-1">
                                {{ __("client.animal_birth_date") }}
                            </div>
                            <div class="font-medium">
                                {{ $animal->formatted_age }}
                            </div>
                        </div>
                    @endif

                    @if ($animal->coat)
                        <div class="bg-card border border-border rounded-lg p-4">
                            <div class="text-sm text-muted-foreground mb-1">
                                {{ __("client.animal_coat") }}
                            </div>
                            <div class="font-medium">
                                {{ $animal->coat->name }}
                            </div>
                        </div>
                    @endif

                    @if ($animal->admission_date)
                        <div class="bg-card border border-border rounded-lg p-4 col-span-2">
                            <div class="text-sm text-muted-foreground mb-1">
                                {{ __("client.animal_admission_date") }}
                            </div>
                            <div class="font-medium">
                                {{ $animal->formatted_admission_date }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="#schedule-visit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-primary-foreground rounded-full text-base font-medium hover:bg-primary/90 transition-colors touch-target">
                        <x-svg.calendar/>
                        <span class="translate-y-0.5">{{ __("client.schedule_visit") }}</span>
                    </a>

                    <x-client.share-button
                        :url="route('client.animals.show', $animal)"
                        :subject="__('client.share_subject', ['name' => $animal->name])"
                        :body="__('client.share_body', ['name' => $animal->name, 'shelter' => config('app.name')])"
                    >
                        {{ __("client.share_animal") }}
                    </x-client.share-button>
                </div>

                {{-- Description --}}
                @if ($animal->description)
                    <div class="pt-4 border-t border-border">
                        <h2 class="text-2xl font-bold text-foreground mb-4">
                            {{ __("client.animal_description", ["name" => $animal->name]) }}
                        </h2>
                        <div class="text-muted-foreground leading-relaxed whitespace-pre-line">
                            {{ $animal->description }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Appointment Form Section --}}
        <div id="schedule-visit" class="mt-16 scroll-mt-8">
            <div class="max-w-4xl mx-auto bg-card border border-border rounded-2xl p-6 sm:p-8 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">
                    {{-- Left: Info --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <h2 class="text-3xl font-bold text-foreground mb-4">
                                {{ __("client.appointment_heading", ["name" => $animal->name]) }}
                            </h2>
                            <p class="text-muted-foreground leading-relaxed">
                                {{ __("client.appointment_description", ["name" => $animal->name]) }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-foreground mb-3">
                                {{ __("client.appointment_prepare_title") }}
                            </h3>
                            <ul class="space-y-2 text-sm text-muted-foreground">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">•</span>
                                    <span>
                                        {{ __("client.appointment_prepare_pets") }}
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">•</span>
                                    <span>
                                        {{ __("client.appointment_prepare_questions") }}
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">•</span>
                                    <span>
                                        {{ __("client.appointment_prepare_time") }}
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">•</span>
                                    <span>
                                        {{ __("client.appointment_prepare_id") }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Right: Form --}}
                    <div class="lg:col-span-3">
                        <form method="POST" action="#" class="space-y-4">
                            @csrf
                            <input
                                type="hidden"
                                name="animal_id"
                                value="{{ $animal->id }}"
                            />

                            <x-client.form.input
                                name="name"
                                :label="__('client.form_name')"
                                :placeholder="__('client.form_name_placeholder')"
                                required
                            />

                            <x-client.form.input
                                type="email"
                                name="email"
                                :label="__('client.form_email')"
                                :placeholder="__('client.form_email_placeholder')"
                                required
                            />

                            <x-client.form.input
                                type="tel"
                                name="phone"
                                :label="__('client.form_phone')"
                                :placeholder="__('client.form_phone_placeholder')"
                                required
                            />

                            <x-client.form.textarea
                                name="message"
                                :label="__('client.form_message')"
                                :placeholder="__('client.appointment_message_placeholder')"
                                rows="6"
                                required
                            />

                            <x-client.form.button type="submit" class="w-full">
                                {{ __("client.form_submit") }}
                            </x-client.form.button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client.layout>
