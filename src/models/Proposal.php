<?php

class Proposal
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create a new proposal for a purchase request.
     *
     * @param int $requestId
     * @param int $supplierId
     * @param float $unitPrice
     * @param float $totalPrice
     * @param int $deliveryTimeDays
     * @param string $paymentTerms
     * @param int $validityPeriodDays
     * @param string $notes
     * @param string|null $invoicePath
     * @return bool
     */
    public function create($requestId, $supplierId, $unitPrice, $totalPrice, $deliveryTimeDays, $paymentTerms, $validityPeriodDays, $notes, $invoicePath)
    {
        $sql = "INSERT INTO proposals (request_id, supplier_id, unit_price, total_price, delivery_time_days, payment_terms, validity_period_days, notes, proforma_invoice_path)
                VALUES (:request_id, :supplier_id, :unit_price, :total_price, :delivery_time_days, :payment_terms, :validity_period_days, :notes, :proforma_invoice_path)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':request_id' => $requestId,
            ':supplier_id' => $supplierId,
            ':unit_price' => $unitPrice,
            ':total_price' => $totalPrice,
            ':delivery_time_days' => $deliveryTimeDays,
            ':payment_terms' => $paymentTerms,
            ':validity_period_days' => $validityPeriodDays,
            ':notes' => $notes,
            ':proforma_invoice_path' => $invoicePath,
        ]);
    }

    public function findAllByRequestId($requestId)
    {
        $sql = "SELECT p.*, s.company_name
                FROM proposals p
                JOIN suppliers s ON p.supplier_id = s.id
                WHERE p.request_id = :request_id
                ORDER BY p.total_price ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':request_id' => $requestId]);
        return $stmt->fetchAll();
    }

    public function updateStatus($proposalId, $status)
    {
        $sql = "UPDATE proposals SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $proposalId, 'status' => $status]);
    }
}
