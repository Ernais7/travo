<section class="mx-auto max-w-xl">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <h1 class="text-3xl font-bold text-slate-900">Connexion</h1>
        <p class="mt-3 text-slate-600">Connecte-toi pour accéder à tes chantiers.</p>

        <form action="<?php echo BASE_URL; ?>/login" method="POST" class="mt-8 space-y-6">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email"
                       value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Mot de passe</label>
                <input type="password" name="password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
            </div>

            <button type="submit"
                    class="w-full rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Se connecter
            </button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Pas encore de compte ?
            <a href="<?php echo BASE_URL; ?>/register" class="font-semibold text-blue-600">Créer un compte</a>
        </p>
    </div>
</section>