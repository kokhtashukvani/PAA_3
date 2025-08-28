<?php

require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Brand.php';

class SupplierRegistrationController
{
    private $supplierModel;
    private $categoryModel;
    private $brandModel;

    public function __construct()
    {
        $db = get_db_connection();
        $this->supplierModel = new Supplier($db);
        $this->categoryModel = new Category($db);
        $this->brandModel = new Brand($db);
    }

    /**
     * Display the supplier registration page or handle form submission.
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $companyName = trim($_POST['company_name']);
            $email = trim($_POST['contact_email']);
            $phone = trim($_POST['phone_number']);
            $password = $_POST['password'];
            $categoryIds = $_POST['category_ids'] ?? [];
            $brandIds = $_POST['brand_ids'] ?? [];

            // Basic validation
            if (empty($companyName) || empty($email) || empty($password)) {
                // In a real app, show a proper error message
                header('Location: /supplier/register');
                exit();
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $supplierId = $this->supplierModel->create($companyName, $email, $passwordHash, $phone);

            if ($supplierId) {
                // Link categories and brands
                $this->supplierModel->linkToCategories($supplierId, $categoryIds);
                $this->supplierModel->linkToBrands($supplierId, $brandIds);

                // Send notification email
                $subject = "Registration Received - " . APP_NAME;
                $message = "Hello " . $companyName . ",\n\nThank you for registering with the " . APP_NAME . ". Your application is now under review by our team. You will be notified once your account has been approved.\n\nThank you.";
                send_email($email, $subject, $message);

                // Redirect to a success page or login page
                load_view('supplier/register_success');
                return;
            } else {
                // Handle registration failure
                header('Location: /supplier/register?error=1');
                exit();
            }
        }

        // Handle GET request: Show the form
        $categories = $this->categoryModel->findAll();
        $brands = $this->brandModel->findAll();

        $data = [
            'page_title' => 'Supplier Registration',
            'categories' => $categories,
            'brands' => $brands
        ];
        load_view('supplier/register', $data);
    }
}
