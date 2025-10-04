<?php
// Database configuration
$host = 'localhost'; // Database host
$username = 'root';  // Database username
$password = '';  // Database password
$dbname = 'ibtcrm'; // Database name

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start output buffering
    ob_start();

    // Fetch the list of tables
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        // Get the CREATE TABLE statement
        $createTableStmt = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
        echo $createTableStmt['Create Table'] . ";\n\n";

        // Get the table data
        $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $columns = array_keys($row);
            $values = array_values($row);

            // Prepare the INSERT INTO statement
            $insertStmt = "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" .
                implode(', ', array_map([$pdo, 'quote'], $values)) . ");\n";
            echo $insertStmt;
        }
        echo "\n\n";
    }

    // Capture the output
    $sqlContent = ob_get_clean();

    // Set headers to trigger a download
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="database_export.sql"');
    header('Content-Length: ' . strlen($sqlContent));

    // Output the SQL content
    echo $sqlContent;

    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
