<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Bar Graph</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Root variables for consistent theme colors */
        :root {
            --color-primary: #0073ff;
            --color-white: #ffffff;
            --color-black: #141d28;
            --color-light-grey: #f5f7fa;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        /* Global resets */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--color-light-grey);
            color: var(--color-black);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Navigation bar styling */
        .menu-bar {
            background-color: var(--color-black);
            height: 60px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            box-shadow: 0 2px 5px var(--shadow-color);
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
        }

        .menu-bar ul li {
            padding: 0 15px;
        }

        .menu-bar ul li a {
            font-size: 16px;
            color: var(--color-white);
            text-decoration: none;
            transition: color 0.3s;
        }

        .menu-bar ul li a:hover {
            color: var(--color-primary);
        }

        /* Chart container styling */
        .chart-container {
            width: 90%;
            max-width: 1200px;
            margin: 40px 0;
            padding: 20px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0px 4px 10px var(--shadow-color);
            text-align: center;
        }

        .chart-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--color-black);
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .chart-title {
                font-size: 22px;
            }

            .menu-bar ul li a {
                font-size: 14px;
            }
        }

        .sustainability-result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            text-align: left;
            font-size: 18px;
        }

        .sustainability-result strong {
            color: #0073ff;
        }

        #comparisonResult {
            margin-bottom: 15px;
        }

        /* Sidebar */
        .sidebar {
            background-color: #013243;
            /* Dark sidebar color */
            width: 330px;
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

        h1 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 2rem;
        }


        /* Form container styling */
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            /* Added margin for better spacing */
        }

        /* Label styling */
        .form-container label {
            font-size: 1.1em;
            font-weight: bold;
            color: var(--color-black);
        }

        /* Select styling */
        .form-container select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            color: var(--color-black);
            background-color: var(--color-white);
            appearance: none;
            width: 150px;
            /* Remove default appearance */
            -webkit-appearance: none;
            /* Safari */
            -moz-appearance: none;
            /* Firefox */
            background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            /* Custom arrow */
            background-repeat: no-repeat;
            background-position-x: calc(100% - 8px);
            background-position-y: 50%;
        }

        /* Button styling */
        .form-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            background-color: var(--color-primary);
            color: var(--color-white);
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        #conclusion-container span,
        #comparison-container span {
            font-weight: bold;
        }
    </style>
</head>

<body>
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

    <!-- Header Section -->
    <h1>Dynamic Bar Graph</h1>

    <!-- Form Container -->
    <div class="form-container">
        <label for="table">Select Table:</label>
        <select id="table">
            <option></option>
            <option value="new_forest">Regime 45</option>
            <option value="new_forest_50">Regime 50</option>
            <option value="new_forest_55">Regime 55</option>
            <option value="new_forest_60">Regime 60</option>
        </select>
        <button onclick="fetchAndRenderGraph()">Fetch and Render Graph</button>
    </div>

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-title">Production Graph Bar</div>
        <canvas id="barChart" width="400" height="200"></canvas>
    </div>

    <div class="sustainability-result">
        <div id="comparison-container">
            <span id="comparison-subtitle">Comparison Result:</span>
            <p id="comparisonResult"></p>
        </div>
        <div id="conclusion-container">
            <span id="conclusion-subtitle">Conclusion:</span>
            <p id="conclusion"></p>
        </div>
    </div>



    <script>
        let chart; // To hold the Chart.js instance

        /**
         * Fetch data from the server and render the graph.
         */
        async function fetchAndRenderGraph() {
            const table = document.getElementById('table').value; // Get selected table

            try {
                // Fetch data from backend
                const response = await fetch(`fetchdata.php?table=${table}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.error);
                }

                // Prepare chart data
                const chartData = {
                    labels: ['Regime 45', 'Regime 50', 'Regime 55', 'Regime 60'],
                    datasets: [
                        {
                            label: 'Production Year 0',
                            data: [
                                data.Production,
                                data.Production,
                                data.Production,
                                data.Production,
                            ],
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Production Year 30',
                            data: [
                                data.production3045,
                                data.production3050,
                                data.production3055,
                                data.production3060,
                            ],
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                        },
                    ],
                };

                // Calculate Rate of Change (slope) for each regime
                const productionAt0 = [
                    data.Production,
                    data.Production,
                    data.Production,
                    data.Production
                ];

                const productionAt30 = [
                    data.production3045,
                    data.production3050,
                    data.production3055,
                    data.production3060
                ];

                let rateOfChange = [];
                let mostSustainableRegime = '';
                let lowestRateOfChange = Infinity;
                let comparisonText = '';

                // Loop to calculate the rate of change for each regime
                for (let i = 0; i < 4; i++) {
                    const P0 = productionAt0[i];
                    const P30 = productionAt30[i];
                    const rate = (P30 - P0) / 30;

                    rateOfChange.push(rate);
                }

                // Sort rates and compare them
                const regimes = ['Regime 45', 'Regime 50', 'Regime 55', 'Regime 60'];
                const ratesWithRegimes = rateOfChange.map((rate, index) => ({
                    regime: regimes[index],
                    rate: rate.toFixed(2)
                }));

                // Sort by the rate of change
                ratesWithRegimes.sort((a, b) => b.rate - a.rate);

                // Generate comparison text
                ratesWithRegimes.forEach((item, index) => {
                    comparisonText += `Data Set ${index + 1} ( ${item.regime} ) has a rate of change of ${item.rate} trees per year.<br>`;
                });

                // Conclusion: The regime with the smallest rate of change is the most sustainable
                const conclusion = `Conclusion: ${ratesWithRegimes[0].regime} has the highest rate of change (${ratesWithRegimes[0].rate} trees per year), indicating the most sustainable growth over 30 years.<br>
                                ${ratesWithRegimes[1].regime} has a moderate rate of change (${ratesWithRegimes[1].rate} trees per year).<br>
                                ${ratesWithRegimes[2].regime} has a higher rate of change (${ratesWithRegimes[2].rate} trees per year), suggesting that it may not be as sustainable in the long run.<br>`;

                // Display the result
                document.getElementById('comparisonResult').innerHTML = comparisonText;
                document.getElementById('conclusion').innerHTML = conclusion;

                // Render chart
                const ctx = document.getElementById('barChart').getContext('2d');

                if (chart) {
                    chart.destroy(); // Destroy existing chart if any
                }

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Trees / Production',
                                },
                            },
                        },
                    },
                });

            } catch (error) {
                console.error('Error:', error);
                alert(`Error fetching data: ${error.message}`);
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