<h2>Admin Registration</h2>
<p>Create the first administrator account for the system. This form will be disabled after the first admin is created.</p>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="/register" method="post">
    <div>
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
    </div>
    <button type="submit">Register Admin</button>
</form>
