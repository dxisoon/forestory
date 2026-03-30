<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Final Output</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: var(--color-black);
            color: var(--color-white);
        }

        .logo {
            color: var(--color-white);
            font-size: 30px;
        }

        .logo span {
            color: var(--color-primary);
        }

        .menu-bar {
            background-color: var(--color-black);
            height: 80px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;

            position: relative;
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
        }

        .menu-bar ul li {
            padding: 10px 30px;
            position: relative;
        }

        .menu-bar ul li a {
            font-size: 20px;
            color: var(--color-white);
            text-decoration: none;

            transition: all 0.3s;
        }

        .menu-bar ul li a:hover {
            color: var(--color-primary);
        }

        .fas {
            float: right;
            margin-left: 10px;
            padding-top: 3px;
        }

        .dropdown-menu {
            display: none;
        }

        .menu-bar ul li:hover .dropdown-menu {
            display: block;
            position: absolute;
            left: 0;
            top: 100%;
            background-color: var(--color-black);
        }

        .menu-bar ul li:hover .dropdown-menu ul {
            display: block;
            margin: 10px;
        }

        .menu-bar ul li:hover .dropdown-menu ul li {
            width: 150px;
            padding: 10px;
        }

        .dropdown-menu-1 {
            display: none;
        }

        .dropdown-menu ul li:hover .dropdown-menu-1 {
            display: block;
            position: absolute;
            left: 150px;
            top: 0;
            background-color: var(--color-black);
        }

        .hero {
            height: calc(100vh - 80px);
            background-image: url(./bg.jpg);
            background-position: center;
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

        table,
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

        h1 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 2rem;
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

        .dropdown-container {
            display: none;
            flex-direction: column;
            padding-left: 20px;
            margin-top: 5px;
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

    <div class="hero">
        <?php
        require_once __DIR__ . '/../config/database.php';
        $conn = forestory_db_connect();

        echo "
                <table>
                <h1>Forest Final Output Regime 45</h1>
                <tr>
                    <th>Species Group</th>
                    <th>Total Volume 0</th>
                    <th>Total Number 0</th>
                    <th>Prod 0</th>
                    <th>Damage 0</th>
                    <th>Remain 0</th>
                    <th>Total Growth 30</th>
                    <th>Total Prod 30</th>
                </tr>
            ";

        $totalVolume = array();
        $totalNumber = array();
        $Prod = array();
        $Damage = array();
        $Remain = array();
        $totalGrowth30 = array();
        $totalProd30 = array();
        $totalProdVolume = array();

        $speciesGroups = [
            ['name' => 'Mersawa', 'spgroup' => 1],
            ['name' => 'Keruing', 'spgroup' => 2],
            ['name' => 'DipCommercial', 'spgroup' => 3],
            ['name' => 'DipNonCommercial', 'spgroup' => 4],
            ['name' => 'NonDipCommercial', 'spgroup' => 5],
            ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
            ['name' => 'Others', 'spgroup' => 7]
        ];

        foreach ($speciesGroups as $group) {
            $query = "SELECT * FROM new_forest WHERE spgroup = " . $group['spgroup'];
            $result = $conn->query($query);
            $totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();

            echo "<tr><td>{$group['name']}</td>";

            $totalVolume = [];
            $totalNumber = [];
            $Prod = [];
            $Damage = [];
            $Remain = [];
            $totalGrowth30 = [];
            $totalProd30 = [];
            $totalProdVolume = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    if ($row['Status'] === 'Cut') {
                        $totalProdVolume[] = $row['Volume'];
                    } else {
                        $totalProdVolume[] = 0;
                    }
                    $totalVolume[] = $row['Volume'];
                    $totalNumber[] = 1;
                    $Prod[] = $row['Status'] === 'Cut' ? 1 : 0;
                    $Damage[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                    $Remain[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                    $totalGrowth30[] = $row['GrowthD30'];
                    $totalProd30[] = $row['production3045'];
                }
            }

            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalProdVolume)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Prod)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Damage)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Remain)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalGrowth30)), 2) . "</td>";
            echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalProd30)), 2) . "</td>";


            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>
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