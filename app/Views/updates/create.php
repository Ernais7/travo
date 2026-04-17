<section class="max-w-3xl">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Nouvelle update
            </p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">
                <?php echo htmlspecialchars($project['title']); ?>
            </h1>
            <p class="mt-3 text-slate-600">
                Ajoute une mise à jour sur l’avancement du chantier.
            </p>
        </div>

        <form action="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>/updates/store" method="POST" class="space-y-6">
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">
                    Titre
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    placeholder="Exemple : Livraison du carrelage"
                >
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">
                    Contenu
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="6"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    placeholder="Décris l’avancement, les problèmes, les prochaines étapes..."
                ><?php echo htmlspecialchars($old['content'] ?? ''); ?></textarea>
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Enregistrer l’update
                </button>

                <a href="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>/updates"
                   class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</section>