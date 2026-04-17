<section class="max-w-3xl">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-amber-600">
                Modification
            </p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">
                Modifier le projet
            </h1>
            <p class="mt-3 text-slate-600">
                Mets à jour les informations de ce chantier.
            </p>
        </div>

        <form action="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>/update" method="POST" class="space-y-6">
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">
                    Titre
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo htmlspecialchars($project['title']); ?>"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                >
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                    Statut
                </label>
                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                >
                    <option value="En attente" <?php echo $project['status'] === 'En attente' ? 'selected' : ''; ?>>En attente</option>
                    <option value="En cours" <?php echo $project['status'] === 'En cours' ? 'selected' : ''; ?>>En cours</option>
                    <option value="Terminé" <?php echo $project['status'] === 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
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
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                ><?php echo htmlspecialchars($project['description']); ?></textarea>
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
                    value="<?php echo (int) $project['progress']; ?>"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                >
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <button
                    type="submit"
                    class="rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-amber-600"
                >
                    Enregistrer les modifications
                </button>

                <a
                    href="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Retour
                </a>
            </div>
        </form>
    </div>
</section>