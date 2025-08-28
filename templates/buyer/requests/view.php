<h2><?php echo htmlspecialchars($page_title); ?></h2>

<?php if (isset($_GET['awarded']) && $_GET['awarded'] === 'success'): ?>
    <p style="color: green;">Proposal successfully awarded! The winner and other suppliers have been notified.</p>
<?php endif; ?>

<h3>Request Details</h3>
<p><strong>Title:</strong> <?php echo htmlspecialchars($request['title']); ?></p>
<p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($request['status'])); ?></p>

<hr>

<h3>Received Proposals</h3>
<?php if (empty($proposals)): ?>
    <p>No proposals have been submitted for this request yet.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Supplier</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Delivery (Days)</th>
                <th>Payment Terms</th>
                <th>Quote Valid (Days)</th>
                <th>Invoice</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proposals as $proposal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($proposal['company_name']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($proposal['unit_price'], 2)); ?></td>
                    <td><strong>$<?php echo htmlspecialchars(number_format($proposal['total_price'], 2)); ?></strong></td>
                    <td><?php echo htmlspecialchars($proposal['delivery_time_days']); ?></td>
                    <td><?php echo htmlspecialchars($proposal['payment_terms']); ?></td>
                    <td><?php echo htmlspecialchars($proposal['validity_period_days']); ?></td>
                    <td>
                        <?php if ($proposal['proforma_invoice_path']): ?>
                            <a href="<?php echo htmlspecialchars($proposal['proforma_invoice_path']); ?>" target="_blank">View PDF</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($request['status'] === 'open'): ?>
                            <form action="/buyer/requests/<?php echo $request['id']; ?>/award/<?php echo $proposal['id']; ?>" method="post">
                                <button type="submit" onclick="return confirm('Are you sure you want to award this proposal? This action cannot be undone.');">Award</button>
                            </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars(ucfirst($proposal['status'])); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="/buyer/dashboard" style="margin-top: 20px; display: inline-block;">Back to Dashboard</a>
