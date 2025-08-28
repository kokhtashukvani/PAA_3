<h3>Notifications</h3>
<div class="notifications-list" style="border: 1px solid #ccc; padding: 10px; max-height: 300px; overflow-y: auto;">
    <?php if (empty($notifications)): ?>
        <p>You have no new notifications.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li style="<?php if (!$notification['is_read']) echo 'font-weight: bold;'; ?>">
                    <?php echo htmlspecialchars($notification['message']); ?>
                    <small>(<?php echo htmlspecialchars($notification['created_at']); ?>)</small>
                    <?php if (!$notification['is_read']): ?>
                        <a href="/notifications/read/<?php echo $notification['id']; ?>" style="margin-left: 10px;">Mark as read</a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
