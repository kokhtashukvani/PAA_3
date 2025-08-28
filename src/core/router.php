<?php

/**
 * Basic Router
 */

/**
 * Handles the incoming request and determines the route.
 *
 * @param string $uri The request URI.
 * @return array A simple array with controller and action.
 */
function handle_request($uri)
{
    // Remove query string from URI
    $uri = strtok($uri, '?');

    // Remove base path if the app is in a subdirectory (optional, good practice)
    // For now, we assume it's at the root.
    $path = trim($uri, '/');

    $path = trim(strtok($uri, '?'), '/');

    $routes = [
        // Home
        '' => ['controller' => 'HomeController', 'action' => 'index'],

        // Auth
        'login' => ['controller' => 'AuthController', 'action' => 'login'],
        'register' => ['controller' => 'AuthController', 'action' => 'register'],
        'logout' => ['controller' => 'AuthController', 'action' => 'logout'],

        // Admin Dashboard
        'admin/dashboard' => ['controller' => 'AdminController', 'action' => 'dashboard'],

        // Admin Categories
        'admin/categories' => ['controller' => 'AdminController', 'action' => 'listCategories'],
        'admin/categories/new' => ['controller' => 'AdminController', 'action' => 'createCategory'], // POST and GET
        'admin/categories/edit/(\d+)' => ['controller' => 'AdminController', 'action' => 'editCategory'], // POST and GET
        'admin/categories/delete/(\d+)' => ['controller' => 'AdminController', 'action' => 'deleteCategory'], // POST

        // Admin Brands
        'admin/brands' => ['controller' => 'AdminController', 'action' => 'listBrands'],
        'admin/brands/new' => ['controller' => 'AdminController', 'action' => 'createBrand'], // POST and GET
        'admin/brands/edit/(\d+)' => ['controller' => 'AdminController', 'action' => 'editBrand'], // POST and GET
        'admin/brands/delete/(\d+)' => ['controller' => 'AdminController', 'action' => 'deleteBrand'], // POST

        // Admin Buyers (Users)
        'admin/buyers' => ['controller' => 'AdminController', 'action' => 'listBuyers'],
        'admin/buyers/new' => ['controller' => 'AdminController', 'action' => 'createBuyer'], // POST and GET
        'admin/buyers/edit/(\d+)' => ['controller' => 'AdminController', 'action' => 'editBuyer'], // POST and GET
        'admin/buyers/delete/(\d+)' => ['controller' => 'AdminController', 'action' => 'deleteBuyer'], // POST

        // Admin Supplier Management
        'admin/suppliers' => ['controller' => 'AdminController', 'action' => 'listSuppliers'],
        'admin/suppliers/pending' => ['controller' => 'AdminController', 'action' => 'listPendingSuppliers'],
        'admin/suppliers/new' => ['controller' => 'AdminController', 'action' => 'createSupplier'],
        'admin/suppliers/edit/(\d+)' => ['controller' => 'AdminController', 'action' => 'editSupplier'],
        'admin/suppliers/delete/(\d+)' => ['controller' => 'AdminController', 'action' => 'deleteSupplier'],
        'admin/suppliers/approve/(\d+)' => ['controller' => 'AdminController', 'action' => 'approveSupplier'], // POST
        'admin/suppliers/reject/(\d+)' => ['controller' => 'AdminController', 'action' => 'rejectSupplier'], // POST

        // Admin Settings
        'admin/settings' => ['controller' => 'AdminController', 'action' => 'settings'], // GET and POST

        // Supplier facing pages
        'supplier/register' => ['controller' => 'SupplierRegistrationController', 'action' => 'register'],
        'supplier/login' => ['controller' => 'SupplierAuthController', 'action' => 'login'],
        'supplier/logout' => ['controller' => 'SupplierAuthController', 'action' => 'logout'],
        'supplier/dashboard' => ['controller' => 'SupplierDashboardController', 'action' => 'index'],

        // Buyer facing pages
        'buyer/dashboard' => ['controller' => 'BuyerController', 'action' => 'dashboard'],
        'buyer/requests/new' => ['controller' => 'BuyerController', 'action' => 'createRequest'],
        'buyer/requests/(\d+)' => ['controller' => 'BuyerController', 'action' => 'viewRequest'],
        'buyer/requests/(\d+)/award/(\d+)' => ['controller' => 'BuyerController', 'action' => 'awardProposal'],


        // Supplier - Proposals
        'supplier/requests/(\d+)' => ['controller' => 'ProposalController', 'action' => 'viewRequest'],

        // Notifications
        'notifications/read/(\d+)' => ['controller' => 'NotificationController', 'action' => 'markAsRead'],
    ];

    foreach ($routes as $route => $target) {
        $pattern = '#^' . $route . '$#';
        if (preg_match($pattern, $path, $matches)) {
            // Remove the full match from the beginning of the array
            array_shift($matches);
            // Assign the captured parameters to the target
            $target['params'] = $matches;
            return $target;
        }
    }

    // If no route was matched
    return ['controller' => 'ErrorController', 'action' => 'notFound'];
}
