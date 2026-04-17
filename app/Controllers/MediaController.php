<?php

class MediaController extends Controller
{
    private Project $projectModel;
    private Media $mediaModel;

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->mediaModel = new Media();
    }

    public function store(): void
    {
        $userId = $this->requireAuth();

        $entityType = $_POST['entity_type'] ?? '';
        $entityId = (int) ($_POST['entity_id'] ?? 0);
        $category = $_POST['category'] ?? '';

        if ($entityType !== 'project') {
            Notification::setFlash('error', 'Vous pouvez uploader des fichiers uniquement pour les projets.');
            $this->redirect('/projects');
        }

        $project = $this->projectModel->getByIdForUser($entityId, $userId);

        if (!$project) {
            $this->notFound();
        }

        if (!isset($_FILES['file'])) {
            Notification::setFlash('error', 'Aucun fichier envoyé.');
            $this->redirect('/projects/' . $entityId);
        }

        $allowedMimeTypes = match ($category) {
            'photo' => ['image/jpeg', 'image/png', 'image/webp'],
            'document' => ['application/pdf'],
            default => [],
        };

        if (empty($allowedMimeTypes)) {
            Notification::setFlash('error', 'On ne peux upload uniquement des photos ou des documents.');
            $this->redirect('/projects/' . $entityId);
        }

        $upload = $this->upload(
            $_FILES['file'],
            $allowedMimeTypes,
            __DIR__ . '/../../storage/uploads'
        );

        if (!$upload) {
            Notification::setFlash('error', 'Upload impossible ou format invalide.');
            $this->redirect('/projects/' . $entityId);
        }

        $this->mediaModel->create([
            'entity_type' => 'project',
            'entity_id' => $entityId,
            'category' => $category,
            'original_name' => $upload['original_name'],
            'stored_name' => $upload['stored_name'],
            'mime_type' => $upload['mime_type'],
            'extension' => $upload['extension'],
            'file_size' => $upload['file_size'],
            'uploaded_by' => $userId,
        ]);

        Notification::setFlash('success', 'Fichier ajouté avec succès.');
        $this->redirect('/projects/' . $entityId);
    }

    public function destroy($id): void
    {
        $userId = $this->requireAuth();

        $media = $this->mediaModel->findById((int) $id);

        if (!$media) {
            $this->notFound();
        }

        if ($media['entity_type'] !== 'project') {
            $this->notFound();
        }

        $project = $this->projectModel->findByIdForUser((int) $media['entity_id'], $userId);

        if (!$project) {
            $this->notFound();
        }

        $filePath = __DIR__ . '/../../storage/uploads/' . $media['stored_name'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->mediaModel->delete((int) $id);

        Notification::setFlash('success', 'Fichier supprimé.');
        $this->redirect('/projects/' . (int) $project['id']);
    }

    private function upload(array $file, array $allowedMimeTypes, string $destinationDir): ?array
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $mimeType = mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            return null;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $storedName = uniqid('media_', true) . '.' . $extension;

        
        $destinationPath = rtrim($destinationDir, '/') . '/' . $storedName;
        if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
            return null;
        }

        return [
            'original_name' => $file['name'],
            'stored_name' => $storedName,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'file_size' => (int) $file['size'],
        ];
    }
}