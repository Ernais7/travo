<?php

class ProjectController extends Controller
{

    private Project $projectModel;
    private Media $mediaModel;

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->mediaModel = new Media();
    }

    public function index()
    {
        $userId = $this->requireAuth();
        $projects = $this->projectModel->getAllByUserId($userId);

        $this->view('projects/index', ['projects' => $projects]);
    }

    public function show($id): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser($id, $userId);

        if (!$project) {
            $this->notFound();
        }

        $photos = $this->mediaModel->getByEntity('project', (int) $id, 'photo');
        $documents = $this->mediaModel->getByEntity('project', (int) $id, 'document');

        $decisionModel = new Decision();

        $decisions = $decisionModel->getByProjectId((int)$id);

        $this->view('projects/show', [
            'project'   => $project,
            'photos'    => $photos,
            'documents' => $documents,
            'decisions' => $decisions
        ]);
    }

    public function create(): void
    {
        $userId = $this->requireAuth();
        $this->view('projects/create');
    }

    function store(): void
    {

        $userId = $this->requireAuth();
        $validator = Validator::make($_POST, [
            'title' => 'required|max:255',
            'status' => 'required|in:En cours,Terminé,En attente',
            'description' => 'required',
            'progress' => 'required|integer|between:0,100'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Notification::setFlash('error', implode('<br>', $errors));
            $this->redirect('/projects/create');
        }

        if (!$this->projectModel->create([
            'user_id'     => $userId,
            'title'       => $_POST['title'],
            'status'      => $_POST['status'],
            'description' => $_POST['description'],
            'progress'    => $_POST['progress']
        ])) {
            Notification::setFlash('error', 'Une erreur est survenue lors de la création du projet.');
            $this->redirect('/projects/create');
        }

        Notification::setFlash('success', 'Projet créé avec succès.');
        $this->redirect('/projects');
        exit;
    }

    public function edit($id): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $id, $userId);

        if (!$project) {
            $this->notFound();
        }

        $this->view('projects/edit', ['project' => $project]);
    }

    public function update($id): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $id, $userId);

        if (!$project) {
            $this->notFound();
        }

        $title = trim($_POST['title'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $progress = (int) ($_POST['progress'] ?? 0);

        $validator = Validator::make($_POST, [
            'title' => 'required|max:255',
            'status' => 'required|in:En cours,Terminé,En attente',
            'description' => 'required',
            'progress' => 'required|integer|between:0,100'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Notification::setFlash('error', implode('<br>', $errors));
            $this->redirect('/projects/edit/' . (int) $id);
            exit;
        }

        $this->projectModel->update((int) $id, [
            'title' => $title,
            'status' => $status,
            'description' => $description,
            'progress' => $progress
        ]);

        Notification::setFlash('success', 'Projet mis à jour avec succès.');
        $this->redirect('/projects/' . (int) $id);
    }

    public function destroy($id): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $id, $userId);

        if (!$project) {
            $this->notFound();
        }

        $this->projectModel->delete((int) $id);

        Notification::setFlash('success', 'Projet supprimé avec succès.');
        $this->redirect('/projects');
    }
}
