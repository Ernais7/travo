<section class="mx-auto max-w-3xl space-y-8">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
            Mon compte
        </p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">
            Mes informations
        </h1>

        <div class="mt-6 space-y-3 text-slate-700">
            <p><strong>ID :</strong> <?php echo (int) $user['id']; ?></p>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">
            Mes statistiques
        </p>
        <h2 class="mt-2 text-2xl font-bold text-slate-900">
            Mes chantiers
        </h2>

        <p class="mt-4 text-slate-700">
            Vous avez <strong><?php echo (int) $projectCount; ?></strong> chantier(s).
        </p>
    </div>
</section>