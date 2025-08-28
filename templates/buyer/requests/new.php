<h2><?php echo htmlspecialchars($page_title); ?></h2>

<form action="/buyer/requests/new" method="post">
    <div>
        <label for="title">Item / Service Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Technical Specifications / Description:</label>
        <textarea id="description" name="description" rows="5"></textarea>
    </div>
    <div>
        <label for="category_id">Product Category:</label>
        <select id="category_id" name="category_id" required>
            <option value="">-- Select a Category --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
    </div>
    <div>
        <label for="delivery_date">Required Delivery Date:</label>
        <input type="date" id="delivery_date" name="delivery_date">
    </div>

    <hr>

    <div>
        <h4>Preferred Brands (optional)</h4>
        <?php foreach ($brands as $brand): ?>
            <label>
                <input type="checkbox" name="brand_ids[]" value="<?php echo $brand['id']; ?>">
                <?php echo htmlspecialchars($brand['name']); ?>
            </label><br>
        <?php endforeach; ?>
    </div>

    <hr>

    <div>
        <label>
            <input type="checkbox" name="is_private" value="1">
            <strong>Make this request private:</strong> Only I will see the winning bid details. Losing suppliers will not be notified of the outcome.
        </label>
        <p><small>If unchecked, the system will follow the global transparency setting.</small></p>
    </div>

    <button type="submit">Submit Purchase Request</button>
</form>
