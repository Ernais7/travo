<?php

class Decision
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getByProjectId(int $projectId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM decisions WHERE project_id = :pid ORDER BY created_at DESC');
        $stmt->execute([':pid' => $projectId]);
        return $stmt->fetchAll();
    }

    public function getByIdWithProjectOwner(int $id)
    {
        $stmt = $this->pdo->prepare('
            SELECT d.*, p.user_id as project_owner_id 
            FROM decisions d 
            JOIN projects p ON d.project_id = p.id 
            WHERE d.id = :id
        ');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO decisions (project_id, user_id, title, description, status) 
            VALUES (:pid, :uid, :title, :desc, "draft")
        ');
        return $stmt->execute([
            ':pid'   => $data['project_id'],
            ':uid'   => $data['user_id'],
            ':title' => $data['title'],
            ':desc'  => $data['description']
        ]);
    }

    public function changeStatus(int $decisionId, string $from, string $to, int $userId, string $message, ?string $comment = null): bool
    {
        $stmtStatus = $this->pdo->prepare('SELECT status FROM decisions WHERE id = :id');
        $stmtStatus->execute(['id' => $decisionId]);
        $currentStatus = $stmtStatus->fetchColumn();

        if ($currentStatus === 'approved') {
            return false;
        }
        try {
            $this->pdo->beginTransaction();

            $query = 'UPDATE decisions SET status = :to_status, updated_at = NOW()';
            $params = [':to_status' => $to, ':id' => $decisionId];

            if ($comment !== null) {
                $query .= ', response_comment = :comment';
                $params[':comment'] = $comment;
            }
            if ($to === 'approved' || $to === 'rejected') {
                $query .= ', validated_at = NOW()';
            }

            $query .= ' WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            $logStmt = $this->pdo->prepare('
                INSERT INTO decision_logs (decision_id, user_id, from_status, to_status, message) 
                VALUES (:did, :uid, :from_s, :to_s, :msg)
            ');
            $logStmt->execute([
                ':did'    => $decisionId,
                ':uid'    => $userId,
                ':from_s' => $from,
                ':to_s'   => $to,
                ':msg'    => $message
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
