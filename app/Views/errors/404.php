<section class="flex min-h-[70vh] items-center justify-center">
    <div class="w-full max-w-2xl rounded-3xl bg-white p-10 text-center shadow-xl ring-1 ring-slate-200">
        <span class="inline-flex rounded-full bg-red-100 px-4 py-1 text-sm font-semibold text-red-700">
            Erreur 404
        </span>

        <h1 class="mt-6 text-5xl font-extrabold tracking-tight text-slate-900">
            Page introuvable
        </h1>

        <p class="mt-6 text-lg leading-8 text-slate-600">
            La page que vous cherchez n’existe pas ou a été déplacée.
        </p>

        <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="<?php echo BASE_URL; ?>/"
               class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700">
                Retour à l’accueil
            </a>

            <a href="<?php echo BASE_URL; ?>/projects"
               class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Mes chantiers
            </a>
        </div>
    </div>
</section>