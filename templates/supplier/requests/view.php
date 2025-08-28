<h2><?php echo htmlspecialchars($page_title); ?></h2>

<h3>Purchase Request Details</h3>
<p><strong>Title:</strong> <?php echo htmlspecialchars($request['title']); ?></p>
<p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($request['description'])); ?></p>
<p><strong>Category:</strong> <?php echo htmlspecialchars($request['category_name']); ?></p>
<p><strong>Quantity:</strong> <?php echo htmlspecialchars($request['quantity']); ?></p>
<p><strong>Required Delivery Date:</strong> <?php echo htmlspecialchars($request['delivery_date'] ?? 'Not specified'); ?></p>

<hr>

<h3>Submit Your Proposal</h3>
<form action="/supplier/requests/<?php echo $request['id']; ?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="unit_price">Unit Price:</label>
        <input type="number" step="0.01" id="unit_price" name="unit_price" required>
    </div>
    <div>
        <label for="total_price">Total Price:</label>
        <input type="number" step="0.01" id="total_price" name="total_price" required>
    </div>
    <div>
        <label for="delivery_time_days">Estimated Delivery (Days):</label>
        <input type="number" id="delivery_time_days" name="delivery_time_days" required>
    </div>
    <div>
        <label for="payment_terms">Payment Terms:</label>
        <input type="text" id="payment_terms" name="payment_terms">
    </div>
    <div>
        <label for="validity_period_days">Quote Validity (Days):</label>
        <input type="number" id="validity_period_days" name="validity_period_days" required>
    </div>
    <div>
        <label for="notes">Additional Notes:</label>
        <textarea id="notes" name="notes" rows="4"></textarea>
    </div>
    <div>
        <label for="proforma_invoice">Proforma Invoice (PDF, optional):</label>
        <input type="file" id="proforma_invoice" name="proforma_invoice" accept=".pdf">
    </div>
    <button type="submit">Submit Proposal</button>
</form>
