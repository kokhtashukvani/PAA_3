<?php include __DIR__ . '/../partials/_notifications.php'; ?>

<h2 style="margin-top: 30px;"><?php echo htmlspecialchars($page_title); ?></h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['user_full_name']); ?>!</p>

<a href="/buyer/requests/new">Create New Purchase Request</a>

<h3 style="margin-top: 30px;">Your Purchase Requests</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">You have not created any purchase requests yet.</td>
        </tr>
        <!-- Request rows will be looped here later -->
    </tbody>
</table>
