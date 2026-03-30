<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Stand Table 60</title>
    <style>
        body {
            font-family: Arial, sans-serif;

        }

        /* Style the container for label, select and button */
        .input-container {
            display: flex;
            /* Use flexbox to display elements in a row */
            align-items: center;
            /* Center vertically */
            margin-left: 350px;
            /* Keep the left margin */
        }

        label {
            display: inline-block;
            margin-left: 350px;
            font-weight: bold;
            color: #333;
            margin-bottom: 0;
        }

        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #555;
            box-sizing: border-box;
            -webkit-appearance: none;
            /* Remove default appearance for webkit browsers */
            -moz-appearance: none;
            /* Remove default appearance for Firefox */
            appearance: none;
            /* Remove default appearance */
            background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            /* Adds custom dropdown arrow */
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 50%;
            background-color: white;
        }

        select:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-left: 10px;
            /* Space between the select and the button */
            white-space: nowrap;
            /* Prevent button text from wrapping */
        }

        button:hover {
            background-color: #0056b3;
            /* Darker shade of blue on hover */
            transform: translateY(-2px);
            /* Slight lift on hover */
        }

        button:active {
            background-color: #004085;
            /* Even darker shade of blue when button is clicked */
            transform: translateY(0);
        }

        /* Sidebar */
        .sidebar {
            background-color: #013243;
            /* Dark sidebar color */
            width: 290px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            /* Set a higher z-index than the map */
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: bold;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #026c87;
            padding-bottom: 10px;
        }

        .sidebar a,
        .dropdown-btn {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            font-size: 16px;
            background-color: #013243;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .sidebar a i,
        .dropdown-btn i {
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar a:hover,
        .dropdown-btn:hover {
            background-color: #026c87;
            transform: scale(1.05);
        }

        .dropdown-container {
            display: none;
            flex-direction: column;
            padding-left: 20px;
        }

        .dropdown-container a {
            padding: 8px 15px;
            font-size: 14px;
            margin: 5px 0;
            border-radius: 5px;
            color: white;
            background-color: #013243;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .dropdown-container a:hover {
            background-color: #026c87;
            transform: scale(1.05);
        }

        .dropdown-active .dropdown-container {
            display: flex;
        }

        h1 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 70%;
            border-collapse: collapse;
            margin-left: 470px;
            /* Add a left margin */
            margin-right: auto;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
            /* increase padding for better spacing */
            font-size: 0.9rem;
            /* set a smaller font size */
        }

        th {
            background-color: #f2f2f2;
            /* Slight gray for headers */
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Add a light gray background to even rows */
        }

        .total-row {
            background-color: #e6e6e6;
            font-weight: bold;
        }

        .green-cell {
            background-color: #f0fff0;
            /* Very light green */
        }

        th {
            background-color: #e6e6e6;
        }

        .panel {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #panelA {
            background-color: rgb(255, 255, 255);
        }

        #panelB {
            background-color: rgb(255, 255, 255);
        }

        #panelC {
            background-color: rgb(255, 255, 255);
        }

        #panelD {
            background-color: rgb(255, 255, 255);
        }
    </style>
