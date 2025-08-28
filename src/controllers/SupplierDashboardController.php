<?php

require_once __DIR__ . '/../models/Notification.php';

class SupplierDashboardController
{
    private $notificationModel;

    public function __construct()
    {
        // Protect all methods in this controller for Suppliers only
        require_supplier_auth();
        $db = get_db_connection();
        $this->notificationModel = new Notification($db);
    }

    /**
     * Display the supplier's main dashboard.
     */
    public function index()
    {
        // This will later show new requests, submitted quotes, etc.
        $notifications = $this->notificationModel->findAllForSupplier($_SESSION['supplier_id']);
        $data = [
            'page_title' => 'Supplier Dashboard',
            'notifications' => $notifications
        ];
        load_view('supplier/dashboard', $data);
    }
}
