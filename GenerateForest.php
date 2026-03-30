<?php
session_start(); // Start the session

require_once __DIR__ . '/config/database.php';
$conn = forestory_db_connect();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["generate"])) {
        header("Location: Gen_Forest.php"); // Redirect to Gen_Forest.php
        exit(); // Terminate the current script
    } elseif (isset($_POST["clear"])) {
        // Delete data from forest tables
        $forest_tables = ["new_forest", "new_forest_50", "new_forest_55", "new_forest_60"];
        foreach ($forest_tables as $table) {
            $sql = "DELETE FROM " . $table;
            if ($conn->query($sql) !== TRUE) {
                echo "Error deleting from $table: " . $conn->error;
            }
        }

        // Delete data from damage tables
        $damage_tables = ["damagetree", "damagetree50", "damagetree55", "damagetree60"];
        foreach ($damage_tables as $table) {
            $sql = "DELETE FROM " . $table;
            if ($conn->query($sql) !== TRUE) {
                echo "Error deleting from $table: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e0f7fa;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background-color: #013243;
            width: 290px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
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

        .sidebar-footer {
            margin-top: auto;
            color: #9db2c6;
            font-size: 14px;
            text-align: center;
            padding: 40px 0;
            border-top: 1px solid #026c87;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            /* Adjust for the sidebar */
            flex: 1;
            padding: 40px;
            background-color: #e0f7fa;
            text-align: center;
            height: 100vh;
            /* Fixes the content to the screen height */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Prevents overflow */
        }

        /* Form Container */
        .form-container {
            text-align: center;
            background: #F5F5F5;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 60px;
            max-width: 600px;
            width: 100%;
        }

        /* Form Title */
        .form-container h1 {
            font-size: 2rem;
            color: #2e7d32;
            margin-bottom: 30px;
        }

        /* Buttons Wrapper */
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        /* Buttons */
        .form-buttons button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 50px 30px;
            /* Adjusted padding for better proportion */
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 45%;
            /* Buttons occupy 45% of the container */
        }

        .form-buttons button i {
            margin-right: 10px;
        }

        /* Generate Forest Button */
        button[name="generate"] {
            background: #4caf50;
            color: white;
        }

        button[name="generate"]:hover {
            background: #388e3c;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Clear Forest Button */
        button[name="clear"] {
            background: #e53935;
            color: white;
        }

        button[name="clear"]:hover {
            background: #c62828;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Banner Section */
        .banner {
            position: relative;
            width: 80%;
            height: 350px;
            /* Adjust the height of the banner */
            background: url('images/GenForest.gif') no-repeat center center/cover;
            /* Add background image */
            border-radius: 10px;
            /* Optional: Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Subtle shadow for better effect */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
            /* Add shadow to text for better readability */
            padding: 20px;
            margin-bottom: 40px;
            /* Space below the banner */
        }

        /* Banner Content */
        .banner-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .banner-content p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Image Container */
        .image-container {
            margin-top: 20px;
            text-align: center;
        }

        .image-container img {
            width: 100%;
            /* Adjusted to make the image slightly larger */
            max-width: 550px;
            /* Increased maximum size */
            height: auto;
            /* Maintain aspect ratio */
            border-radius: 20px;
            /* Softer rounding */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .banner {
                height: 250px;
                /* Adjust banner height for smaller screens */
            }

            .banner-content h1 {
                font-size: 2rem;
            }

            .banner-content p {
                font-size: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-title">Forest Menu</div>
    <a href="index.html"><i class="fas fa-home"></i> Home</a>
    <button class="dropdown-btn">
        <i class="fas fa-tree"></i> Generate Forest <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="GenerateForest.php"><i class="fas fa-seedling"></i> Generate New Forest</a>
        <a href="SelectRegime.php"><i class="fas fa-cogs"></i> Select Regime</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-campground"></i> Stand Table <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="Regime45/StandTable45.php"><i class="fas fa-cloud"></i> Stand Table 45</a>
        <a href="Regime50/StandTable50.php"><i class="fas fa-water"></i> Stand Table 50</a>
        <a href="Regime55/StandTable55.php"><i class="fas fa-leaf"></i> Stand Table 55</a>
        <a href="Regime60/StandTable60.php"><i class="fas fa-wind"></i> Stand Table 60</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-globe"></i>Final Output <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="Regime45/FinalOutput45.php"><i class="fas fa-sun"></i> Final Output 45</a>
        <a href="Regime50/FinalOutput50.php"><i class="fas fa-mountain"></i> Final Output 50</a>
        <a href="Regime55/FinalOutput55.php"><i class="fas fa-meteor"></i> Final Output 55</a>
        <a href="Regime60/FinalOutput60.php"><i class="fas fa-moon"></i> Final Output 60</a>
    </div>
    <button class="dropdown-btn">
        <i class="fas fa-tree"></i>Forest Visualization <i class="fas fa-caret-down" style="margin-left:auto;"></i>
    </button>
    <div class="dropdown-container">
        <a href="Regime45/plot.php"><i class="fas fa-sun"></i> Distribution 45</a>
        <a href="Regime50/plot.php"><i class="fas fa-mountain"></i> Distribution 50</a>
        <a href="Regime55/plot.php"><i class="fas fa-meteor"></i> Distribution 55</a>
        <a href="Regime60/plot.php"><i class="fas fa-moon"></i> Distribution 60</a>
    </div>
    <a href="gBar/GraphBar.php"><i class="fas fa-chart-line"></i> Production Chart</a>
</div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Banner Section -->
        <div class="banner">
            <div class="banner-content">
                <h1>Generate Forest</h1>
                <p>"Generate Forest is a powerful tool designed to
                    simulate and create forest data tailored to specific
                    scenarios. By selecting this feature, users can
                    generate detailed forest models that reflect
                    real-world conditions, providing insights into tree
                    growth, carbon storage, and biodiversity.
                    This functionality supports sustainable forest
                    management practices, making it easier for
                    researchers, environmentalists, and policymakers to
                    plan for the future of our natural ecosystems."
                </p>
            </div>
        </div>
        <div class="form-container">
            <form method="post" class="form-buttons">
                <button type="submit" name="generate" class="generate-button">
                    <i class="fas fa-tree"></i> Generate Forest
                </button>
                <button type="submit" name="clear" class="clear-button">
                    <i class="fas fa-trash-alt"></i> Clear Forest
                </button>
            </form>
        </div>
    </div>
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

<?php
// Close the database connection
if (isset($conn)) {
    mysqli_close($conn);
}
?>