<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Stand Table</title>
    <style>
          table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
        }
        .total-row td, .total-row th{
            background-color: #e0f7fa;
        }
         .green-cell{
            background-color: #e8f5e9;
        }

        .main-table {
           width: 80%;
            margin-left: auto;
            margin-right: auto;

        }
    </style>
</head>
<body>
<div class="main-table">
    <h2>STAND TABLE DAMAGE 45</h2>
    <table>
        <thead>
            <tr>
                 <th>Species Name</th>
                 <th colspan="5">Diameter Categories</th>
                 <th>Total</th>
             </tr>
             <tr>
                 <th></th>
                 <th>5 - 15 cm</th>
                 <th>15 - 30 cm</th>
                 <th>30 - 45 cm</th>
                 <th>45 - 60 cm</th>
                 <th>60+ cm</th>
                 <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once __DIR__ . '/config/database.php';
            $conn = forestory_db_connect();

           // Fetch species group names
            $sql_species_names = "SELECT No, species FROM speciesnames";
            $result_species_names = mysqli_query($conn, $sql_species_names);
            $species_names = [];

            if ($result_species_names) {
                 while ($row = mysqli_fetch_assoc($result_species_names)) {
                     $species_names[$row['No']] = $row['species'];
                 }
            }

             // Map of species names based on SPGROUP, from the image you provided
            $group_names = [
                1 => 'Mersawa',
                2 => 'Keruing',
                3 => 'Dip Commercial',
                4 => 'Dip NonCommercial',
                5 => 'NonDip Commercial',
                6 => 'NonDip NonCommercial',
                7 => 'Others'
             ];


             // Fetch distinct species groups
            $sql_groups = "SELECT DISTINCT spgroup FROM new_forest ORDER BY spgroup ASC";
             $result_groups = mysqli_query($conn, $sql_groups);


             if ($result_groups) {
                 $totalVolumeByDiameter = [
                    '5-15' => 0,
                    '15-30' => 0,
                    '30-45' => 0,
                    '45-60' => 0,
                    '60+' => 0,
                ];

                $totalTreesByDiameter = [
                    '5-15' => 0,
                    '15-30' => 0,
                    '30-45' => 0,
                    '45-60' => 0,
                    '60+' => 0,
                ];

                 while ($group_row = mysqli_fetch_assoc($result_groups)) {
                    $spgroup = $group_row['spgroup'];

                   $sql_damage = "SELECT new_forest.diameter, new_forest.Volume FROM new_forest
                       INNER JOIN damagetree ON new_forest.TreeNumber = damagetree.victim
                       WHERE new_forest.spgroup = $spgroup";

                     $result_damage = mysqli_query($conn, $sql_damage);

                     if($result_damage) {
                         $volume_5_15 = 0;
                         $volume_15_30 = 0;
                         $volume_30_45= 0;
                         $volume_45_60= 0;
                         $volume_60_plus= 0;

                          $count_5_15 = 0;
                          $count_15_30 = 0;
                          $count_30_45= 0;
                          $count_45_60= 0;
                          $count_60_plus= 0;
                         while ($species_row = mysqli_fetch_assoc($result_damage)) {
                             $diameter = $species_row['diameter'];
                             $volume = $species_row['Volume'];

                            if ($diameter > 5 && $diameter <= 15) {
                                 $volume_5_15 += $volume;
                                 $count_5_15++;
                             } else if ($diameter > 15 && $diameter <= 30) {
                                 $volume_15_30 += $volume;
                                 $count_15_30++;
                             } else if ($diameter > 30 && $diameter <= 45) {
                                 $volume_30_45 += $volume;
                                 $count_30_45++;
                             } else if ($diameter > 45 && $diameter <= 60) {
                                  $volume_45_60 += $volume;
                                  $count_45_60++;
                            } else if ($diameter > 60) {
                                  $volume_60_plus += $volume;
                                  $count_60_plus++;
                            }
                        }
                         $totalVol = number_format(($volume_5_15 + $volume_15_30 + $volume_30_45 + $volume_45_60 + $volume_60_plus) / 100,2);
                        $isEven = ($spgroup % 2 == 0);
                        echo '<tr' . ($isEven ? '' : ' class="green-cell"') . '>';
                            echo '<td>' . $group_names[$spgroup] . '</td>';
                             echo '<td>' . number_format($volume_5_15 / 100,2) . '</td>';
                             echo '<td>' . number_format($volume_15_30 / 100,2) . '</td>';
                             echo '<td>' . number_format($volume_30_45 / 100,2) . '</td>';
                             echo '<td>' . number_format($volume_45_60 / 100,2) . '</td>';
                            echo '<td>' . number_format($volume_60_plus / 100,2) . '</td>';
                            echo '<td>' . $totalVol . '</td>';
                        echo '</tr>';
                        echo '<tr' . ($isEven ? '':' class="green-cell"') . '>';
                           echo '<td></td>';
                            echo '<td>' . round($count_5_15 / 100) . '</td>';
                             echo '<td>' . round($count_15_30 / 100) . '</td>';
                             echo '<td>' . round($count_30_45 / 100) . '</td>';
                            echo '<td>' . round($count_45_60 / 100) . '</td>';
                            echo '<td>' . round($count_60_plus / 100) . '</td>';
                            echo '<td>' .  round(($count_5_15 + $count_15_30 + $count_30_45 + $count_45_60 + $count_60_plus) / 100) . '</td>';
                         echo '</tr>';

                        $totalVolumeByDiameter['5-15'] += $volume_5_15;
                        $totalVolumeByDiameter['15-30'] += $volume_15_30;
                        $totalVolumeByDiameter['30-45'] +=  $volume_30_45;
                        $totalVolumeByDiameter['45-60'] +=  $volume_45_60;
                        $totalVolumeByDiameter['60+'] +=  $volume_60_plus;

                        $totalTreesByDiameter['5-15'] += $count_5_15;
                        $totalTreesByDiameter['15-30'] += $count_15_30;
                        $totalTreesByDiameter['30-45'] += $count_30_45;
                        $totalTreesByDiameter['45-60'] += $count_45_60;
                         $totalTreesByDiameter['60+'] += $count_60_plus;

                    }
                 }
                 echo '<tr class="total-row">';
                    echo '<td colspan="1">Total Volume</td>';
                     echo '<td>' . number_format($totalVolumeByDiameter['5-15'] / 100, 2) . '</td>';
                     echo '<td>' . number_format($totalVolumeByDiameter['15-30'] / 100, 2) . '</td>';
                    echo '<td>' . number_format($totalVolumeByDiameter['30-45'] / 100, 2) . '</td>';
                   echo '<td>' . number_format($totalVolumeByDiameter['45-60'] / 100, 2) . '</td>';
                    echo '<td>' . number_format($totalVolumeByDiameter['60+'] / 100, 2) . '</td>';
                     echo '<td>' . number_format(array_sum($totalVolumeByDiameter) / 100,2) . '</td>';
                 echo '</tr>';
                echo '<tr class="total-row">';
                    echo '<td colspan="1">Total Trees</td>';
                   echo '<td>' . round($totalTreesByDiameter['5-15'] / 100) . '</td>';
                    echo '<td>' . round($totalTreesByDiameter['15-30'] / 100) . '</td>';
                   echo '<td>' . round($totalTreesByDiameter['30-45'] / 100) . '</td>';
                    echo '<td>' . round($totalTreesByDiameter['45-60'] / 100) . '</td>';
                    echo '<td>' . round($totalTreesByDiameter['60+'] / 100) . '</td>';
                    echo '<td>' . round(array_sum($totalTreesByDiameter) / 100) . '</td>';
               echo '</tr>';
            }  else {
                 echo "Error fetching data: " . mysqli_error($conn);
            }
           mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
</body>
</html>