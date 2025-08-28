<?php

require_once __DIR__ . '/../models/PurchaseRequest.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Brand.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/Proposal.php';

class BuyerController
{
    private $purchaseRequestModel;
    private $categoryModel;
    private $brandModel;
    private $notificationModel;
    private $proposalModel;

    public function __construct()
    {
        // Protect all methods in this controller for Buyers only
        require_auth('Buyer');
        $db = get_db_connection();
        $this->purchaseRequestModel = new PurchaseRequest($db);
        $this->categoryModel = new Category($db);
        $this->brandModel = new Brand($db);
        $this->notificationModel = new Notification($db);
        $this->proposalModel = new Proposal($db);
    }

    /**
     * Display the buyer's main dashboard.
     */
    public function dashboard()
    {
        // This will later show a list of their purchase requests.
        $notifications = $this->notificationModel->findAllForUser($_SESSION['user_id']);
        $data = [
            'page_title' => 'Buyer Dashboard',
            'notifications' => $notifications
        ];
        load_view('buyer/dashboard', $data);
    }

    /**
     * Display the form to create a new purchase request or handle submission.
     */
    public function createRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRequestId = $this->purchaseRequestModel->create(
                $_SESSION['user_id'],
                trim($_POST['title']),
                trim($_POST['description']),
                $_POST['category_id'],
                $_POST['quantity'],
                $_POST['delivery_date'] ?: null,
                isset($_POST['is_private']) ? 1 : 0,
                $_POST['brand_ids'] ?? []
            );

            if ($newRequestId) {
                // Find matching suppliers and create notifications
                $matchingSupplierIds = $this->purchaseRequestModel->findMatchingSuppliers($newRequestId);
                foreach ($matchingSupplierIds as $supplierId) {
                    $message = "New purchase request #" . $newRequestId . " matches your profile.";
                    $link = "/supplier/requests/" . $newRequestId; // This page needs to be created
                    $this->notificationModel->createForSupplier($supplierId, $message, $link);
                }
            }

            header('Location: /buyer/dashboard?request_created=success');
            exit();
        }

        // GET request: Show the form
        $categories = $this->categoryModel->findAll();
        $brands = $this->brandModel->findAll();

        $data = [
            'page_title' => 'Create New Purchase Request',
            'categories' => $categories,
            'brands' => $brands
        ];
        load_view('buyer/requests/new', $data);
    }

    public function viewRequest($requestId)
    {
        $request = $this->purchaseRequestModel->findById($requestId);
        // Security check: ensure the logged-in buyer owns this request
        if (!$request || $request['buyer_id'] != $_SESSION['user_id']) {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $proposals = $this->proposalModel->findAllByRequestId($requestId);

        $data = [
            'page_title' => 'Review Proposals for Request #' . $requestId,
            'request' => $request,
            'proposals' => $proposals
        ];
        load_view('buyer/requests/view', $data);
    }

    public function awardProposal($requestId, $winningProposalId)
    {
        // Security check
        $request = $this->purchaseRequestModel->findById($requestId);
        if (!$request || $request['buyer_id'] != $_SESSION['user_id']) {
            http_response_code(403);
            load_view('errors/403');
            return;
        }

        // Update statuses
        $this->purchaseRequestModel->updateStatus($requestId, 'awarded');
        $this->proposalModel->updateStatus($winningProposalId, 'awarded');

        $allProposals = $this->proposalModel->findAllByRequestId($requestId);
        foreach ($allProposals as $proposal) {
            if ($proposal['id'] == $winningProposalId) {
                // Notify winner
                $message = "Congratulations! Your proposal for Request #" . $requestId . " has been accepted.";
                $this->notificationModel->createForSupplier($proposal['supplier_id'], $message, '/supplier/dashboard');
            } else {
                // Notify losers
                $this->proposalModel->updateStatus($proposal['id'], 'rejected');
                $message = "Thank you for your proposal for Request #" . $requestId . ". It was not selected.";
                $this->notificationModel->createForSupplier($proposal['supplier_id'], $message, '/supplier/dashboard');
            }
        }

        header('Location: /buyer/requests/' . $requestId . '?awarded=success');
        exit();
    }
}