</head>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-title">Forest Menu</div>
    <a href="../index.html"><i class="fas fa-home"></i> Home</a>
    <button class="dropdown-btn">
        <i class="fas fa-tree"></i> Generate Forest <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="../GenerateForest.php"><i class="fas fa-seedling"></i> Generate New Forest</a>
        <a href="../SelectRegime.php"><i class="fas fa-cogs"></i> Select Regime</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-campground"></i> Stand Table <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="../Regime45/StandTable45.php"><i class="fas fa-cloud"></i> Stand Table 45</a>
        <a href="../Regime50/StandTable50.php"><i class="fas fa-water"></i> Stand Table 50</a>
        <a href="../Regime55/StandTable55.php"><i class="fas fa-leaf"></i> Stand Table 55</a>
        <a href="../Regime60/StandTable60.php"><i class="fas fa-wind"></i> Stand Table 60</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-globe"></i>Final Output <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="../Regime45/FinalOutput45.php"><i class="fas fa-sun"></i> Final Output 45</a>
        <a href="../Regime50/FinalOutput50.php"><i class="fas fa-mountain"></i> Final Output 50</a>
        <a href="../Regime55/FinalOutput55.php"><i class="fas fa-meteor"></i> Final Output 55</a>
        <a href="../Regime60/FinalOutput60.php"><i class="fas fa-moon"></i> Final Output 60</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-tree"></i>Forest Visualization <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="../Regime45/plot.php"><i class="fas fa-sun"></i> Distribution 45</a>
        <a href="../Regime50/plot.php"><i class="fas fa-mountain"></i> Distribution 50</a>
        <a href="../Regime55/plot.php"><i class="fas fa-meteor"></i> Distribution 55</a>
        <a href="../Regime60/plot.php"><i class="fas fa-moon"></i> Distribution 60</a>
    </div>
    <a href="../gBar/GraphBar.php"><i class="fas fa-chart-line"></i> Production Chart</a>
</div>

<body>
    <br>

    <h1>Stand Table 60</h1>
    <label for="panelSelect">Choose a Stand Table:</label>
    <select id="panelSelect" onchange="showPanel()">
        <option value="">-- Select a Stand Table --</option>
        <option value="panelA">ST 0-30</option>
        <option value="panelB">ST Cut Tree</option>
        <option value="panelC">ST Damage</option>
        <option value="panelD">ST Production</option>
    </select>

    <div id="panelA" class="panel">
        <h1>Stand Table Year 0</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once __DIR__ . '/../config/database.php';
                $conn = forestory_db_connect();

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                $totalVolume1[] = $row['Volume'];
                                $totalNumber1[] = 1;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                $totalVolume2[] = $row['Volume'];
                                $totalNumber2[] = 1;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                $totalVolume3[] = $row['Volume'];
                                $totalNumber3[] = 1;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                $totalVolume4[] = $row['Volume'];
                                $totalNumber4[] = 1;
                            } elseif ($diameter > 60) {
                                $totalVolume5[] = $row['Volume'];
                                $totalNumber5[] = 1;
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Stand Table Year 30</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume1[] = $row['Volume30'];
                                }
                                $totalNumber1[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume2[] = $row['Volume30'];
                                }
                                $totalNumber2[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume3[] = $row['Volume30'];
                                }
                                $totalNumber3[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume4[] = $row['Volume30'];
                                }
                                $totalNumber4[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume5[] = $row['Volume30'];
                                }
                                $totalNumber5[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelB" class="panel">
        <h1>Stand Table Cut Tree</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['Status'] === 'Cut' ? 1 : 0;
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelC" class="panel">
        <h1>Stand Table Damage</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelD" class="panel">
        <h1>Stand Table Production Year 0</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['Status'] === 'Cut' ? 1 : 0;
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Stand Table Production Year 30</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['GrowthD30'];


                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['production3045'] == 1) {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['production3045'];
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['production3045'] == 1) {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['production3045'];
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['production3045'] == 1) {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['production3045'];
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['production3045'] == 1) {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['production3045'];
                            } elseif ($diameter > 60) {
                                if ($row['production3045'] == 1) {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['production3045'];
                            }
                        }
                    }

                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function showPanel() {
            // Hide all panels
            const panels = document.querySelectorAll('.panel');
            panels.forEach(panel => panel.style.display = 'none');

            // Get the selected panel ID
            const selectedPanel = document.getElementById('panelSelect').value;

            // Show the selected panel
            if (selectedPanel) {
                document.getElementById(selectedPanel).style.display = 'block';
            }
        }
    </script>
    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Dropdown functionality for sidebar
        const dropdownBtns = document.querySelectorAll('.dropdown-btn');
        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.toggle('dropdown-active');
                const dropdownContent = btn.nextElementSibling;
                if (dropdownContent.style.display === 'flex') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'flex';
                }
            });
        });
    </script>
</body>

</html>