<?php
$tableName = 'new_forest'; // Set default table

require_once __DIR__ . '/../config/database.php';
$conn = forestory_db_connect();

$count_query = "SELECT TreeNumber, diameter, spgroup, StemHeight FROM $tableName WHERE Status IN ('Keep', 'V1', 'V2')";
$result = mysqli_query($conn, $count_query);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

$diameter = [];
$production3045 = [];
$production3050 = [];
$production3055 = [];
$production3060 = [];
$TreeNum = [];
$vol30 = [];

while ($row = mysqli_fetch_assoc($result)) {
    $TreeNum[] = $row['TreeNumber'];
    $D = $row['diameter'];
    $G = $row['spgroup'];
    $H = $row['StemHeight'];

    $diameter[] = growth($D);
    $newDia = growth($D);

    // Calculate production for different log sizes
    $production3045[] = LogCond($G, $newDia, $log = 45);
    $production3050[] = LogCond($G, $newDia, $log = 50);
    $production3055[] = LogCond($G, $newDia, $log = 55);
    $production3060[] = LogCond($G, $newDia, $log = 60);

    // Volume calculation
    $vol30[] = calculateVolume30($newDia, $G, $H);
}

function growth($D) {
    for ($i = 1; $i <= 30; $i++) {
        if ($D > 5 && $D <= 15) {
            $D = $D + 0.4;
        } else if ($D > 15 && $D <= 30) {
            $D = $D + 0.6;
        } else if ($D > 30 && $D <= 45) {
            $D = $D + 0.5;
        } else if ($D > 45 && $D <= 60) {
            $D = $D + 0.5;
        } else if ($D > 60) {
            $D = $D + 0.7;
        }
    }

    return $D;
}

function LogCond($G, $newDia, $log) {
    if (in_array($G, [1, 2, 3, 5]) && $newDia > $log) {
        return 1;
    }
    return 0;
}

function calculateVolume30($newDia, $G, $H) {
    $Dia = (float) ($newDia / 100);
    $Hie = (float) $H;

    if ($G <= 4) {
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

$batch_size = 100;
$batch_updates = [];
$counter = 0;

for ($i = 0; $i < count($diameter); $i++) {
    $batch_updates[] = "UPDATE $tableName
        SET
            GrowthD30 = {$diameter[$i]},
            production3045 = {$production3045[$i]},
            production3050 = {$production3050[$i]},
            production3055 = {$production3055[$i]},
            production3060 = {$production3060[$i]},
            Volume30 = {$vol30[$i]}
        WHERE TreeNumber = '{$TreeNum[$i]}'";

    $counter++;

    if ($counter % $batch_size == 0 || $i == count($diameter) - 1) {
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

mysqli_close($conn);
?>
<script>
    alert("Done Generating Forest (Regime 45)");
    window.location.href = "../SelectRegime.php";
</script>
