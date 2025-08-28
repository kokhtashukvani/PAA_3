<?php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierAuthController
{
    private $supplierModel;

    public function __construct()
    {
        $db = get_db_connection();
        $this->supplierModel = new Supplier($db);
    }

    /**
     * Display the supplier login page or handle login form submission.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $supplier = $this->supplierModel->findByEmail($email); // This method needs to be added to the model

            if ($supplier && $supplier['status'] === 'approved' && password_verify($password, $supplier['password'])) {
                // Password is correct, start session
                session_start();
                session_regenerate_id(true);
                $_SESSION['supplier_id'] = $supplier['id'];
                $_SESSION['supplier_company_name'] = $supplier['company_name'];

                header('Location: /supplier/dashboard');
                exit();
            } else {
                // Handle login failure
                $error = 'Invalid credentials or account not approved.';
                load_view('supplier/login', ['error' => $error]);
                return;
            }
        }

        load_view('supplier/login');
    }

    /**
     * Handle supplier logout.
     */
    public function logout()
    {
        session_start();
        unset($_SESSION['supplier_id']);
        unset($_SESSION['supplier_company_name']);
        session_destroy();
        header('Location: /supplier/login');
        exit();
    }
}
