<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <h1><a href="/"><?php echo APP_NAME; ?></a></h1>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <?php if (is_logged_in()): ?>
                    <li><span>Welcome, <?php echo htmlspecialchars($_SESSION['user_full_name']); ?>!</span></li>
                    <li><a href="/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Main content will be loaded here -->
    </main>
</body>
</html>
