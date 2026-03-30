<?php
require_once __DIR__ . '/config/database.php';
$conn = forestory_db_connect();

/**
 * Run a query; on InnoDB deadlock (1213) wait briefly and retry.
 */
function mysqli_exec_retry(mysqli $conn, string $sql, int $maxAttempts = 12): bool
{
    $attempt = 0;
    while ($attempt < $maxAttempts) {
        try {
            if ($conn->query($sql)) {
                return true;
            }
            if ($conn->errno == 1213) {
                $attempt++;
                usleep(40000 + random_int(0, 60000));
                continue;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            $code = (int) $e->getCode();
            if ($code === 1213 && $attempt < $maxAttempts - 1) {
                $attempt++;
                usleep(40000 + random_int(0, 60000));
                continue;
            }
            throw $e;
        }
    }
    return false;
}

// Variables
$NoBlockX = 10;
$NoBlockY = 10;
$NoGroupSpecies = 7;
$NumDclass = 5;
$insertBatchSize = 200;

$TreePerha = [
    [15, 12, 4, 2, 2],
    [21, 18, 6, 4, 4],
    [21, 18, 6, 4, 4],
    [30, 27, 9, 5, 3],
    [30, 27, 9, 4, 4],
    [39, 36, 12, 7, 4],
    [44, 42, 14, 9, 4],
];

$ListSpecies = [];
$sql = 'SELECT No, species FROM speciesnames';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ListSpecies[$row['No']] = $row['species'];
    }
} else {
    die('No species found in the database.');
}

$maxSpeciesKey = max(array_keys($ListSpecies));

$batchValues = [];
$flushBatch = function () use ($conn, &$batchValues) {
    if ($batchValues === []) {
        return;
    }
    $sql = 'INSERT INTO new_forest (BlockX, BlockY, x, y, species, diameter, StemHeight, spgroup, diameterclass) VALUES '
        . implode(',', $batchValues);
    if (!mysqli_exec_retry($conn, $sql)) {
        die('Insert batch failed: ' . $conn->error);
    }
    $batchValues = [];
};

for ($IX = 1; $IX <= $NoBlockX; $IX++) {
    for ($JY = 1; $JY <= $NoBlockY; $JY++) {
        $blockx = $IX;
        $blocky = $JY;

        for ($I = 1; $I <= $NoGroupSpecies; $I++) {
            for ($J = 1; $J <= $NumDclass; $J++) {
                $NumTree = $TreePerha[$I - 1][$J - 1];

                for ($K = 1; $K <= $NumTree; $K++) {
                    if ($I == 1) {
                        $SequenceSp = rand(1, 1);
                    } elseif ($I == 2) {
                        $SequenceSp = rand(2, 6);
                    } elseif ($I == 3) {
                        $SequenceSp = rand(7, 19);
                    } elseif ($I == 4) {
                        $SequenceSp = rand(20, 60);
                    } elseif ($I == 5) {
                        $SequenceSp = rand(61, 100);
                    } elseif ($I == 6) {
                        $SequenceSp = rand(101, 150);
                    } else {
                        $SequenceSp = rand(151, $maxSpeciesKey);
                    }

                    if (!isset($ListSpecies[$SequenceSp])) {
                        echo "Error: Invalid Species Number: $SequenceSp - Not found in \$ListSpecies array.\n";
                        continue;
                    }

                    $species = $ListSpecies[$SequenceSp];

                    if ($J == 1) {
                        $diameter = rand(500, 1500) / 100;
                    } elseif ($J == 2) {
                        $diameter = rand(1500, 3000) / 100;
                    } elseif ($J == 3) {
                        $diameter = rand(3000, 4500) / 100;
                    } elseif ($J == 4) {
                        $diameter = rand(4500, 6000) / 100;
                    } else {
                        $diameter = rand(6000, 20000) / 100;
                    }

                    if ($J == 1) {
                        $height = rand(250, 550) / 100;
                    } elseif ($J == 2) {
                        $height = rand(550, 1000) / 100;
                    } elseif ($J == 3) {
                        $height = rand(1000, 1500) / 100;
                    } elseif ($J == 4) {
                        $height = rand(1500, 4000) / 100;
                    } else {
                        $height = rand(1500, 4000) / 100;
                    }

                    $locationx = rand(1, 100);
                    $locationy = rand(1, 100);
                    $x = ($blockx - 1) * 100 + $locationx;
                    $y = ($blocky - 1) * 100 + $locationy;

                    $spgroup = $I;
                    $diameterclass = $J;

                    $spEsc = mysqli_real_escape_string($conn, $species);
                    $batchValues[] = sprintf(
                        '(%d,%d,%d,%d,\'%s\',%.4f,%.4f,%d,%d)',
                        $blockx,
                        $blocky,
                        $x,
                        $y,
                        $spEsc,
                        $diameter,
                        $height,
                        $spgroup,
                        $diameterclass
                    );

                    if (count($batchValues) >= $insertBatchSize) {
                        $flushBatch();
                    }
                }
            }
        }
    }
}

$flushBatch();

$syncCols = 'BlockX, BlockY, x, y, species, diameter, StemHeight, spgroup, diameterclass';
foreach (['new_forest_50', 'new_forest_55', 'new_forest_60'] as $tbl) {
    if (!mysqli_exec_retry($conn, "DELETE FROM `$tbl`")) {
        error_log('forestory Gen_Forest: DELETE from ' . $tbl . ' failed: ' . $conn->error);
        continue;
    }
    $syncSql = "INSERT INTO `$tbl` ($syncCols) SELECT $syncCols FROM new_forest";
    if (!mysqli_exec_retry($conn, $syncSql)) {
        error_log('forestory Gen_Forest: copy to ' . $tbl . ' failed: ' . $conn->error);
    }
}

$conn->close();

header('Location: SelectRegime.php');
exit();
