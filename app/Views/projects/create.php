<section class="max-w-3xl">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Nouveau chantier
            </p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">
                Créer un projet
            </h1>
            <p class="mt-3 text-slate-600">
                Remplis ce formulaire pour ajouter un nouveau chantier dans Travo.
            </p>
        </div>

        <form action="<?php echo BASE_URL; ?>/projects/store" method="POST" class="space-y-6">
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">
                    Titre
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    placeholder="Exemple : Rénovation complète du salon"
                >
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                    Statut
                </label>
                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                >
                    <option value="">Choisir un statut</option>
                    <option value="En attente">En attente</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                </select>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
                    Description
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    placeholder="Décris les travaux prévus pour ce chantier..."
                ></textarea>
            </div>

            <div>
                <label for="progress" class="mb-2 block text-sm font-semibold text-slate-700">
                    Progression (%)
                </label>
                <input
                    type="number"
                    id="progress"
                    name="progress"
                    min="0"
                    max="100"
                    value="0"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                >
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Enregistrer le projet
                </button>

                <a
                    href="<?php echo BASE_URL; ?>/projects"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</section>