<?php
declare(strict_types=1);

class SiteContent
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function getSection(string $pageKey, string $sectionKey): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT sc.*, u.full_name AS updated_by_name
             FROM site_content sc
             LEFT JOIN users u ON u.id = sc.updated_by
             WHERE sc.page_key = :page_key AND sc.section_key = :section_key
             LIMIT 1'
        );
        $stmt->execute([
            'page_key' => $pageKey,
            'section_key' => $sectionKey,
        ]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getSectionsByPage(string $pageKey): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT sc.*, u.full_name AS updated_by_name
             FROM site_content sc
             LEFT JOIN users u ON u.id = sc.updated_by
             WHERE sc.page_key = :page_key
             ORDER BY sc.section_key ASC'
        );
        $stmt->execute(['page_key' => $pageKey]);
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT sc.*, u.full_name AS updated_by_name
             FROM site_content sc
             LEFT JOIN users u ON u.id = sc.updated_by
             ORDER BY sc.page_key, sc.section_key'
        );
        return $stmt->fetchAll();
    }

    public function upsert(array $data, int $userId): bool
    {
        $pageKey = strtolower(Validator::sanitizeStorage($data['page_key'] ?? ''));
        $sectionKey = strtolower(Validator::sanitizeStorage($data['section_key'] ?? ''));
        $title = Validator::sanitizeStorage($data['title'] ?? '');
        $body = Validator::sanitizeStorageMultiline($data['body'] ?? '');
        $image = Validator::sanitizeStorage($data['image'] ?? '');

        $stmt = $this->pdo->prepare(
            'INSERT INTO site_content (page_key, section_key, title, body, image, updated_by)
             VALUES (:page_key, :section_key, :title, :body, :image, :updated_by)
             ON DUPLICATE KEY UPDATE
               title = VALUES(title),
               body = VALUES(body),
               image = VALUES(image),
               updated_by = VALUES(updated_by)'
        );

        return $stmt->execute([
            'page_key' => $pageKey,
            'section_key' => $sectionKey,
            'title' => $title,
            'body' => $body,
            'image' => $image !== '' ? $image : null,
            'updated_by' => $userId,
        ]);
    }
}
