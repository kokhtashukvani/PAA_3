<?php

require_once __DIR__ . '/../models/PurchaseRequest.php';
require_once __DIR__ . '/../models/Proposal.php';

class ProposalController
{
    private $purchaseRequestModel;
    private $proposalModel;

    public function __construct()
    {
        require_supplier_auth();
        $db = get_db_connection();
        $this->purchaseRequestModel = new PurchaseRequest($db);
        $this->proposalModel = new Proposal($db);
    }

    /**
     * View a single purchase request and submit a proposal.
     */
    public function viewRequest($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle file upload first
            $invoicePath = null;
            if (isset($_FILES['proforma_invoice']) && $_FILES['proforma_invoice']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $fileName = uniqid('invoice_') . '_' . basename($_FILES['proforma_invoice']['name']);
                $uploadFile = $uploadDir . $fileName;

                // Basic validation (e.g., check if it's a PDF)
                $fileType = mime_content_type($_FILES['proforma_invoice']['tmp_name']);
                if ($fileType === 'application/pdf') {
                    if (move_uploaded_file($_FILES['proforma_invoice']['tmp_name'], $uploadFile)) {
                        $invoicePath = '/uploads/' . $fileName;
                    }
                }
            }

            // Save proposal to database
            $this->proposalModel->create(
                $requestId,
                $_SESSION['supplier_id'],
                $_POST['unit_price'],
                $_POST['total_price'],
                $_POST['delivery_time_days'],
                trim($_POST['payment_terms']),
                $_POST['validity_period_days'],
                trim($_POST['notes']),
                $invoicePath
            );

            // Notify the buyer
            $request = $this->purchaseRequestModel->findById($requestId);
            if ($request) {
                $notificationModel = new Notification(get_db_connection());
                $message = "Supplier " . $_SESSION['supplier_company_name'] . " submitted a proposal for Request #" . $requestId;
                $link = "/buyer/requests/" . $requestId; // This page needs to be created
                $notificationModel->createForUser($request['buyer_id'], $message, $link);
            }

            header("Location: /supplier/dashboard?proposal_submitted=success");
            exit();
        }

        // GET request: Show the request details and proposal form
        $request = $this->purchaseRequestModel->findById($requestId);
        if (!$request) {
            http_response_code(404);
            load_view('errors/404');
            return;
        }

        $data = [
            'page_title' => 'Submit Proposal for Request #' . $requestId,
            'request' => $request
        ];
        load_view('supplier/requests/view', $data);
    }
}
