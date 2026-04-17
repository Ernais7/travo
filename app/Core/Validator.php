<?php

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];
    private array $validated = [];

    private function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    public static function make(array $data, array $rules): self
    {
        return new self($data, $rules);
    }

    private function validate(): void
    {
        foreach ($this->rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            $rules = explode('|', $ruleString);

            foreach ($rules as $rule) {
                $ruleName = $rule;
                $params = [];

                if (str_contains($rule, ':')) {
                    [$ruleName, $paramString] = explode(':', $rule, 2);
                    $params = explode(',', $paramString);
                }

                $this->applyRule($field, $value, $ruleName, $params);
            }

            if (!isset($this->errors[$field])) {
                $this->validated[$field] = is_string($value) ? trim($value) : $value;
            }
        }
    }

    private function applyRule(string $field, mixed $value, string $ruleName, array $params = []): void
    {
        if (isset($this->errors[$field])) {
            return;
        }

        switch ($ruleName) {
            case 'required':
                if (trim((string) $value) === '') {
                    $this->errors[$field] = "Le champ {$field} est obligatoire.";
                }
                break;

            case 'min':
                $min = (int) ($params[0] ?? 0);
                if (trim((string) $value) !== '' && mb_strlen(trim((string) $value)) < $min) {
                    $this->errors[$field] = "Le champ {$field} doit contenir au moins {$min} caractères.";
                }
                break;

            case 'email':
                if (trim((string) $value) !== '' && !filter_var(trim((string) $value), FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = "L’adresse email est invalide.";
                }
                break;

            case 'confirmed':
                $confirmationField = $field . '_confirmation';
                $confirmationValue = $this->data[$confirmationField] ?? null;

                if ((string) $value !== (string) $confirmationValue) {
                    $this->errors[$field] = "La confirmation du champ {$field} ne correspond pas.";
                }
                break;

            case 'in':
                $allowed = $params;
                if (trim((string) $value) !== '' && !in_array((string) $value, $allowed, true)) {
                    $this->errors[$field] = "La valeur du champ {$field} est invalide.";
                }
                break;

            case 'integer':
                if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                    $this->errors[$field] = "Le champ {$field} doit être un entier.";
                }
                break;

            case 'between':
                $min = (int) ($params[0] ?? 0);
                $max = (int) ($params[1] ?? 0);
                $number = (int) $value;

                if ($number < $min || $number > $max) {
                    $this->errors[$field] = "Le champ {$field} doit être compris entre {$min} et {$max}.";
                }
                break;

            case 'unique':
                $table = $params[0] ?? null;
                $column = $params[1] ?? $field;

                if ($table && $column && trim((string) $value) !== '') {
                    $pdo = Database::getConnection();

                    $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = :value";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'value' => trim((string) $value)
                    ]);

                    $count = (int) $stmt->fetchColumn();

                    if ($count > 0) {
                        $this->errors[$field] = "Cette valeur pour {$field} est déjà utilisée.";
                    }
                }
                break;
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        return empty($this->errors) ? null : reset($this->errors);
    }

    public function validated(): array
    {
        return $this->validated;
    }
}