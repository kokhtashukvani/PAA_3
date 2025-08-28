<h2><?php echo htmlspecialchars($page_title); ?></h2>

<a href="/admin/categories/new">Add New Category</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($categories)): ?>
            <tr>
                <td colspan="3">No categories found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <a href="/admin/categories/edit/<?php echo $category['id']; ?>">Edit</a>
                        <!-- Delete should be a POST request, so we'll use a form -->
                        <form action="/admin/categories/delete/<?php echo $category['id']; ?>" method="post" style="display:inline;">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
