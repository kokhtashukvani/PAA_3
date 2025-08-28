<h2><?php echo htmlspecialchars($page_title ?? 'Admin Dashboard'); ?></h2>

<p>Welcome to the admin area. From here you can manage the application.</p>

<h3>Key Metrics</h3>
<ul>
    <li>Total Buyers: <strong>0</strong></li>
    <li>Total Suppliers (Approved): <strong>0</strong></li>
    <li>Pending Supplier Approvals: <strong>0</strong></li>
    <li>Open Purchase Requests: <strong>0</strong></li>
</ul>

<h3>Admin Functions</h3>
<ul>
    <li><a href="/admin/categories">Manage Categories</a></li>
    <li><a href="/admin/brands">Manage Brands</a></li>
    <li><a href="/admin/users">Manage Buyers</a></li>
    <li><a href="/admin/suppliers/approve">Approve Suppliers</a></li>
    <li><a href="/admin/settings">Global Settings</a></li>
</ul>
