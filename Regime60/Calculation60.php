<?php
require_once __DIR__ . '/../config/database.php';
$conn = forestory_db_connect();

$id = [];
$blockx = [];
$blocky = [];
$x = [];
$y = [];
$species = [];
$diameter = [];
$height = [];
$spgroup = [];
$diameterclass = [];
$treenum = [];
$volume = [];
$production = [];
$cut_angle = [];
$status = [];

$sql = "SELECT * FROM new_forest_60";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $id[] = $row["ID"];
        $blockx[] = $row["BlockX"];
        $blocky[] = $row["BlockY"];
        $x[] = $row["x"];
        $y[] = $row["y"];
        $species[] = $row["species"];
        $diameter[] = $row["diameter"];
        $height[] = $row["StemHeight"];
        $spgroup[] = $row["spgroup"];
        $diameterclass[] = $row["diameterclass"];

        //process treeNumber
        $treenum[] = "T" .
            str_pad($row["BlockX"], 2, "0", STR_PAD_LEFT) .
            str_pad($row["BlockY"], 2, "0", STR_PAD_LEFT) .
            str_pad($row["x"], 2, "0", STR_PAD_LEFT) .
            str_pad($row["y"], 2, "0", STR_PAD_LEFT);

        $diam = $row["diameter"];
        $stemH = $row["StemHeight"];
        $diamC = $row["diameterclass"];

        $volume[] = calculatevolume($diam, $stemH, (int) $row["spgroup"]);
        $status[] = loggingcondition($diamC, $diam);
        $cut_angle[] = cutangel($diam, $diamC);
        $production[] = (loggingcondition($diamC, $diam) == "Keep") ? 0 : 1;
    }
}

function calculatevolume($diam, $stemH, $spgroup)
{
    $Dia = (float) ($diam / 100);
    $Hie = (float) $stemH;

    if ($spgroup <= 4) {
        if ($Dia < 0.15) {
            $vol = 0.022 + (3.4 * pow($Dia, 2));
        } else {
            $vol = 0.015 + (2.137 * pow($Dia, 2)) + (0.513 * pow($Dia, 2) * $Hie);
        }
    } else {
        if ($Dia < 0.15) {
            $vol = 0.03 + (2.8 * pow($Dia, 2));
        } else {
            $vol = -0.0023 + (2.942 * pow($Dia, 2)) + (0.262 * pow($Dia, 2) * $Hie);
        }
    }

    return round($vol ?? 0, 2);

}
function loggingcondition($diamC, $diam)
{
    if (in_array($diamC, [1, 2, 3, 5]) && $diam > 60) {
        return "Cut";
    } else {
        return "Keep";
    }
}
function cutangel($diam, $diamC)
{
    if (in_array($diamC, [1, 2, 3, 5]) && $diam > 60) {
        return rand(0, 360);
    }
    return 0;
}

// Batch Update
$batch_size = 100; // Adjust batch size for performance
$batch_updates = [];
$counter = 0;

for ($i = 0; $i < count($id); $i++) {
    $batch_updates[] = "UPDATE new_forest_60
        SET 
            Volume = {$volume[$i]}, 
            TreeNumber = '{$treenum[$i]}', 
            Status = '{$status[$i]}', 
            Production = {$production[$i]}, 
            Cut_Angle = {$cut_angle[$i]}
        WHERE ID = {$id[$i]}";

    $counter++;

    // Execute the batch when the size reaches the limit
    if ($counter % $batch_size == 0 || $i == count($id) - 1) {
        $batch_query = implode("; ", $batch_updates) . ";";
        if ($conn->multi_query($batch_query)) {
            do {
                // Clear result set for the current query batch
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "Error executing batch: " . $conn->error . "<br>";
        }
        $batch_updates = []; // Clear the batch
    }
}

echo "Total Data Processed: " . count($id) . "<br>"; // Changed $SpCode to $id

$conn->close();

// Redirect to Victim60.php after completion
header('Location: Victim60.php');
exit();
?>