<?php
// DATA LAYER - only place that talks SQL
class UserRepository {
    public function __construct(private PDO $db) {}

    public function all(): array {
        return $this->db->query('SELECT * FROM tblusers ORDER BY id DESC')->fetchAll();
    }
    public function find(int $id): ?array {
        $s = $this->db->prepare('SELECT * FROM tblusers WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }
    public function create(string $name, string $email): int {
        $s = $this->db->prepare('INSERT INTO tblusers (name, email) VALUES (?, ?)');
        $s->execute([$name, $email]);
        return (int)$this->db->lastInsertId();
    }
    public function update(int $id, string $name, string $email): bool {
        $s = $this->db->prepare('UPDATE tblusers SET name = ?, email = ? WHERE id = ?');
        return $s->execute([$name, $email, $id]);
    }
    public function delete(int $id): bool {
        $s = $this->db->prepare('DELETE FROM tblusers WHERE id = ?');
        return $s->execute([$id]);
    }
}
