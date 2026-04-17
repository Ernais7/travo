<?php

class ProjectUpdate
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getByProjectId(int $projectId): array
    {
        $sql = "SELECT * FROM project_updates
                WHERE project_id = :project_id
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'project_id' => $projectId
        ]);

        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO project_updates (project_id, title, content)
                VALUES (:project_id, :title, :content)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'content' => $data['content']
        ]);
    }
}