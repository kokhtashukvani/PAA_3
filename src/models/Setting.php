<?php

class Setting
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get all settings from the database and return as an associative array.
     * @return array
     */
    public function getSettings()
    {
        $settings = [];
        $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM settings");
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    /**
     * Update a setting in the database. Creates it if it doesn't exist.
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function updateSetting($key, $value)
    {
        // Use INSERT ... ON DUPLICATE KEY UPDATE to handle both cases
        $sql = "INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)
                ON DUPLICATE KEY UPDATE setting_value = :value";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['key' => $key, 'value' => $value]);
    }
}
