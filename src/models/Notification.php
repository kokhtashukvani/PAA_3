<?php

class Notification
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create a notification for a supplier.
     *
     * @param int $supplierId
     * @param string $message
     * @param string|null $link
     * @return bool
     */
    public function createForSupplier($supplierId, $message, $link = null)
    {
        $sql = "INSERT INTO notifications (supplier_id, message, link) VALUES (:supplier_id, :message, :link)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':supplier_id' => $supplierId,
            ':message' => $message,
            ':link' => $link,
        ]);
    }

    /**
     * Create a notification for a user (Buyer/Admin).
     *
     * @param int $userId
     * @param string $message
     * @param string|null $link
     * @return bool
     */
    public function createForUser($userId, $message, $link = null)
    {
        $sql = "INSERT INTO notifications (user_id, message, link) VALUES (:user_id, :message, :link)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':message' => $message,
            ':link' => $link,
        ]);
    }

    public function findAllForUser($userId)
    {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findAllForSupplier($supplierId)
    {
        $sql = "SELECT * FROM notifications WHERE supplier_id = :supplier_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':supplier_id' => $supplierId]);
        return $stmt->fetchAll();
    }

    public function markAsRead($notificationId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $notificationId]);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
