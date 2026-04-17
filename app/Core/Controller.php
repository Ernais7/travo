<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        require_once __DIR__ . '/../Views/layouts/header.php';
        require_once __DIR__ . '/../Views/' . $view . '.php';
        require_once __DIR__ . '/../Views/layouts/footer.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    protected function requireAuth(): int
    {
        if (!Auth::check()) {
            Notification::setFlash('error', 'Veuillez vous connecter.');
            $this->redirect('/login');
        }

        return Auth::id();
    }

    protected function requireGuest(): void
    {
        if (Auth::check()) {
            $this->redirect('/projects');
        }
    }

    protected function notFound(): void
    {
        $errorController = new ErrorController();
        $errorController->notFound();
    }


}