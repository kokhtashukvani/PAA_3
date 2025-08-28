<h2><?php echo htmlspecialchars($page_title); ?></h2>

<form action="<?php echo htmlspecialchars($form_action); ?>" method="post">
    <div>
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
    </div>
    <button type="submit">Save Category</button>
    <a href="/admin/categories">Cancel</a>
</form>
