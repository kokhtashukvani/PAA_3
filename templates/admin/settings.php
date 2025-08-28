<h2><?php echo htmlspecialchars($page_title); ?></h2>

<?php if ($success_message): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
<?php endif; ?>

<form action="/admin/settings" method="post">
    <h3>Transparency Settings</h3>
    <div>
        <label for="default_transparency">Default Bid Transparency:</label>
        <select id="default_transparency" name="default_transparency">
            <option value="public" <?php if (isset($settings['default_transparency']) && $settings['default_transparency'] === 'public') echo 'selected'; ?>>
                Public (Losing suppliers can see winning bid details)
            </option>
            <option value="private" <?php if (isset($settings['default_transparency']) && $settings['default_transparency'] === 'private') echo 'selected'; ?>>
                Private (Losing suppliers only see a "not selected" notice)
            </option>
        </select>
        <p><small>This is the default setting. Buyers can override this on a per-request basis.</small></p>
    </div>

    <hr>

    <h3>Other Settings</h3>
    <p>More settings can be added here in the future.</p>

    <button type="submit">Save Settings</button>
</form>
