<?php
// APPLICATION (BUSINESS) LAYER - validation and rules, no SQL, no HTML
class UserService {
    public function __construct(private UserRepository $repo) {}

    private function clean(array $in): array {
        $name  = trim($in['name'] ?? '');
        $email = trim($in['email'] ?? '');
        if ($name === '' || strlen($name) > 100)  throw new InvalidArgumentException('Name is required (max 100 chars).');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('A valid email is required.');
        return [$name, $email];
    }
    private function guard(callable $fn) {
        try { return $fn(); }
        catch (PDOException $e) {
            if ($e->getCode() === '23000') throw new InvalidArgumentException('That email already exists.');
            throw $e;
        }
    }

    public function list(): array { return $this->repo->all(); }

    public function get(int $id): array {
        return $this->repo->find($id) ?? throw new InvalidArgumentException('User not found.');
    }
    public function create(array $in): array {
        [$n, $e] = $this->clean($in);
        $id = $this->guard(fn() => $this->repo->create($n, $e));
        return $this->repo->find($id);
    }
    public function update(int $id, array $in): array {
        $this->get($id);
        [$n, $e] = $this->clean($in);
        $this->guard(fn() => $this->repo->update($id, $n, $e));
        return $this->repo->find($id);
    }
    public function delete(int $id): void {
        $this->get($id);
        $this->repo->delete($id);
    }
}
