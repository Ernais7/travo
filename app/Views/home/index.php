<section class="flex min-h-[70vh] items-center justify-center">
    <div class="w-full max-w-4xl rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200">
        <div class="mx-auto max-w-3xl text-center">
            <span class="inline-flex rounded-full bg-blue-100 px-4 py-1 text-sm font-semibold text-blue-700">
                Application MVC PHP
            </span>

            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 md:text-5xl">
                Bienvenue sur Travo
            </h1>

            <p class="mt-6 text-lg leading-8 text-slate-600">
                Travo est une application de suivi de travaux qui permet de centraliser
                les chantiers, les photos, les mises à jour, les décisions importantes
                et les tâches liées au projet.
            </p>

            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="<?php echo BASE_URL; ?>/projects"
                   class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700">
                    Voir les chantiers
                </a>

                <a href="<?php echo BASE_URL; ?>/about"
                   class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    En savoir plus
                </a>
            </div>
        </div>
    </div>
</section>