<?php
require_once __DIR__ . '/../config/database.php';
$conn = forestory_db_connect();


$spgroup = isset($_GET['SpGroup']) ? intval($_GET['SpGroup']) : 8;

if ($spgroup == 8) {
    $count_query = "SELECT * FROM new_forest_60";
} else {
    $count_query = "SELECT * FROM new_forest_60 WHERE spgroup = $spgroup";
    
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