<h2><?php echo htmlspecialchars($page_title); ?></h2>

<a href="/admin/buyers/new">Add New Buyer</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($buyers)): ?>
            <tr>
                <td colspan="5">No buyers found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($buyers as $buyer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($buyer['id']); ?></td>
                    <td><?php echo htmlspecialchars($buyer['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($buyer['email']); ?></td>
                    <td><?php echo htmlspecialchars($buyer['created_at']); ?></td>
                    <td>
                        <a href="/admin/buyers/edit/<?php echo $buyer['id']; ?>">Edit</a>
                        <form action="/admin/buyers/delete/<?php echo $buyer['id']; ?>" method="post" style="display:inline;">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this buyer?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
