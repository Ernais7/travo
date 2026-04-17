<section class="space-y-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Updates chantier
            </p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">
                <?php echo htmlspecialchars($project['title']); ?>
            </h1>
            <p class="mt-3 text-slate-600">
                Historique des dernières mises à jour du chantier.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>"
               class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Retour au chantier
            </a>

            <a href="<?php echo BASE_URL; ?>/projects/<?php echo (int) $project['id']; ?>/updates/create"
               class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                Nouvelle update
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <?php if (empty($updates)): ?>
            <div class="rounded-2xl bg-white p-6 shadow ring-1 ring-slate-200">
                <p class="text-slate-600">Aucune update pour ce chantier.</p>
            </div>
        <?php else: ?>
            <?php foreach ($updates as $update): ?>
                <article class="rounded-2xl bg-white p-6 shadow ring-1 ring-slate-200">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <h2 class="text-xl font-bold text-slate-900">
                            <?php echo htmlspecialchars($update['title']); ?>
                        </h2>

                        <span class="text-sm text-slate-500">
                            <?php echo htmlspecialchars($update['created_at']); ?>
                        </span>
                    </div>

                    <p class="mt-4 leading-7 text-slate-600">
                        <?php echo nl2br(htmlspecialchars($update['content'])); ?>
                    </p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>