<h2><?php echo htmlspecialchars($page_title); ?></h2>

<form action="<?php echo htmlspecialchars($form_action); ?>" method="post">
    <div>
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($buyer['full_name']); ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($buyer['email']); ?>" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" <?php if (empty($buyer['id'])) echo 'required'; ?>>
        <?php if (!empty($buyer['id'])): ?>
            <small>Leave blank to keep the current password.</small>
        <?php endif; ?>
    </div>
    <button type="submit">Save Buyer</button>
    <a href="/admin/buyers">Cancel</a>
</form>
