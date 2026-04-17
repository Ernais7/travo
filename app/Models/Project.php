<?php

class Project
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM projects");
        return $stmt->fetchAll();
    }

    public function getAllByUserId(int $userId): array
    {
        $sql = "SELECT * FROM projects
                WHERE user_id = :user_id
                ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function getByIdForUser(int $id, int $userId): ?array
    {
        $sql = "SELECT * FROM projects
                WHERE id = :id AND user_id = :user_id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        $project = $stmt->fetch();

        return $project ?: null;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO projects (user_id, title, status, description, progress) 
            VALUES (:uid, :title, :status, :desc, :progress)
        ');

        return $stmt->execute([
            ':uid'      => $data['user_id'],
            ':title'    => $data['title'],
            ':status'   => $data['status'],
            ':desc'     => $data['description'],
            ':progress' => $data['progress'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE projects
                SET title = :title,
                    status = :status,
                    description = :description,
                    progress = :progress
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'status' => $data['status'],
            'description' => $data['description'],
            'progress' => $data['progress']
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM projects WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(*) FROM projects WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
        ]);

        return (int) $stmt->fetchColumn();
    }
}
