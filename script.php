<?php
// Connect to the database.
$mysqli = new mysqli('localhost', 'admin', 'admin_pass', 'tutorials');

if($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();
}

// Set starting point and number of rows per page
$start = 0;
$rows_per_page = 4;

// Get total number of rows
$records = $mysqli->query("SELECT * FROM products");
$nr_of_rows = $records->num_rows;

// Calculate total number of pages
$pages = ceil($nr_of_rows / $rows_per_page);

// Update the starting point based on the current page
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}

// Fetch the paginated results
$result = $mysqli->query("SELECT * FROM products LIMIT $start, $rows_per_page");
?>
