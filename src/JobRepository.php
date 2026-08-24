<?php

declare(strict_types=1);

final class JobRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function search(string $query, string $location, bool $remote, int $limit, int $offset): array
    {
        $where = ["j.status = 'published'", "(j.expires_at IS NULL OR datetime(j.expires_at) >= datetime('now'))"];
        $params = [];

        if ($query !== '') {
            $where[] = '(j.title LIKE :query OR j.company LIKE :query OR j.description LIKE :query)';
            $params[':query'] = '%' . $query . '%';
        }
        if ($location !== '') {
            $where[] = 'j.location LIKE :location';
            $params[':location'] = '%' . $location . '%';
        }
        if ($remote) {
            $where[] = 'j.is_remote = 1';
        }

        $sql = 'SELECT j.*, s.name AS source_name
                FROM jobs j
                LEFT JOIN sources s ON s.id = j.source_id
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY datetime(j.published_at) DESC, j.id DESC
                LIMIT :limit OFFSET :offset';
        $statement = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value, PDO::PARAM_STR);
        }
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function count(string $query, string $location, bool $remote): int
    {
        $where = ["status = 'published'", "(expires_at IS NULL OR datetime(expires_at) >= datetime('now'))"];
        $params = [];

        if ($query !== '') {
            $where[] = '(title LIKE :query OR company LIKE :query OR description LIKE :query)';
            $params[':query'] = '%' . $query . '%';
        }
        if ($location !== '') {
            $where[] = 'location LIKE :location';
            $params[':location'] = '%' . $location . '%';
        }
        if ($remote) {
            $where[] = 'is_remote = 1';
        }

        $statement = $this->pdo->prepare('SELECT COUNT(*) FROM jobs WHERE ' . implode(' AND ', $where));
        $statement->execute($params);
        return (int) $statement->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            "SELECT j.*, s.name AS source_name
             FROM jobs j
             LEFT JOIN sources s ON s.id = j.source_id
             WHERE j.id = :id
               AND j.status = 'published'
               AND (j.expires_at IS NULL OR datetime(j.expires_at) >= datetime('now'))"
        );
        $statement->execute([':id' => $id]);
        $job = $statement->fetch();
        return $job === false ? null : $job;
    }
}
