<section class="mx-auto max-w-xl">
    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <h1 class="text-3xl font-bold text-slate-900">Créer un compte</h1>
        <p class="mt-3 text-slate-600">Crée ton espace personnel sur Travo.</p>

        <form action="<?php echo BASE_URL; ?>/register" method="POST" class="mt-8 space-y-6">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Nom</label>
                <input type="text" name="name"
                       value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
            </div>

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

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Confirmation</label>
                <input type="password" name="password_confirmation"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
            </div>

            <button type="submit"
                    class="w-full rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Créer mon compte
            </button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Déjà un compte ?
            <a href="<?php echo BASE_URL; ?>/login" class="font-semibold text-blue-600">Se connecter</a>
        </p>
    </div>
</section>