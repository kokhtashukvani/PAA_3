<?php

class Brand
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all brands.
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM brands ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Find a single brand by its ID.
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM brands WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Create a new brand.
     * @param string $name
     * @return bool
     */
    public function create($name)
    {
        $sql = "INSERT INTO brands (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $name]);
    }

    /**
     * Update an existing brand.
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function update($id, $name)
    {
        $sql = "UPDATE brands SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    /**
     * Delete a brand.
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM brands WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
