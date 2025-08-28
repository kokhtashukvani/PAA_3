<?php

require_once __DIR__ . '/../models/Notification.php';

class NotificationController
{
    private $notificationModel;

    public function __construct()
    {
        $db = get_db_connection();
        $this->notificationModel = new Notification($db);
    }

    public function markAsRead($notificationId)
    {
        // This action requires either a user or a supplier to be logged in.
        if (!is_logged_in() && !is_supplier_logged_in()) {
            http_response_code(403);
            load_view('errors/403');
            return;
        }

        // We need to fetch the notification to check ownership and get the redirect link
        $notification = $this->notificationModel->findById($notificationId); // This method needs to be added

        if ($notification) {
            $isOwner = (is_logged_in() && $notification['user_id'] == $_SESSION['user_id']) ||
                       (is_supplier_logged_in() && $notification['supplier_id'] == $_SESSION['supplier_id']);

            if ($isOwner) {
                $this->notificationModel->markAsRead($notificationId);
                // Redirect to the notification's link, or back to the dashboard.
                header('Location: ' . ($notification['link'] ?? '/'));
                exit();
            }
        }

        // If something went wrong, just go to the home page.
        header('Location: /');
        exit();
    }
}
