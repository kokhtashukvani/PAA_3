<?php

class Category
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all categories.
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Find a single category by its ID.
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Create a new category.
     * @param string $name
     * @return bool
     */
    public function create($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $name]);
    }

    /**
     * Update an existing category.
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function update($id, $name)
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    /**
     * Delete a category.
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
