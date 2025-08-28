<?php

class User
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Check if any admin user exists in the database.
     * @return bool
     */
    public function adminExists()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'Admin'");
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Find a user by their email address.
     * @param string $email
     * @return mixed The user data as an associative array or false if not found.
     */
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Create a new user.
     * @param string $fullName
     * @param string $email
     * @param string $passwordHash
     * @param string $role
     * @return bool True on success, false on failure.
     */
    public function createUser($fullName, $email, $passwordHash, $role)
    {
        $sql = "INSERT INTO users (full_name, email, password, role) VALUES (:full_name, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'full_name' => $fullName,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role
        ]);
    }

    public function findAllByRole($role)
    {
        $stmt = $this->pdo->prepare("SELECT id, full_name, email, created_at FROM users WHERE role = :role ORDER BY full_name ASC");
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateUser($id, $fullName, $email, $password = null)
    {
        $params = [
            'id' => $id,
            'full_name' => $fullName,
            'email' => $email
        ];

        if ($password) {
            $params['password'] = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET full_name = :full_name, email = :email, password = :password WHERE id = :id";
        } else {
            $sql = "UPDATE users SET full_name = :full_name, email = :email WHERE id = :id";
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
