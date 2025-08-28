<h2>Login</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (isset($_GET['registered']) && $_GET['registered'] === 'success'): ?>
    <p style="color: green;">Admin registration successful. Please log in.</p>
<?php endif; ?>

<form action="/login" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>
