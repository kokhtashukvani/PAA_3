<h2><?php echo htmlspecialchars($page_title); ?></h2>

<a href="/admin/brands/new">Add New Brand</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($brands)): ?>
            <tr>
                <td colspan="3">No brands found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($brands as $brand): ?>
                <tr>
                    <td><?php echo htmlspecialchars($brand['id']); ?></td>
                    <td><?php echo htmlspecialchars($brand['name']); ?></td>
                    <td>
                        <a href="/admin/brands/edit/<?php echo $brand['id']; ?>">Edit</a>
                        <form action="/admin/brands/delete/<?php echo $brand['id']; ?>" method="post" style="display:inline;">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
