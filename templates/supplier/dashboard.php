<?php include __DIR__ . '/../partials/_notifications.php'; ?>

<h2 style="margin-top: 30px;"><?php echo htmlspecialchars($page_title); ?></h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['supplier_company_name']); ?>!</p>

<a href="/supplier/logout">Logout</a>

<h3 style="margin-top: 30px;">New Purchase Requests</h3>
<table>
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date Received</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">You have no new purchase requests.</td>
        </tr>
        <!-- New request rows will be looped here later -->
    </tbody>
</table>

<h3 style="margin-top: 30px;">Your Submitted Quotes</h3>
<table>
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Title</th>
            <th>Your Quote</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">You have not submitted any quotes yet.</td>
        </tr>
        <!-- Submitted quote rows will be looped here later -->
    </tbody>
</table>
