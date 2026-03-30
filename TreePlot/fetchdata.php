<?php
require_once __DIR__ . '/../config/database.php';
$conn = forestory_db_connect();

// Get BlockX and BlockY from query parameters
$blockX = isset($_GET['BlockX']) ? intval($_GET['BlockX']) : 1; 
$blockY = isset($_GET['BlockY']) ? intval($_GET['BlockY']) : 1; 
$spgroup = isset($_GET['SpGroup']) ? intval($_GET['SpGroup']) : 8;

if ($spgroup == 8) {
    $count_query = "SELECT * FROM new_forest WHERE BlockX = $blockX AND BlockY = $blockY";
} else {
    $count_query = "SELECT * FROM new_forest WHERE BlockX = $blockX AND BlockY = $blockY AND spgroup = $spgroup";
    
}

$result = mysqli_query($conn, $count_query);

    $treeData = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $treeData[] = $row; 
    }

    mysqli_close($conn);


    header('Content-Type: application/json');
    echo json_encode($treeData);

?>