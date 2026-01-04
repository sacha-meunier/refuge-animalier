<div class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column: Information -->
            <div class="sm:space-y-12">
                <!-- Hero Section -->
                <x-client.page-hero
                    title="Contactez-nous"
                    description="Vous avez des questions sur l'adoption, vous souhaitez nous aider ou vous avez trouvé un animal en détresse ? Notre équipe est là pour vous répondre et vous accompagner dans vos démarches."
                />

                <!-- Contact Information -->
                <x-client.info-section
                    class="hidden lg:block"
                    title="Informations de contact"
                    :items="[
                        ['label' => 'Email', 'value' => 'contact@lespattesheureuses.be'],
                        ['label' => 'Téléphone', 'value' => '0482/ 01 09 82'],
                        ['label' => 'Adresse', 'value' => 'Rue de Genville 334, 8890 Passendale'],
                    ]"
                />

                <!-- Opening Hours -->
                <x-client.info-section
                    class="hidden lg:block"
                    title="Horaires d'ouverture"
                    :items="[
                        ['label' => 'Lundi - Vendredi', 'value' => '14h - 18h'],
                        ['label' => 'Samedi - Dimanche', 'value' => '10h - 17h'],
                    ]"
                />
            </div>

            <!-- Right Column: Contact Form -->
            <div class="lg:pl-8">
                <div class="bg-accent/30 border border-border/60 rounded-2xl p-4 sm:p-6 lg:p-8">
                    <form method="POST" {{--action="{{ route('contact.store') }}"--}} class="space-y-6">
                        @csrf

                        <x-client.form.input
                            name="name"
                            label="Nom"
                            placeholder="Harvey Specter"
                            :required="true"
                            autocomplete="name"
                        />

                        <x-client.form.input
                            type="email"
                            name="email"
                            label="Email"
                            placeholder="harvey.specter@gmail.com"
                            :required="true"
                            autocomplete="email"
                        />

                        <x-client.form.input
                            type="tel"
                            name="phone"
                            label="Téléphone"
                            placeholder="0482/ 01 09 82"
                            autocomplete="tel"
                        />

                        <x-client.form.textarea
                            name="message"
                            label="Message"
                            placeholder="Entrez votre message ici."
                            :rows="6"
                            :required="true"
                        />

                        <div class="flex justify-end pt-2">
                            <x-client.form.button>
                                Envoyer
                            </x-client.form.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
