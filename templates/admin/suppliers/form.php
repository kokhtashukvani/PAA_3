<h2><?php echo htmlspecialchars($page_title); ?></h2>

<form action="<?php echo htmlspecialchars($form_action); ?>" method="post">
    <div>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($supplier['company_name']); ?>" required>
    </div>
    <div>
        <label for="contact_email">Contact Email:</label>
        <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($supplier['contact_email']); ?>" required>
    </div>
    <div>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($supplier['phone_number']); ?>">
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="pending" <?php if ($supplier['status'] === 'pending') echo 'selected'; ?>>Pending</option>
            <option value="approved" <?php if ($supplier['status'] === 'approved') echo 'selected'; ?>>Approved</option>
            <option value="rejected" <?php if ($supplier['status'] === 'rejected') echo 'selected'; ?>>Rejected</option>
        </select>
    </div>

    <?php if (strpos($form_action, 'new') !== false): // Only show password for new suppliers ?>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <small>A password is required for new suppliers.</small>
    </div>
    <?php endif; ?>

    <button type="submit">Save Supplier</button>
    <a href="/admin/suppliers">Cancel</a>
</form>
