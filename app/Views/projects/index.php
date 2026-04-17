<section>
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Chantiers
            </p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">
                Liste des chantiers
            </h1>
            <p class="mt-3 text-slate-600">
                Voici quelques projets de démonstration pour la structure de Travo.
            </p>
        </div>

        <a href="<?php echo BASE_URL; ?>/projects/create"
           class="inline-flex rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
            Nouveau chantier
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach($projects as $project) : ?>
            <article class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <h2 class="text-xl font-bold text-slate-900">
                        <?php echo $project['title']; ?>
                    </h2>

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        <?php echo $project['status']; ?>
                    </span>
                </div>

                <p class="text-sm leading-7 text-slate-600">
                    Ce chantier apparaîtra plus tard avec ses photos, ses tâches,
                    ses décisions et ses mises à jour détaillées.
                </p>

                <div class="mt-6">
                    <a href="<?php echo BASE_URL . '/projects/' . $project['id']; ?>"
                       class="inline-flex rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        Voir le chantier
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>