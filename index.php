<?php
/*
 * Do like a landing page for just normal people
 * Have a login page to actually change the database
 * Also add a feature for a excel sheet to be read in and database altered accordingly
*/
?>

<!doctype html>
<head>
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oakwood Chess Club</title>
    <script src="resources/jquery-3.7.1.js"></script>
    <script src="javascript/homepage.js" defer></script>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body class="center">
<div class="image-container">
    <h1>Oakwood Chess Club Ratings</h1>
    <p>Still under major construction</p>
</div>

<nav>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#" onclick="showMenu('.homePage');">Search Our Database</a></li>
    </ul>
</nav>

<div class = "homePage">
    <button onclick="query('searchPlayerName')">Search Player</button>
    <button onclick="query('showAllPlayerInformation')">Show All Players</button>
    <button onclick="query('showAllPlayerInClass')">Show All Players in a Class</button>
    <button onclick="query('showMinMaxRating')">Show Rating Range</button>
</div>

    <div id="result"></div>
    <div id="resultTable"></div>
</body>