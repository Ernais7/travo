<?php

class DecisionController extends Controller
{
    private Decision $decisionModel;
    private DecisionLog $logModel;

    public function __construct()
    {
        $this->decisionModel = new Decision();
        $this->logModel = new DecisionLog();
    }

    public function create(string $projectId): void
    {
        $userId = $this->requireAuth();
        $this->view('decisions/create', ['projectId' => $projectId]);
    }

    public function store(string $projectId): void
    {
        $userId = $this->requireAuth();

        if (empty($_POST['title']) || empty($_POST['description'])) {
            Notification::setFlash('error', 'Le titre et la description sont requis.');
            $this->redirect('/projects/' . $projectId . '/decisions/create');
            return;
        }

        $this->decisionModel->create([
            'project_id'  => $projectId,
            'user_id'     => $userId,
            'title'       => htmlspecialchars($_POST['title']),
            'description' => htmlspecialchars($_POST['description'])
        ]);

        $newId = $this->decisionModel->getLastInsertId();
        $this->decisionModel->changeStatus(
            $newId,
            'none',
            'draft',
            $userId,
            'Création initiale du brouillon'
        );

        Notification::setFlash('success', 'Brouillon de décision créé.');
        $this->redirect('/projects/' . $projectId);
    }

    public function show(string $id): void
    {
        $userId = $this->requireAuth();
        $decision = $this->decisionModel->getByIdWithProjectOwner($id);

        if (!$decision) {
            Notification::setFlash('error', 'Décision introuvable.');
            $this->redirect('/projects');
            return;
        }

        if ($decision['project_owner_id'] != $userId) {
            Notification::setFlash('error', 'Accès refusé.');
            $this->redirect('/projects');
            return;
        }

        $logs = $this->logModel->getByDecisionId($id);

        $this->view('decisions/show', [
            'decision' => $decision,
            'logs'     => $logs
        ]);
    }

    public function transition(string $id): void
    {
        $userId = $this->requireAuth();
        $action = $_POST['action'] ?? '';
        $decision = $this->decisionModel->getByIdWithProjectOwner($id);

        if ($action === 'reject' && empty($_POST['comment'])) {
            Notification::setFlash('error', 'Un commentaire est obligatoire pour rejeter une décision.');
            $this->redirect("/decisions/$id");
            return;
        }


        if (!$decision || $decision['project_owner_id'] != $userId) {
            $this->redirect('/projects');
            return;
        }
        $comment = !empty($_POST['comment']) ? htmlspecialchars($_POST['comment']) : null;

        $currentStatus = $decision['status'];
        $newStatus = '';
        $message = '';

        if ($currentStatus === 'draft') {
            if ($action === 'submit') {
                $newStatus = 'pending';
                $message = 'Décision envoyée en validation';
            }
            if ($action === 'cancel') {
                $newStatus = 'cancelled';
                $message = 'Brouillon annulé';
            }
        } elseif ($currentStatus === 'pending') {
            if ($action === 'approve') {
                $newStatus = 'approved';
                $message = 'Décision approuvée';
            }
            if ($action === 'reject') {
                $newStatus = 'rejected';
                $message = 'Décision rejetée';
            }
            if ($action === 'cancel') {
                $newStatus = 'cancelled';
                $message = 'Décision annulée';
            }
        } elseif ($currentStatus === 'rejected') {
            if ($action === 'reopen') {
                $newStatus = 'draft';
                $message = 'Ramené à l\'état de brouillon';
            }
        }

        if (empty($newStatus)) {
            Notification::setFlash('error', 'Transition non autorisée.');
            $this->redirect('/decisions/' . $id);
            return;
        }

        $success = $this->decisionModel->changeStatus($id, $currentStatus, $newStatus, $userId, $message, $comment);

        if ($success) {
            Notification::setFlash('success', $message);
        } else {
            Notification::setFlash('error', 'Erreur lors du changement de statut.');
        }

        $this->redirect('/decisions/' . $id);
    }
}
