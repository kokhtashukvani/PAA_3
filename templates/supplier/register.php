<h2><?php echo htmlspecialchars($page_title); ?></h2>
<p>Register your company to receive purchase requests from buyers.</p>

<form action="/supplier/register" method="post">
    <h3>Company Details</h3>
    <div>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required>
    </div>
    <div>
        <label for="contact_email">Contact Email:</label>
        <input type="email" id="contact_email" name="contact_email" required>
    </div>
    <div>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <hr>

    <h3>Services Provided</h3>
    <div>
        <h4>Product Categories You Supply</h4>
        <?php foreach ($categories as $category): ?>
            <label>
                <input type="checkbox" name="category_ids[]" value="<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
            </label><br>
        <?php endforeach; ?>
    </div>

    <div style="margin-top: 20px;">
        <h4>Brands You Represent</h4>
        <?php foreach ($brands as $brand): ?>
            <label>
                <input type="checkbox" name="brand_ids[]" value="<?php echo $brand['id']; ?>">
                <?php echo htmlspecialchars($brand['name']); ?>
            </label><br>
        <?php endforeach; ?>
    </div>

    <hr>

    <button type="submit">Register My Company</button>
</form>
