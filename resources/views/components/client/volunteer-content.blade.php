<div class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column: Information -->
            <div class="space-y-12">
                <!-- Hero Section -->
                <x-client.page-hero
                    title="Devenez bénévole"
                    description="Rejoignez notre équipe de bénévoles passionnés et contribuez au bien-être de nos pensionnaires ! Que vous ayez quelques heures par semaine ou par mois, votre aide est précieuse pour offrir une seconde chance à nos animaux."
                />

                <!-- Missions Possible -->
                <x-client.mission-list
                    title="Missions possibles"
                    :missions="[
                        [
                            'category' => 'Gestion du site internet',
                            'description' => 'Management des fiches d\'animaux'
                        ],
                        [
                            'category' => 'Soins des animaux',
                            'description' => 'Promenades, jeux, socialisation, nourrissage'
                        ],
                        [
                            'category' => 'Entretien',
                            'description' => 'Nettoyage des enclos, espaces communs'
                        ],
                        [
                            'category' => 'Communication',
                            'description' => 'Photos, réseaux sociaux, rédaction d\'annonces'
                        ],
                        [
                            'category' => 'Bricolage et jardinage',
                            'description' => 'Petits travaux, aménagements extérieurs'
                        ],
                    ]"
                />
            </div>

            <!-- Right Column: Volunteer Form -->
            <div class="lg:pl-8">
                <div class="bg-accent/30 border border-border/60 rounded-2xl p-4 sm:p-6 lg:p-8">
                    <form method="POST" {{--action="{{ route('volunteer.store') }}"--}} class="space-y-6">
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

                        <x-client.form.input
                            name="address"
                            label="Adresse"
                            placeholder="Rue de Genville 334, 8890 Passendale"
                            autocomplete="street-address"
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
