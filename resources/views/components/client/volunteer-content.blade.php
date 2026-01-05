<div class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column: Information -->
            <div class="space-y-12">
                <!-- Hero Section -->
                <x-client.page-hero
                    :title="__('client.volunteer_heading')"
                    :description="__('client.volunteer_description')"
                />

                <!-- Missions Possible -->
                <x-client.mission-list
                    :title="__('client.volunteer_missions_title')"
                    :missions="[
                        [
                            'category' => __('client.volunteer_mission_website'),
                            'description' => __('client.volunteer_mission_website_desc')
                        ],
                        [
                            'category' => __('client.volunteer_mission_care'),
                            'description' => __('client.volunteer_mission_care_desc')
                        ],
                        [
                            'category' => __('client.volunteer_mission_maintenance'),
                            'description' => __('client.volunteer_mission_maintenance_desc')
                        ],
                        [
                            'category' => __('client.volunteer_mission_communication'),
                            'description' => __('client.volunteer_mission_communication_desc')
                        ],
                        [
                            'category' => __('client.volunteer_mission_diy'),
                            'description' => __('client.volunteer_mission_diy_desc')
                        ],
                    ]"
                />
            </div>

            <!-- Right Column: Volunteer Form -->
            <div class="lg:pl-8">
                <x-client.flash-message />

                <div
                    class="bg-accent/30 border border-border/60 rounded-2xl p-4 sm:p-6 lg:p-8"
                >
                    <form
                        method="POST"
                        action="{{ route("volunteer.store") }}"
                        class="space-y-6"
                    >
                        @csrf

                        <x-client.form.input
                            name="name"
                            :label="__('client.form_name')"
                            :placeholder="__('client.form_name_placeholder')"
                            :required="true"
                            autocomplete="name"
                        />

                        <x-client.form.input
                            type="email"
                            name="email"
                            :label="__('client.form_email')"
                            :placeholder="__('client.form_email_placeholder')"
                            :required="true"
                            autocomplete="email"
                        />

                        <x-client.form.input
                            type="tel"
                            name="phone"
                            :label="__('client.form_phone')"
                            :placeholder="__('client.form_phone_placeholder')"
                            autocomplete="tel"
                        />

                        <x-client.form.input
                            name="address"
                            :label="__('client.form_address')"
                            :placeholder="__('client.form_address_placeholder')"
                            autocomplete="street-address"
                        />

                        <x-client.form.textarea
                            name="message"
                            :label="__('client.form_message')"
                            :placeholder="__('client.form_message_placeholder')"
                            :rows="6"
                            :required="true"
                        />

                        <div class="flex justify-end pt-2">
                            <x-client.form.button>
                                {{ __("client.form_submit") }}
                            </x-client.form.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
