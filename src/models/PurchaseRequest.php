<?php

class PurchaseRequest
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create a new purchase request.
     *
     * @param int $buyerId
     * @param string $title
     * @param string $description
     * @param int $categoryId
     * @param int $quantity
     * @param string|null $deliveryDate
     * @param bool $isPrivate
     * @param array $brandIds
     * @return int|false The ID of the new request or false on failure.
     */
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE purchase_requests SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, c.name as category_name
            FROM purchase_requests r
            JOIN categories c ON r.category_id = c.id
            WHERE r.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function findMatchingSuppliers($requestId)
    {
        // First, get the request details
        $stmt = $this->pdo->prepare("
            SELECT r.category_id, GROUP_CONCAT(rb.brand_id) as brand_ids
            FROM purchase_requests r
            LEFT JOIN request_brands rb ON r.id = rb.request_id
            WHERE r.id = :request_id
            GROUP BY r.id
        ");
        $stmt->execute([':request_id' => $requestId]);
        $request = $stmt->fetch();

        if (!$request) {
            return [];
        }

        $categoryId = $request['category_id'];
        $brandIds = $request['brand_ids'] ? explode(',', $request['brand_ids']) : [];

        // Build the query to find matching suppliers
        $sql = "
            SELECT DISTINCT s.id
            FROM suppliers s
            INNER JOIN supplier_categories sc ON s.id = sc.supplier_id
        ";

        if (!empty($brandIds)) {
            $sql .= " INNER JOIN supplier_brands sb ON s.id = sb.supplier_id ";
        }

        $sql .= " WHERE s.status = 'approved' AND sc.category_id = :category_id ";

        if (!empty($brandIds)) {
            $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
            $sql .= " AND sb.brand_id IN ($placeholders) ";
        }

        $stmt = $this->pdo->prepare($sql);

        $params = [':category_id' => $categoryId];
        $i = 1;
        foreach ($brandIds as $brandId) {
            $stmt->bindValue($i++, $brandId, PDO::PARAM_INT);
        }
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function create($buyerId, $title, $description, $categoryId, $quantity, $deliveryDate, $isPrivate, $brandIds)
    {
        $this->pdo->beginTransaction();

        try {
            // Insert into the main purchase_requests table
            $sql = "INSERT INTO purchase_requests (buyer_id, title, description, category_id, quantity, delivery_date, is_private)
                    VALUES (:buyer_id, :title, :description, :category_id, :quantity, :delivery_date, :is_private)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':buyer_id' => $buyerId,
                ':title' => $title,
                ':description' => $description,
                ':category_id' => $categoryId,
                ':quantity' => $quantity,
                ':delivery_date' => $deliveryDate,
                ':is_private' => $isPrivate,
            ]);

            $requestId = $this->pdo->lastInsertId();

            // Insert into the request_brands pivot table
            if (!empty($brandIds)) {
                $sql_brands = "INSERT INTO request_brands (request_id, brand_id) VALUES ";
                $placeholders = [];
                $params = [];
                foreach ($brandIds as $brandId) {
                    $placeholders[] = "(?, ?)";
                    $params[] = $requestId;
                    $params[] = $brandId;
                }
                $sql_brands .= implode(', ', $placeholders);
                $stmt_brands = $this->pdo->prepare($sql_brands);
                $stmt_brands->execute($params);
            }

            $this->pdo->commit();
            return $requestId;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            // In a real app, log the error: error_log($e->getMessage());
            return false;
        }
    }
}
