<?php

class Supplier
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all suppliers by a given status.
     * @param string $status e.g., 'pending', 'approved', 'rejected'
     * @return array
     */
    public function findAllByStatus($status)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE status = :status ORDER BY created_at DESC");
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll();
    }

    /**
     * Find a single supplier by its ID.
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM suppliers WHERE contact_email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Update the status of a supplier.
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE suppliers SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    /**
     * Create a new supplier.
     * @param string $companyName
     * @param string $contactEmail
     * @param string $passwordHash
     * @param string $phoneNumber
     * @return bool
     */
    public function create($companyName, $contactEmail, $passwordHash, $phoneNumber)
    {
        $sql = "INSERT INTO suppliers (company_name, contact_email, password, phone_number, status) VALUES (:company_name, :contact_email, :password, :phone_number, 'pending')";
        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            'company_name' => $companyName,
            'contact_email' => $contactEmail,
            'password' => $passwordHash,
            'phone_number' => $phoneNumber
        ]);

        return $success ? $this->pdo->lastInsertId() : false;
    }

    public function linkToCategories($supplierId, $categoryIds)
    {
        if (empty($categoryIds)) return;
        $sql = "INSERT INTO supplier_categories (supplier_id, category_id) VALUES ";
        $params = [];
        $placeholders = [];
        foreach ($categoryIds as $catId) {
            $placeholders[] = "(?, ?)";
            $params[] = $supplierId;
            $params[] = $catId;
        }
        $sql .= implode(', ', $placeholders);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function linkToBrands($supplierId, $brandIds)
    {
        if (empty($brandIds)) return;
        $sql = "INSERT INTO supplier_brands (supplier_id, brand_id) VALUES ";
        $params = [];
        $placeholders = [];
        foreach ($brandIds as $brandId) {
            $placeholders[] = "(?, ?)";
            $params[] = $supplierId;
            $params[] = $brandId;
        }
        $sql .= implode(', ', $placeholders);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function findAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM suppliers ORDER BY company_name ASC");
        return $stmt->fetchAll();
    }

    public function update($id, $companyName, $contactEmail, $phoneNumber, $status)
    {
        $sql = "UPDATE suppliers SET company_name = :company_name, contact_email = :contact_email, phone_number = :phone_number, status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'company_name' => $companyName,
            'contact_email' => $contactEmail,
            'phone_number' => $phoneNumber,
            'status' => $status
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM suppliers WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function adminCreate($companyName, $contactEmail, $password, $phoneNumber, $status)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO suppliers (company_name, contact_email, password, phone_number, status) VALUES (:company_name, :contact_email, :password, :phone_number, :status)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'company_name' => $companyName,
            'contact_email' => $contactEmail,
            'password' => $passwordHash,
            'phone_number' => $phoneNumber,
            'status' => $status
        ]);
    }
}
