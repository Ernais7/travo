<section class="max-w-2xl mx-auto rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-slate-900">Nouvelle Décision</h1>
    
    <form action="<?= BASE_URL ?>/projects/<?= $projectId ?>/decisions/store" method="POST" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-slate-700">Titre de la décision</label>
            <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-slate-700">Description et contexte</label>
            <textarea name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" required></textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="<?= BASE_URL ?>/projects/<?= $projectId ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">Créer le brouillon</button>
        </div>
    </form>
</section>