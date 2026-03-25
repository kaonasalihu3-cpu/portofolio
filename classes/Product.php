<?php
declare(strict_types=1);

class Product extends Content
{
    public function getAll(): array
    {
        return $this->fetchAllRows(
            'SELECT p.*, uc.full_name AS created_by_name, uu.full_name AS updated_by_name
             FROM products p
             LEFT JOIN users uc ON uc.id = p.created_by
             LEFT JOIN users uu ON uu.id = p.updated_by
             ORDER BY p.created_at DESC'
        );
    }

    public function getFeatured(int $limit = 3): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY created_at DESC LIMIT :lim');
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->fetchOne('SELECT * FROM products WHERE slug = :slug LIMIT 1', ['slug' => $slug]);
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM products WHERE id = :id LIMIT 1', ['id' => $id]);
    }

    public function create(array $data, int $userId): bool
    {
        $title = Validator::sanitizeStorage($data['title'] ?? '');
        $shortDescription = Validator::sanitizeStorageMultiline($data['short_description'] ?? '');
        $body = Validator::sanitizeStorageMultiline($data['body'] ?? '');

        $slug = self::slugify($title);
        $slug = $this->ensureUniqueSlug($slug);

        $stmt = $this->pdo->prepare(
            'INSERT INTO products (title, slug, short_description, body, image, pdf_file, created_by, updated_by)
             VALUES (:title, :slug, :short_description, :body, :image, :pdf_file, :created_by, :updated_by)'
        );

        return $stmt->execute([
            'title' => $title,
            'slug' => $slug,
            'short_description' => $shortDescription,
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
        $shortDescription = Validator::sanitizeStorageMultiline($data['short_description'] ?? '');
        $body = Validator::sanitizeStorageMultiline($data['body'] ?? '');

        $slug = self::slugify($title);
        if ($slug !== $existing['slug']) {
            $slug = $this->ensureUniqueSlug($slug, $id);
        }

        $stmt = $this->pdo->prepare(
            'UPDATE products
             SET title = :title,
                 slug = :slug,
                 short_description = :short_description,
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
            'short_description' => $shortDescription,
            'body' => $body,
            'image' => $data['image'] ?? $existing['image'],
            'pdf_file' => $data['pdf_file'] ?? $existing['pdf_file'],
            'updated_by' => $userId,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    private function ensureUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $counter = 1;
        while (true) {
            $sql = 'SELECT id FROM products WHERE slug = :slug';
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
