<h2><?php echo htmlspecialchars($page_title); ?></h2>

<form action="<?php echo htmlspecialchars($form_action); ?>" method="post">
    <div>
        <label for="name">Brand Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($brand['name']); ?>" required>
    </div>
    <button type="submit">Save Brand</button>
    <a href="/admin/brands">Cancel</a>
</form>
