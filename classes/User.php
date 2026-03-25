<?php
declare(strict_types=1);

class User
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => strtolower(trim($email))]);
        return (bool) $stmt->fetch();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT u.*, r.role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.email = :email
             LIMIT 1'
        );
        $stmt->execute(['email' => strtolower(trim($email))]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT u.*, r.role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $fullName, string $email, string $password, string $roleName = 'user'): bool
    {
        $roleId = $this->getRoleIdByName($roleName);
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (full_name, email, password, role_id)
             VALUES (:full_name, :email, :password, :role_id)'
        );

        return $stmt->execute([
            'full_name' => trim($fullName),
            'email' => strtolower(trim($email)),
            'password' => $hash,
            'role_id' => $roleId,
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT u.id, u.full_name, u.email, u.role_id, u.created_at, r.role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             ORDER BY u.id DESC'
        );
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function updateRole(int $userId, int $roleId): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET role_id = :role_id WHERE id = :id');
        return $stmt->execute([
            'role_id' => $roleId,
            'id' => $userId,
        ]);
    }

    public function getRoles(): array
    {
        return $this->pdo->query('SELECT id, role_name FROM roles ORDER BY id ASC')->fetchAll();
    }

    private function getRoleIdByName(string $roleName): int
    {
        $stmt = $this->pdo->prepare('SELECT id FROM roles WHERE role_name = :name LIMIT 1');
        $stmt->execute(['name' => $roleName]);
        $id = $stmt->fetchColumn();
        return $id ? (int) $id : 2;
    }
}
