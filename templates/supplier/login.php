<h2>Supplier Login</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (isset($_GET['registered']) && $_GET['registered'] === 'success'): ?>
    <p style="color: green;">Registration successful! You will receive an email once your account is approved. You can log in after approval.</p>
<?php endif; ?>

<form action="/supplier/login" method="post">
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

<p>Not registered yet? <a href="/supplier/register">Register your company</a>.</p>
