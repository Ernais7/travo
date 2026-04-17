<?php

class DecisionLog
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getByDecisionId(int $decisionId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT dl.*, u.name as user_name 
            FROM decision_logs dl 
            JOIN users u ON dl.user_id = u.id 
            WHERE decision_id = :did 
            ORDER BY dl.created_at ASC
        ');
        $stmt->execute([':did' => $decisionId]);
        return $stmt->fetchAll();
    }
}