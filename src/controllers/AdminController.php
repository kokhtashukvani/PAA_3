<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Brand.php';
require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../models/Setting.php';

class AdminController
{
    private $userModel;
    private $categoryModel;
    private $brandModel;
    private $supplierModel;
    private $settingModel;

    public function __construct()
    {
        // Protect all methods in this controller
        require_auth('Admin');

        $db = get_db_connection();
        $this->userModel = new User($db);
        $this->categoryModel = new Category($db);
        $this->brandModel = new Brand($db);
        $this->supplierModel = new Supplier($db);
        $this->settingModel = new Setting($db);
    }

    /**
     * Display the main admin dashboard.
     */
    public function dashboard()
    {
        // Data for the dashboard can be fetched here later.
        $data = [
            'page_title' => 'Admin Dashboard'
        ];
        load_view('admin/dashboard', $data);
    }

    /**
     * List all categories.
     */
    public function listCategories()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            'page_title' => 'Manage Categories',
            'categories' => $categories
        ];
        load_view('admin/categories/index', $data);
    }

    /**
     * Handle creation of a new category (show form and process submission).
     */
    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $this->categoryModel->create($name);
            }
            header('Location: /admin/categories');
            exit();
        }

        $data = [
            'page_title' => 'Add New Category',
            'category' => ['id' => null, 'name' => ''],
            'form_action' => '/admin/categories/new'
        ];
        load_view('admin/categories/form', $data);
    }

    /**
     * Handle editing an existing category (show form and process submission).
     */
    public function editCategory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $this->categoryModel->update($id, $name);
            }
            header('Location: /admin/categories');
            exit();
        }

        $category = $this->categoryModel->findById($id);
        if (!$category) {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $data = [
            'page_title' => 'Edit Category',
            'category' => $category,
            'form_action' => '/admin/categories/edit/' . $id
        ];
        load_view('admin/categories/form', $data);
    }

    /**
     * Handle deletion of a category.
     */
    public function deleteCategory($id)
    {
        // This should be a POST request for safety.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->delete($id);
        }
        header('Location: /admin/categories');
        exit();
    }

    //======================================================================
    // Brand Management
    //======================================================================

    public function listBrands()
    {
        $brands = $this->brandModel->findAll();
        $data = [
            'page_title' => 'Manage Brands',
            'brands' => $brands
        ];
        load_view('admin/brands/index', $data);
    }

    public function createBrand()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $this->brandModel->create($name);
            }
            header('Location: /admin/brands');
            exit();
        }

        $data = [
            'page_title' => 'Add New Brand',
            'brand' => ['id' => null, 'name' => ''],
            'form_action' => '/admin/brands/new'
        ];
        load_view('admin/brands/form', $data);
    }

    public function editBrand($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $this->brandModel->update($id, $name);
            }
            header('Location: /admin/brands');
            exit();
        }

        $brand = $this->brandModel->findById($id);
        if (!$brand) {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $data = [
            'page_title' => 'Edit Brand',
            'brand' => $brand,
            'form_action' => '/admin/brands/edit/' . $id
        ];
        load_view('admin/brands/form', $data);
    }

    public function deleteBrand($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->brandModel->delete($id);
        }
        header('Location: /admin/brands');
        exit();
    }

    //======================================================================
    // Buyer (User) Management
    //======================================================================

    public function listBuyers()
    {
        $buyers = $this->userModel->findAllByRole('Buyer');
        $data = [
            'page_title' => 'Manage Buyers',
            'buyers' => $buyers
        ];
        load_view('admin/buyers/index', $data);
    }

    public function createBuyer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (!empty($fullName) && !empty($email) && !empty($password)) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->createUser($fullName, $email, $passwordHash, 'Buyer');
            }
            header('Location: /admin/buyers');
            exit();
        }

        $data = [
            'page_title' => 'Add New Buyer',
            'buyer' => ['id' => null, 'full_name' => '', 'email' => ''],
            'form_action' => '/admin/buyers/new'
        ];
        load_view('admin/buyers/form', $data);
    }

    public function editBuyer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password']; // Can be empty

            if (!empty($fullName) && !empty($email)) {
                $this->userModel->updateUser($id, $fullName, $email, $password);
            }
            header('Location: /admin/buyers');
            exit();
        }

        $buyer = $this->userModel->findById($id);
        if (!$buyer || $buyer['role'] !== 'Buyer') {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $data = [
            'page_title' => 'Edit Buyer',
            'buyer' => $buyer,
            'form_action' => '/admin/buyers/edit/' . $id
        ];
        load_view('admin/buyers/form', $data);
    }

    public function deleteBuyer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->delete($id);
        }
        header('Location: /admin/buyers');
        exit();
    }

    //======================================================================
    // Supplier Approval
    //======================================================================

    public function listPendingSuppliers()
    {
        $suppliers = $this->supplierModel->findAllByStatus('pending');
        $data = [
            'page_title' => 'Pending Supplier Approvals',
            'suppliers' => $suppliers
        ];
        load_view('admin/suppliers/pending', $data);
    }

    public function approveSupplier($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->updateStatus($id, 'approved');
            // TODO: Send email notification to supplier
        }
        header('Location: /admin/suppliers/pending');
        exit();
    }

    public function rejectSupplier($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->updateStatus($id, 'rejected');
            // TODO: Send email notification to supplier
        }
        header('Location: /admin/suppliers/pending');
        exit();
    }

    //======================================================================
    // Full Supplier CRUD
    //======================================================================

    public function listSuppliers()
    {
        $suppliers = $this->supplierModel->findAll();
        $data = [
            'page_title' => 'Manage All Suppliers',
            'suppliers' => $suppliers
        ];
        load_view('admin/suppliers/index', $data);
    }

    public function createSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->adminCreate(
                trim($_POST['company_name']),
                trim($_POST['contact_email']),
                $_POST['password'],
                trim($_POST['phone_number']),
                $_POST['status']
            );
            header('Location: /admin/suppliers');
            exit();
        }

        $data = [
            'page_title' => 'Add New Supplier',
            'supplier' => ['id' => null, 'company_name' => '', 'contact_email' => '', 'phone_number' => '', 'status' => 'approved'],
            'form_action' => '/admin/suppliers/new'
        ];
        load_view('admin/suppliers/form', $data);
    }

    public function editSupplier($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->update(
                $id,
                trim($_POST['company_name']),
                trim($_POST['contact_email']),
                trim($_POST['phone_number']),
                $_POST['status']
            );
            header('Location: /admin/suppliers');
            exit();
        }

        $supplier = $this->supplierModel->findById($id);
        if (!$supplier) {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $data = [
            'page_title' => 'Edit Supplier',
            'supplier' => $supplier,
            'form_action' => '/admin/suppliers/edit/' . $id
        ];
        load_view('admin/suppliers/form', $data);
    }

    public function deleteSupplier($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->delete($id);
        }
        header('Location: /admin/suppliers');
        exit();
    }

    //======================================================================
    // Settings
    //======================================================================

    public function settings()
    {
        $success_message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Loop through POST data and save each setting
            foreach ($_POST as $key => $value) {
                $this->settingModel->updateSetting($key, trim($value));
            }
            $success_message = "Settings saved successfully!";
        }

        $settings = $this->settingModel->getSettings();
        $data = [
            'page_title' => 'Global Settings',
            'settings' => $settings,
            'success_message' => $success_message
        ];
        load_view('admin/settings', $data);
    }
}
