<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $db = get_db_connection();
        $this->userModel = new User($db);
    }

    /**
     * Display the registration page or handle registration form submission.
     */
    public function register()
    {
        // If an admin already exists, disable registration completely.
        if ($this->userModel->adminExists() && $_SERVER['REQUEST_METHOD'] === 'GET') {
            load_view('auth/register_closed');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Double-check before processing the POST request
            if ($this->userModel->adminExists()) {
                // Should not happen if the form is disabled, but as a safeguard.
                load_view('auth/register_closed');
                return;
            }

            $fullName = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];

            $error = '';
            if (empty($fullName) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif ($password !== $passwordConfirm) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'An account with this email already exists.';
            }

            if ($error) {
                load_view('auth/register', ['error' => $error]);
                return;
            }

            // Create the admin user
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->createUser($fullName, $email, $passwordHash, 'Admin');

            // Redirect to login page with a success message
            header('Location: /login?registered=success');
            exit();
        }

        // Default: Show the registration form
        load_view('auth/register');
    }

    /**
     * Display the login page or handle login form submission.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $error = '';
            if (empty($email) || empty($password)) {
                $error = 'Email and password are required.';
            } else {
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Password is correct, start session
                    session_regenerate_id(true); // Prevent session fixation
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_full_name'] = $user['full_name'];

                    // Redirect based on role
                    if ($user['role'] === 'Admin') {
                        header('Location: /admin/dashboard');
                    } else {
                        header('Location: /buyer/dashboard');
                    }
                    exit();
                } else {
                    $error = 'Invalid email or password.';
                }
            }
            // If we are here, login failed. Show the form with an error.
            load_view('auth/login', ['error' => $error]);
            return;
        }

        // Default: Show the login form
        load_view('auth/login');
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        // Logic for logout will go here.
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
