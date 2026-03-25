<?php
declare(strict_types=1);

class ContactMessage
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function create(array $data): bool
    {
        $name = Validator::sanitizeStorage($data['name'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $subject = Validator::sanitizeStorage($data['subject'] ?? '');
        $message = Validator::sanitizeStorageMultiline($data['message'] ?? '');

        $stmt = $this->pdo->prepare(
            'INSERT INTO contact_messages (name, email, subject, message)
             VALUES (:name, :email, :subject, :message)'
        );
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);
    }

    public function getAll(): array
    {
        return $this->pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
    }

    public function markRead(int $id): bool
    {
        $stmt = $this->pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
    }
}
