<?php
$tableName = 'new_forest';
$damagetree = 'damagetree';

require_once __DIR__ . '/../config/database.php';
$conn = forestory_db_connect();

function victim_mark_status(mysqli $conn, $tableName, $treeNumber, $status) {
    $t = mysqli_real_escape_string($conn, $treeNumber);
    $s = mysqli_real_escape_string($conn, $status);
    mysqli_query($conn, "UPDATE `$tableName` SET Status = '$s' WHERE TreeNumber = '$t' AND Status != 'Cut'");
}

$sql = "SELECT TreeNumber,Cut_Angle, x, y, BlockX, BlockY, StemHeight FROM $tableName WHERE Status = 'Cut'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $cut_tree_coor = $row['TreeNumber'];
    $x0 = $row['x'];
    $y0 = $row['y'];
    $blockX0 = $row['BlockX'];
    $blockY0 = $row['BlockY'];
    $cutAngle = $row['Cut_Angle'];
    $stemHeight = $row['StemHeight'];

    $buffer = 10;
    $count_query = "";

    if ($cutAngle >= 0 && $cutAngle < 90) {
        // Quadrant I: 0 - 90 degrees
        $x_upper = $x0 + $stemHeight + $buffer;
        $y_upper = $y0 + $stemHeight + $buffer;

        $count_query = "SELECT BlockX, BlockY, x, y, TreeNumber FROM $tableName WHERE Status != 'Cut' AND BlockX = $blockX0 AND BlockY = $blockY0 AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";


    } elseif ($cutAngle >= 90 && $cutAngle < 180) {
        // Quadrant II: 90 - 180 degrees
        $x_upper = $x0 + $stemHeight + $buffer;
        $y_upper = $y0 - $stemHeight - $buffer;
        $count_query2 = "SELECT BlockX, BlockY, x, y, TreeNumber FROM $tableName WHERE Status != 'Cut' AND BlockX = $blockX0 AND BlockY = $blockY0 AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";

    } elseif ($cutAngle >= 180 && $cutAngle < 270) {
        // Quadrant III: 180 - 270 degrees
        $x_upper = $x0 - $stemHeight - $buffer;
        $y_upper = $y0 - $stemHeight - $buffer;
        $count_query3 = "SELECT BlockX, BlockY, x, y, TreeNumber FROM $tableName WHERE Status != 'Cut' AND BlockX = $blockX0 AND BlockY = $blockY0 AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";

    } elseif ($cutAngle >= 270 && $cutAngle < 360) {
        // Quadrant IV: 270 - 360 degrees
        $x_upper = $x0 - $stemHeight - $buffer;
        $y_upper = $y0 + $stemHeight + $buffer;
        $count_query4 = "SELECT BlockX, BlockY, x, y, TreeNumber FROM $tableName WHERE Status != 'Cut' AND BlockX = $blockX0 AND BlockY = $blockY0 AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";

    }

    if (!empty($count_query)) {
        $result1 = mysqli_query($conn, $count_query);

        if (!$result1) {
            die('Error executing query: ' . mysqli_error($conn));
        }

        while ($row1 = mysqli_fetch_assoc($result1)) {
            $rad = deg2rad($cutAngle);

            $UnknownTreeX = $row1['x'];
            $UnknownTreeY = $row1['y'];

            $y1 = ($UnknownTreeX / tan($rad + 1));
            $y2 = ($UnknownTreeX / tan($rad - 1));

            $x1Crown = $x0 + ($stemHeight + 5) * sin($rad);
            $y1Crown = $y0 + ($stemHeight + 5) * cos($rad);

            $distance = sqrt(pow(($x1Crown - $UnknownTreeX), 2) + pow(($y1Crown - $UnknownTreeY), 2));

            if (($UnknownTreeY > $y1 && $UnknownTreeX < $y2)) {
                $blockVX = $row1['BlockX'];
                $blockVY = $row1['BlockY'];
                $victimX = $row1['x'];
                $victimY = $row1['y'];
                $victimCoor = $row1['TreeNumber'];

                $categoryDamage = "V1";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result2 = mysqli_query($conn, $insert_query);


                if (!$result2) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V1');
            }

            if ($distance <= 5) {
                $blockVX = $row1['BlockX'];
                $blockVY = $row1['BlockY'];
                $victimX = $row1['x'];
                $victimY = $row1['y'];
                $victimCoor = $row1['TreeNumber'];

                $categoryDamage = "V2";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result3 = mysqli_query($conn, $insert_query);


                if (!$result3) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V2');
            }
        }
    } else if (!empty($count_query2)) {
        $result4 = mysqli_query($conn, $count_query2);

        if (!$result4) {
            die('Error executing query: ' . mysqli_error($conn));
        }

        while ($row2 = mysqli_fetch_assoc($result4)) {

            $cutAngle = 180 - $cutAngle;

            $rad = deg2rad($cutAngle);

            $UnknownTreeX = $row2['x'];
            $UnknownTreeY = $row2['y'];

            $y1 = (($y0 - $UnknownTreeX) / tan($rad + 1));
            $y2 = (($y0 - $UnknownTreeX) / tan($rad - 1));

            $x1Crown = $x0 + ($stemHeight + 5) * sin($rad);
            $y1Crown = $y0 - ($stemHeight + 5) * cos($rad);

            $distance = sqrt(pow(($x1Crown - $UnknownTreeX), 2) + pow(($y1Crown - $UnknownTreeY), 2));

            if (($UnknownTreeY > $y1 && $UnknownTreeX < $y2)) {
                $blockVX = $row2['BlockX'];
                $blockVY = $row2['BlockY'];
                $victimX = $row2['x'];
                $victimY = $row2['y'];
                $victimCoor = $row2['TreeNumber'];

                $categoryDamage = "V1";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result5 = mysqli_query($conn, $insert_query);


                if (!$result5) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V1');
            }

            if ($distance <= 5) {
                $blockVX = $row2['BlockX'];
                $blockVY = $row2['BlockY'];
                $victimX = $row2['x'];
                $victimY = $row2['y'];
                $victimCoor = $row2['TreeNumber'];

                $categoryDamage = "V2";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result6 = mysqli_query($conn, $insert_query);

                if (!$result6) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V2');
            }
        }

    } else if (!empty($count_query3)) {
        $result7 = mysqli_query($conn, $count_query3);

        if (!$result7) {
            die('Error executing query: ' . mysqli_error($conn));
        }

        while ($row3 = mysqli_fetch_assoc($result7)) {

            $cutAngle = 180 + $cutAngle;

            $rad = deg2rad($cutAngle);

            $UnknownTreeX = $row3['x'];
            $UnknownTreeY = $row3['y'];

            $y1 = (($y0 - $UnknownTreeX) / tan($rad + 1));
            $y2 = (($y0 - $UnknownTreeX) / tan($rad - 1));

            $x1Crown = $x0 - ($stemHeight + 5) * sin($rad);
            $y1Crown = $y0 - ($stemHeight + 5) * cos($rad);

            $distance = sqrt(pow(($x1Crown - $UnknownTreeX), 2) + pow(($y1Crown - $UnknownTreeY), 2));

            if (($UnknownTreeY > $y1 && $UnknownTreeX < $y2)) {
                $blockVX = $row3['BlockX'];
                $blockVY = $row3['BlockY'];
                $victimX = $row3['x'];
                $victimY = $row3['y'];
                $victimCoor = $row3['TreeNumber'];

                $categoryDamage = "V1";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result8 = mysqli_query($conn, $insert_query);

                if (!$result8) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V1');
            }

            if ($distance <= 5) {
                $blockVX = $row3['BlockX'];
                $blockVY = $row3['BlockY'];
                $victimX = $row3['x'];
                $victimY = $row3['y'];
                $victimCoor = $row3['TreeNumber'];

                $categoryDamage = "V2";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result9 = mysqli_query($conn, $insert_query);

                if (!$result9) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V2');
            }
        }

    } else if (!empty($count_query4)) {
        $result10 = mysqli_query($conn, $count_query4);

        if (!$result10) {
            die('Error executing query: ' . mysqli_error($conn));
        }

        while ($row4 = mysqli_fetch_assoc($result10)) {

            $cutAngle = 360 - $cutAngle;

            $rad = deg2rad($cutAngle);

            $UnknownTreeX = $row4['x'];
            $UnknownTreeY = $row4['y'];

            $y1 = (($y0 - $UnknownTreeX) / tan($rad + 1));
            $y2 = (($y0 - $UnknownTreeX) / tan($rad - 1));

            $x1Crown = $x0 - ($stemHeight + 5) * sin($rad);
            $y1Crown = $y0 + ($stemHeight + 5) * cos($rad);

            $distance = sqrt(pow(($x1Crown - $UnknownTreeX), 2) + pow(($y1Crown - $UnknownTreeY), 2));

            if (($UnknownTreeY > $y1 && $UnknownTreeX < $y2)) {
                $blockVX = $row4['BlockX'];
                $blockVY = $row4['BlockY'];
                $victimX = $row4['x'];
                $victimY = $row4['y'];
                $victimCoor = $row4['TreeNumber'];

                $categoryDamage = "V1";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result11 = mysqli_query($conn, $insert_query);

                if (!$result11) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V1');
            }

            if ($distance <= 5) {
                $blockVX = $row4['BlockX'];
                $blockVY = $row4['BlockY'];
                $victimX = $row4['x'];
                $victimY = $row4['y'];
                $victimCoor = $row4['TreeNumber'];

                $categoryDamage = "V2";

                // Insert the victim data into the database
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coor', '$victimCoor', '$categoryDamage')";
                $result12 = mysqli_query($conn, $insert_query);

                if (!$result12) {
                    die('Error inserting data: ' . mysqli_error($conn));
                }
                victim_mark_status($conn, $tableName, $victimCoor, 'V2');
            }
        }
    }
}
include 'Growth45.php'; // Added this line at the end
?>