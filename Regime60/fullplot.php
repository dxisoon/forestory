<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tree Map with MapTiler</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="styles.css">
  <style>
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

    .sidebar-footer {
      margin-top: auto;
      color: #9db2c6;
      font-size: 14px;
      text-align: center;
      padding: 10px 0;
      border-top: 1px solid #026c87;
    }

    h1 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 20px;
      font-size: 2rem;
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

  <!-- Controls Panel -->
  <div id="controls">
    <!-- <label for="blockX">Block Y:</label>
    <input type="number" id="blockX" value="1" min="1">
    <label for="blockY">Block X:</label>
    <input type="number" id="blockY" value="1" min="1"> -->
    <label for="SpGroup">Species Group:</label>
    <select id="SpGroup">
      <option value="8" selected>All</option>
      <option value="1">Mersawa</option>
      <option value="2">Keruing</option>
      <option value="3">Dip Commercial</option>
      <option value="4">Dip NonCommercial</option>
      <option value="5">NonDip Commercial</option>
      <option value="6">NonDip NonCommercial</option>
      <option value="7">Others</option>
    </select>
    <label for="latitude">Latitude:</label>
    <input type="number" id="latitude" value="5.417965" step="0.000001">
    <label for="longitude">Longitude:</label>
    <input type="number" id="longitude" value="101.812081" step="0.000001">
    <button id="loadData">Load Data</button>
    <button class="nav-button" onclick="window.location.href='plot.php'">Map Per Block</button>
  </div>

  <!-- Map Container -->
  <div id="map"></div>
  <script>
    let lat = 5.417965; // Default latitude
    let log = 101.812081; // Default longitude
    let rectangle = null; // Rectangle for the block

    async function fetchForestData(spGroup = 8) {
      try {
        const url = `fetchdatafull.php?SpGroup=${spGroup}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error fetching forest data:', error);
        return [];
      }
    }

    // Debug response
    fetchForestData().then(data => console.log(data));

    // Initialize map
    const map = L.map('map').setView([lat, log], 20); // Initial zoom level 20 for a detailed view

    // Add MapTiler tiles
    const apiKey = 'eObgw8Pn6PuGVdwTtBjL'; // Replace with your MapTiler API key
    L.tileLayer(`https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=${apiKey}`, {
      attribution: '&copy; <a href="https://www.maptiler.com/">MapTiler</a>',
      maxZoom: 22 // Supports higher zoom levels
    }).addTo(map);

    // function createRectangle(blockX, blockY) {
    //     // Calculate the new rectangle coordinates
    //     const blockLat = lat + (blockX - 1) * 100 * 0.000009;
    //     const blockLng = log + (blockY - 1) * 100 * 0.000009;

    //     // Rectangle dimensions in degrees
    //     const blockWidth = 100 * 0.000009;
    //     const blockHeight = 100 * 0.000009;

    //     // Rectangle boundaries
    //     const rectangleBounds = [
    //         [blockLat, blockLng], // Bottom Left
    //         [blockLat, blockLng + blockWidth], // Bottom Right
    //         [blockLat + blockHeight, blockLng + blockWidth], // Top Right
    //         [blockLat + blockHeight, blockLng] // Top Left
    //     ];

    //     // Remove the old rectangle if it exists
    //     if (rectangle) {
    //         map.removeLayer(rectangle);
    //     }

    //     // Create a new rectangle and add it to the map
    //     rectangle = L.polygon(rectangleBounds, {
    //         color: 'black',
    //         weight: 2,
    //         fillOpacity: 0
    //     }).addTo(map);

    //     // Calculate center of the rectangle
    //     const centerLat = blockLat + blockHeight / 2;
    //     const centerLng = blockLng + blockWidth / 2;

    //     // Center the map on the rectangle
    //     map.setView([centerLat, centerLng], 20);

    //     // Bind popup to the rectangle
    //     rectangle.bindPopup(`Block X: ${blockX}<br>Block Y: ${blockY}`);
    // }
    function plotTreeMarkers(data) {
      // Define color mapping for tree status
      const statusColors = {
        Cut: 'red',
        Keep: 'green',
        V1: 'yellow',
        V2: 'blue',
        Default: 'gray'
      };

      data.forEach(tree => {
        // Adjust coordinates based on x, y relative to latitude and longitude
        const adjustedLat = lat + (tree.y * 0.000009);
        const adjustedLng = log + (tree.x * 0.000009);

        // Get the color based on the tree status or use a default
        const color = statusColors[tree.Status] || statusColors.Default;

        // Add a CircleMarker for the tree
        const marker = L.circleMarker([adjustedLat, adjustedLng], {
          radius: 0.5, // Adjust size based on the desired marker size
          color: color,
          fillColor: color,
          fillOpacity: 0.8
        }).addTo(map);

        if (tree.Status === 'Cut') {
          // Calculate the end point of the line based on the cutting angle
          const adjustedCutAngle = (90 - tree.Cut_Angle + 360) % 360; // Convert to clock perspective
          const angleInRadians = tree.Cut_Angle * (Math.PI / 180); // Convert angle to radians
          const spreadInRadians = (1) * (Math.PI / 180); // Spread is 1 degree, so each side is 0.5 degree
          const angleInRadians2 = angleInRadians + spreadInRadians; // Upper bound of the spread
          const angleInRadians3 = angleInRadians - spreadInRadians; // Lower bound of the spread
          const lineLength = tree.StemHeight * 0.000009; // Length of the line in degrees (adjust as needed)

          //main line
          const endLat = adjustedLat + lineLength * Math.sin(angleInRadians);
          const endLng = adjustedLng + lineLength * Math.cos(angleInRadians);
          //spreadline1
          const endLat2 = adjustedLat + lineLength * Math.sin(angleInRadians2);
          const endLng2 = adjustedLng + lineLength * Math.cos(angleInRadians2);
          //spreadline2
          const endLat3 = adjustedLat + lineLength * Math.sin(angleInRadians3);
          const endLng3 = adjustedLng + lineLength * Math.cos(angleInRadians3);
          // Draw a line for the cut tree
          L.polyline([[adjustedLat, adjustedLng], [endLat, endLng]], {
            color: statusColors['Cut'],
            weight: 2
          }).addTo(map);
          L.polyline([[adjustedLat, adjustedLng], [endLat2, endLng2]], {
            color: statusColors['Cut'],
            weight: 2
          }).addTo(map);
          L.polyline([[adjustedLat, adjustedLng], [endLat3, endLng3]], {
            color: statusColors['Cut'],
            weight: 2
          }).addTo(map);
          L.circle([endLat, endLng], {
            radius: 5, // Radius in meters
            color: 'blue', // Circle color
            fillColor: 'blue', // Fill color
            fillOpacity: 0 // Fill opacity
          }).addTo(map);
        }

        // Add a popup with tree details
        marker.bindPopup(`
                <strong>Tree Number:</strong> ${tree.TreeNumber || 'N/A'}<br>
                <strong>Status:</strong> ${tree.Status || 'Unknown'}<br>
                <strong>Diameter:</strong> ${tree.diameter || 0} m<br>
                <strong>Height:</strong> ${tree.StemHeight || 0} m
            `);
      });
    }

    function addGridLines() {
      if (!rectangle) return; // Ensure the rectangle exists

      const bounds = rectangle.getBounds(); // Get the rectangle's boundaries
      const startLat = bounds.getSouth(); // Bottom edge latitude
      const endLat = bounds.getNorth(); // Top edge latitude
      const startLng = bounds.getWest(); // Left edge longitude
      const endLng = bounds.getEast(); // Right edge longitude

      const gridInterval = 10 * 0.000009; // Convert grid interval to degrees (10m)

      // Draw vertical grid lines within the rectangle
      for (let lng = startLng; lng <= endLng; lng += gridInterval) {
        L.polyline([[startLat, lng], [endLat, lng]], {
          color: 'black',
          weight: 1,
          dashArray: '5, 5' // Dashed line
        }).addTo(map);
      }

      // Draw horizontal grid lines within the rectangle
      for (let lat = startLat; lat <= endLat; lat += gridInterval) {
        L.polyline([[lat, startLng], [lat, endLng]], {
          color: 'black',
          weight: 1,
          dashArray: '5, 5' // Dashed line
        }).addTo(map);
      }
    }

    // Function to handle the "Load Data" button click
    document.getElementById('loadData').addEventListener('click', async () => {
      const spGroup = document.getElementById('SpGroup').value;
      const inputLat = parseFloat(document.getElementById('latitude').value);
      const inputLng = parseFloat(document.getElementById('longitude').value);

      if (!isNaN(inputLat) && !isNaN(inputLng)) {
        lat = inputLat; // Update global latitude
        log = inputLng; // Update global longitude
        map.setView([lat, log], 20); // Center the map on the new location
      }

      // Fetch data and plot it on the map
      const treeData = await fetchForestData(spGroup);

      if (treeData.length === 0) {
        alert('No data found for the selected species group.');
        return;
      }

      // Clear previous markers
      map.eachLayer(layer => {
        if (
          layer !== rectangle && // Exclude the rectangle
          (layer instanceof L.Marker ||
            layer instanceof L.CircleMarker ||
            layer instanceof L.Polyline)
        ) {
          map.removeLayer(layer);
        }
      });

      // Plot new data
      plotTreeMarkers(treeData);
    });

    // Initial load of data
    fetchForestData().then(data => {
      if (data.length > 0) {
        plotTreeMarkers(data);
      } else {
        console.log('No initial data found.');
      }
    });


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