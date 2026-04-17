<?php

class AuthController extends Controller
{
    private User $userModel;
    private Project $projectModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->projectModel = new Project();
    }

    public function showRegister(): void
    {
        $this->requireGuest();
        $this->view('auth/register');
    }

    public function register(): void
    {
        $this->requireGuest();

        $validator = Validator::make($_POST, [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            Notification::setFlash('error', $validator->firstError());
            $this->redirect('/register');
        }

        $data = $validator->validated();
        $this->userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        $user = $this->userModel->findByEmail($data['email']);
        Auth::login($user);

        Notification::setFlash('success', 'Compte créé avec succès.');
        $this->redirect('/projects');
    }

    public function showLogin(): void
    {
        $this->requireGuest();
        $this->view('auth/login');
    }

    public function login(): void
    {
        $this->requireGuest();

        $validator = Validator::make($_POST, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Notification::setFlash('error', $validator->firstError());
            $this->redirect('/login');
        }

        $data = $validator->validated();

        $user = $this->userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            Notification::setFlash('error', 'Identifiants invalides.');
            $this->redirect('/login');
        }

        Auth::login($user);

        Notification::setFlash('success', 'Connexion réussie.');
        $this->redirect('/projects');
    }

    public function logout(): void
    {
        Auth::logout();
        Notification::setFlash('success', 'Déconnexion réussie.');
        $this->redirect('/login');
    }

    public function account(): void
    {
        $userId = $this->requireAuth();
        $user = $this->userModel->findById((int) $userId);
        $projectCount = $this->projectModel->countByUserId($userId);

        if (!$user) {
            $this->notFound();
        }

        $this->view('auth/account', [
            'user' => $user,
            'projectCount' => $projectCount,
        ]);

    }
}