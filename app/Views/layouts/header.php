<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travo</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="bg-blue-900 text-white shadow-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-bold tracking-tight">Travo</a>

            <nav class="flex items-center gap-4 text-sm font-medium">
                <?php if (Auth::check()): ?>
                    <a href="<?php echo BASE_URL; ?>/projects" class="transition hover:text-blue-200">Mes chantiers</a>
                    <a href="<?php echo BASE_URL; ?>/account" class="transition hover:text-blue-200">Mon compte</a>
                    <span class="text-blue-100">
                        Bonjour <?php echo htmlspecialchars(Auth::user()['name']); ?>
                    </span>

                    <form action="<?php echo BASE_URL; ?>/logout" method="POST">
                        <button type="submit" class="rounded-lg bg-white/10 px-4 py-2 hover:bg-white/20">
                            Déconnexion
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="transition hover:text-blue-200">Connexion</a>
                    <a href="<?php echo BASE_URL; ?>/register" class="rounded-lg bg-white/10 px-4 py-2 hover:bg-white/20">
                        Inscription
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
        <?php $flash = Notification::getFlash(); ?>

        <?php if ($flash): ?>
            <?php
                $flashClasses = $flash['type'] === 'success'
                    ? 'border-emerald-200 bg-emerald-50 text-emerald-800'
                    : 'border-red-200 bg-red-50 text-red-800';
            ?>

            <div class="mb-6 rounded-2xl border px-5 py-4 shadow-sm <?php echo $flashClasses; ?>">
                <p class="font-medium">
                    <?php echo htmlspecialchars($flash['message']); ?>
                </p>
            </div>
        <?php endif; ?>