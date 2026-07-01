<?php
/**
 * Bondhon BD Matrimonial - Database Connection Config
 * Specially configured for Award Space Hosting.
 * 
 * Award Space Database Info:
 * 1. Log in to your Award Space Control Panel.
 * 2. Navigate to "Database Manager".
 * 3. Copy the "Database Host" (e.g. fdb1030.awardspace.net or localhost).
 * 4. Fill in the Database Name, Username, and Password below.
 */

define('DB_HOST', 'fdb29.awardspace.net'); // Change if Award Space specifies a server (e.g., fdb1030.awardspace.net)
define('DB_NAME', '4771994_name');  // Your Award Space Database Name (usually prefixed, e.g. 1234567_bondhon_db)
define('DB_USER', '4771994_name');       // Your Award Space Database Username
define('DB_PASS', '@Zo[q[5w5.@{*Xy0');           // Your Award Space Database Password

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // If we're testing or hosting is not fully active, show a helpful, polished warning
    die("<div style='font-family: sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #fca5a5; background-color: #fef2f2; border-radius: 8px; color: #991b1b;'>
        <h3 style='margin-top:0;'>Database Connection Failed</h3>
        <p>Could not connect to the database. Please verify your database settings in <strong>db.php</strong>.</p>
        <p style='font-size:13px; color:#7f1d1d;'><strong>Error details:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
        <hr style='border:none; border-top:1px solid #fee2e2; margin:15px 0;'>
        <span style='font-size:12px; color:#b91c1c;'>Tip: On Award Space, check the 'Database Manager' to get the exact host, database name, and username.</span>
    </div>");
}

// Start Session globally
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
