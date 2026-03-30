<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Regime</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            display: flex;
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
            padding: 10px 0;
            border-top: 1px solid #026c87;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            background-color: #e0f7fa;
            text-align: center;
            overflow: hidden;
        }

        /* Banner Section */
        .banner {
            position: relative;
            width: 80%;
            height: 350px;
            /* Adjust the height of the banner */
            background: url('images/regime.gif') no-repeat center center/cover;
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

        /* Form Section */
        .form-section {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 30px 20px;
            background-color: #e0f7fa;
            /* Match the overall background */
        }

        .form-container {
            background: #ffffff;
            /* Use white for contrast */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: left;
        }

        /* Form Title */
        .form-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #2e7d32;
            /* Green text for harmony */
            margin-bottom: 20px;
        }

        /* Form Label */
        .form-label {
            font-size: 1rem;
            font-weight: bold;
            color: #555;
            /* Neutral gray */
            margin-bottom: 5px;
            display: block;
        }

        /* Dropdown Menu */
        select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            /* Light background for input */
            color: #333;
            /* Dark text */
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            color: white;
            background-color: #4caf50;
            /* Green for call-to-action */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .submit-btn:hover {
            background-color: #388e3c;
            /* Darker green on hover */
            transform: scale(1.05);
        }

        .submit-btn:hover {
            background-color: #388e3c;
            transform: scale(1.05);
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
                <h1>Select Your Forest Regime</h1>
                <p>Select from our tailored regimes to better
                    understand sustainable forest management practices.
                    Each regime is designed to suit different goals and
                    scenarios, empowering you to make informed decisions for
                    forest sustainability. </p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="form-container">
                <form id="regimeForm" method="get">
                    <h2 class="form-title">Choose Your Regime</h2>
                    <label for="regimeSelect" class="form-label">Select a Regime:</label>
                    <select id="regimeSelect" name="regime">
                        <option value="Regime45">Regime 45</option>
                        <option value="Regime50">Regime 50</option>
                        <option value="Regime55">Regime 55</option>
                        <option value="Regime60">Regime 60</option>
                    </select>
                    <button type="submit" class="submit-btn">Go to Calculation</button>
                </form>
            </div>
        </div>




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

            // Redirect when form is submitted
            document.getElementById('regimeForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission
                var selectedRegime = document.getElementById('regimeSelect').value;
                var calculationFile;
                switch (selectedRegime) {
                    case 'Regime45':
                        calculationFile = 'Regime45/Calculation45.php';
                        break;
                    case 'Regime50':
                        calculationFile = 'Regime50/Calculation50.php';
                        break;
                    case 'Regime55':
                        calculationFile = 'Regime55/Calculation55.php';
                        break;
                    case 'Regime60':
                        calculationFile = 'Regime60/Calculation60.php';
                        break;
                    default:
                        calculationFile = 'index.php'; // Fallback to index.php
                }
                window.location.href = calculationFile;
            });
        </script>
</body>

</html>