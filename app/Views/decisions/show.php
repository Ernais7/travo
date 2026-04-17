<section class="max-w-4xl mx-auto space-y-6 mt-8">

    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900"><?= htmlspecialchars($decision['title']) ?></h1>
                <p class="text-sm text-slate-500 mt-1">Chantier n°<?= $decision['project_id'] ?></p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider 
                <?= $decision['status'] === 'draft' ? 'bg-gray-200 text-gray-700' : '' ?>
                <?= $decision['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                <?= $decision['status'] === 'approved' ? 'bg-green-100 text-green-800' : '' ?>
                <?= $decision['status'] === 'rejected' ? 'bg-red-100 text-red-800' : '' ?>
                <?= $decision['status'] === 'cancelled' ? 'bg-slate-800 text-white' : '' ?>">
                <?= $decision['status'] ?>
            </span>
        </div>

        <div class="prose max-w-none text-slate-700 mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100">
            <?= nl2br(htmlspecialchars($decision['description'])) ?>
        </div>

        <?php if (!empty($decision['response_comment'])): ?>
            <div class="p-4 mb-6 bg-slate-50 border-l-4 border-indigo-500 rounded-r-lg shadow-sm">
                <strong class="text-indigo-800 block mb-1">Commentaire laissé :</strong>
                <span class="text-slate-700"><?= nl2br(htmlspecialchars($decision['response_comment'])) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($decision['status'] !== 'approved' && $decision['status'] !== 'cancelled'): ?>
            <form action="<?= BASE_URL ?>/decisions/<?= $decision['id'] ?>/transition" method="POST" class="mt-8 border-t border-slate-200 pt-6">

                <?php if ($decision['status'] === 'pending'): ?>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Commentaire (obligatoire en cas de rejet)</label>
                        <input type="text" name="comment" placeholder="Saisissez un commentaire..." class="border border-gray-300 rounded-md p-2 w-full focus:ring-blue-500 focus:border-blue-500">
                    </div>
                <?php endif; ?>

                <div class="flex flex-wrap gap-3">
                    <?php if ($decision['status'] === 'draft'): ?>
                        <button type="submit" name="action" value="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">Envoyer en validation</button>
                        <button type="submit" name="action" value="cancel" class="bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-medium hover:bg-slate-200 transition">Annuler la décision</button>

                    <?php elseif ($decision['status'] === 'pending'): ?>
                        <button type="submit" name="action" value="approve" class="bg-green-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-green-700 transition">Approuver</button>
                        <button type="submit" name="action" value="reject" class="bg-red-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-red-700 transition">Rejeter</button>
                        <button type="submit" name="action" value="cancel" class="bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-medium hover:bg-slate-200 transition">Annuler</button>

                    <?php elseif ($decision['status'] === 'rejected'): ?>
                        <button type="submit" name="action" value="reopen" class="bg-yellow-500 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-yellow-600 transition">Repasser en brouillon</button>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Historique de la décision
        </h2>

        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
            <?php foreach ($logs as $log): ?>
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-blue-100 text-blue-600 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <div class="font-bold text-slate-900"><?= htmlspecialchars($log['user_name']) ?></div>
                            <time class="text-xs font-medium text-slate-500"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></time>
                        </div>
                        <div class="text-sm text-slate-600 mb-2"><?= htmlspecialchars($log['message']) ?></div>
                        <div class="text-xs font-mono bg-slate-100 text-slate-500 px-2 py-1 rounded inline-block">
                            <?= $log['from_status'] ?> &rarr; <?= $log['to_status'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>