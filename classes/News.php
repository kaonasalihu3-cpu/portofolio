<?php
declare(strict_types=1);

class News extends Content
{
    public function getAll(): array
    {
        return $this->fetchAllRows(
            'SELECT n.*, uc.full_name AS created_by_name, uu.full_name AS updated_by_name
             FROM news n
             LEFT JOIN users uc ON uc.id = n.created_by
             LEFT JOIN users uu ON uu.id = n.updated_by
             ORDER BY n.created_at DESC'
        );
    }

    public function getLatest(int $limit = 3): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news ORDER BY created_at DESC LIMIT :lim');
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->fetchOne('SELECT * FROM news WHERE slug = :slug LIMIT 1', ['slug' => $slug]);
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM news WHERE id = :id LIMIT 1', ['id' => $id]);
    }

    public function create(array $data, int $userId): bool
    {
        $title = Validator::sanitizeStorage($data['title'] ?? '');
        $body = Validator::sanitizeStorageMultiline($data['body'] ?? '');
        $slug = $this->ensureUniqueSlug(self::slugify($title));
        $stmt = $this->pdo->prepare(
            'INSERT INTO news (title, slug, body, image, pdf_file, created_by, updated_by)
             VALUES (:title, :slug, :body, :image, :pdf_file, :created_by, :updated_by)'
        );
        return $stmt->execute([
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'image' => $data['image'] ?? null,
            'pdf_file' => $data['pdf_file'] ?? null,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }

    public function update(int $id, array $data, int $userId): bool
    {
        $existing = $this->findById($id);
        if (!$existing) {
            return false;
        }

        $title = Validator::sanitizeStorage($data['title'] ?? '');
        $body = Validator::sanitizeStorageMultiline($data['body'] ?? '');
        $slug = self::slugify($title);
        if ($slug !== $existing['slug']) {
            $slug = $this->ensureUniqueSlug($slug, $id);
        }

        $stmt = $this->pdo->prepare(
            'UPDATE news
             SET title = :title,
                 slug = :slug,
                 body = :body,
                 image = :image,
                 pdf_file = :pdf_file,
                 updated_by = :updated_by
             WHERE id = :id'
        );

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'image' => $data['image'] ?? $existing['image'],
            'pdf_file' => $data['pdf_file'] ?? $existing['pdf_file'],
            'updated_by' => $userId,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM news WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    private function ensureUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $counter = 1;
        while (true) {
            $sql = 'SELECT id FROM news WHERE slug = :slug';
            $params = ['slug' => $slug];
            if ($ignoreId !== null) {
                $sql .= ' AND id != :id';
                $params['id'] = $ignoreId;
            }
            $exists = $this->fetchOne($sql . ' LIMIT 1', $params);
            if (!$exists) {
                return $slug;
            }
            $slug = $base . '-' . $counter++;
        }
    }
}
