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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination Example</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let links = document.querySelectorAll('.page-numbers > a');
            let bodyId = parseInt(document.body.id) - 1;
            if (links[bodyId]) {
                links[bodyId].classList.add("active");
            }
        });
    </script>
</head>
<body id="<?php echo isset($_GET['page-nr']) ? $_GET['page-nr'] : 1; ?>">

    <div class="content">
        <?php while($row = $result->fetch_assoc()): ?>
            <p><?php echo $row["id"] ?> - <?php echo $row["product_name"] ?></p>
        <?php endwhile; ?>
    </div>

    <div class="page-info">
        Showing <?php echo isset($_GET['page-nr']) ? $_GET['page-nr'] : 1; ?> of <?php echo $pages; ?> pages
    </div>

    <div class="pagination">
        <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1): ?>
            <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
        <?php else: ?>
            <a class="disabled">Previous</a>
        <?php endif; ?>

        <div class="page-numbers">
            <?php for($counter = 1; $counter <= $pages; $counter++): ?>
                <a href="?page-nr=<?php echo $counter ?>" class="<?php echo isset($_GET['page-nr']) && $_GET['page-nr'] == $counter ? 'active' : ''; ?>">
                    <?php echo $counter; ?>
                </a>
            <?php endfor; ?>
        </div>

        <?php if(!isset($_GET['page-nr']) || $_GET['page-nr'] < $pages): ?>
            <a href="?page-nr=<?php echo (isset($_GET['page-nr']) ? $_GET['page-nr'] + 1 : 2) ?>">Next</a>
        <?php else: ?>
            <a class="disabled">Next</a>
        <?php endif; ?>

        <a href="?page-nr=<?php echo $pages ?>">Last</a>
    </div>
    
</body>
</html>
