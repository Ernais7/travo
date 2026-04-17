<?php

class UpdateController extends Controller
{
    private Project $projectModel;
    private ProjectUpdate $updateModel;

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->updateModel = new ProjectUpdate();
    }

     public function index($projectId): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $projectId, $userId);

        if (!$project) {
            $this->notFound();
        }

        $updates = $this->updateModel->getByProjectId((int) $projectId);

        $this->view('updates/index', [
            'project' => $project,
            'updates' => $updates
        ]);
    }

    public function create($projectId): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $projectId, $userId);

        if (!$project) {
            $this->notFound();
        }

        $this->view('updates/create', ['project' => $project]);
    }

    public function store($projectId): void
    {
        $userId = $this->requireAuth();
        $project = $this->projectModel->getByIdForUser((int) $projectId, $userId);

        if (!$project) {
            $this->notFound();
        }

        $validator = Validator::make($_POST, [
            'title' => 'required|min:3',
            'content' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            Notification::setFlash('error', $validator->firstError());
            $this->redirect('/projects/' . (int) $projectId . '/updates/create');
        }

        $data = $validator->validated();
        $data['project_id'] = (int) $projectId;

        $this->updateModel->create($data);

        Notification::setFlash('success', 'L’update a bien été ajoutée.');
        $this->redirect('/projects/' . (int) $projectId . '/updates');
    }
}