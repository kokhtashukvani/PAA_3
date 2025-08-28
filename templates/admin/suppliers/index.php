<h2><?php echo htmlspecialchars($page_title); ?></h2>

<a href="/admin/suppliers/new">Add New Supplier</a>
<a href="/admin/suppliers/pending" style="margin-left: 20px;">View Pending Approvals</a>


<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($suppliers)): ?>
            <tr>
                <td colspan="5">No suppliers found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?php echo htmlspecialchars($supplier['id']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['contact_email']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($supplier['status'])); ?></td>
                    <td>
                        <a href="/admin/suppliers/edit/<?php echo $supplier['id']; ?>">Edit</a>
                        <form action="/admin/suppliers/delete/<?php echo $supplier['id']; ?>" method="post" style="display:inline;">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this supplier? This action cannot be undone.');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
