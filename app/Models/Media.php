<?php

class Media
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO media (
                    entity_type,
                    entity_id,
                    category,
                    original_name,
                    stored_name,
                    mime_type,
                    extension,
                    file_size,
                    uploaded_by
                ) VALUES (
                    :entity_type,
                    :entity_id,
                    :category,
                    :original_name,
                    :stored_name,
                    :mime_type,
                    :extension,
                    :file_size,
                    :uploaded_by
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function getByEntity(string $entityType, int $entityId, ?string $category = null): array
    {
        $sql = "SELECT * FROM media
                WHERE entity_type = :entity_type
                AND entity_id = :entity_id";

        $params = [
            'entity_type' => $entityType,
            'entity_id' => $entityId,
        ];

        if ($category !== null) {
            $sql .= " AND category = :category";
            $params['category'] = $category;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM media WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $media = $stmt->fetch();

        return $media ?: null;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}