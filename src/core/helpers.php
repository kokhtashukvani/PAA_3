<?php

/**
 * Helper functions
 */

/**
 * Load a view file from the templates directory.
 *
 * @param string $viewName The name of the view file (without .php extension).
 * @param array $data Data to be extracted for use in the view.
 */
function load_view($viewName, $data = [])
{
    // Make variables available to the view
    extract($data);

    $viewPath = __DIR__ . '/../../templates/' . $viewName . '.php';

    if (file_exists($viewPath)) {
        // Load header
        require_once __DIR__ . '/../../templates/partials/header.php';

        // Load the main view content
        require_once $viewPath;

        // Load footer
        require_once __DIR__ . '/../../templates/partials/footer.php';
    } else {
        // A simple error for a missing view
        load_view('errors/404');
    }
}

/**
 * Check if a user is logged in.
 * @return bool
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/**
 * Get the role of the currently logged-in user.
 * @return string|null
 */
function get_user_role()
{
    return $_SESSION['user_role'] ?? null;
}

/**
 * Require a user to be authenticated. Redirects to login if not.
 * Can also check for a specific role.
 * @param string|null $required_role
 */
function require_auth($required_role = null)
{
    if (!is_logged_in()) {
        header('Location: /login');
        exit();
    }

    if ($required_role && get_user_role() !== $required_role) {
        // User is logged in, but doesn't have the required role.
        // Show a "forbidden" error.
        http_response_code(403);
        load_view('errors/403');
        exit();
    }
}

/**
 * Send a simple email.
 * @param string $to
 * @param string $subject
 * @param string $message
 * @return bool
 */
function send_email($to, $subject, $message)
{
    $headers = 'From: no-reply@procurement.system' . "\r\n" .
        'Reply-To: no-reply@procurement.system' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // For development, we can just log the email instead of sending it.
    // On a real server, this would use mail()
    $log_message = "---- EMAIL SENT ----\nTO: $to\nSUBJECT: $subject\n\n$message\n--------------------\n";
    file_put_contents(__DIR__ . '/../../mail.log', $log_message, FILE_APPEND);

    return true; // Assume success for local dev
    // return mail($to, $subject, $message, $headers);
}

/**
 * Check if a supplier is logged in.
 * @return bool
 */
function is_supplier_logged_in()
{
    return isset($_SESSION['supplier_id']);
}

/**
 * Require a supplier to be authenticated. Redirects to login if not.
 */
function require_supplier_auth()
{
    if (!is_supplier_logged_in()) {
        header('Location: /supplier/login');
        exit();
    }
}
