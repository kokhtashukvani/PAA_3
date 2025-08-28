<h2><?php echo htmlspecialchars($page_title); ?></h2>

<p>The following suppliers have registered and are awaiting approval.</p>

<table>
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Contact Email</th>
            <th>Phone Number</th>
            <th>Registered At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($suppliers)): ?>
            <tr>
                <td colspan="5">No pending supplier approvals.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?php echo htmlspecialchars($supplier['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['contact_email']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['created_at']); ?></td>
                    <td>
                        <form action="/admin/suppliers/approve/<?php echo $supplier['id']; ?>" method="post" style="display:inline;">
                            <button type="submit">Approve</button>
                        </form>
                        <form action="/admin/suppliers/reject/<?php echo $supplier['id']; ?>" method="post" style="display:inline;">
                            <button type="submit">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
