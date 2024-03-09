<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Databases Project</title>
    <link rel="stylesheet" href="styles.css">
    <script src="jquery-3.7.1.js"></script>
    <script src="script.js" defer></script>
</head>
<body class="center">
    <h1>Databases Project</h1>
    <p>Still under major construction</p>
    <nav>
        <ul>
            <li><a href="#" onclick="hideShow('.searchMenu');">Search</a></li>
            <li><a href="#" onclick="hideShow('.showMenu');">Show</a></li>
            <li><a href="#" onclick="hideShow('.addMenu');">Add</a></li>
            <li><a href="#" onclick="hideShow('.updateMenu');">Update</a></li>
            <li><a href="#" onclick="hideShow('.deleteMenu');">Delete</a></li>
        </ul>
    </nav>
    <div class="searchMenu"> <!-- This is returning the buttons when the query runs...-->
        <button onclick="query('searchPlayerName')">Search Player</button>
        <button onclick="query('searchGameName')">Search Game</button>
    </div>
    <div class="addMenu">
        <button onclick="query('addPlayer')">Add Player</button>
        <button onclick="query('addPlayerRating')">Add Player Rating</button>
        <button onclick="query('addPlayerClass')">Add Player to Class</button>
        <button onclick="query('addTeacher')">Add Teacher</button>
        <button onclick="query('addClass')">Add Class</button>
        <button onclick="query('addGame')">Add Game</button>
    </div>
    <div class="showMenu">
        <button onclick="query('showAllPlayerInformation')">Show All Players</button>
        <button onclick="query('showAllPlayerInClass')">Show All Players in a Class</button>
        <button onclick="query('showMinMaxRating')">Show Rating Range</button>
        <button onclick="query('showAllTeacherInformation')">Show All Teachers</button>
        <button onclick="query('showAllGame')">Show All Games</button>
    </div>
    <div class="updateMenu">
        <button onclick="query('updatePlayerName')">Update Player's Name</button>
        <button onclick="query('updatePlayerClass')">Update Player's Class</button>
        <button onclick="query('updateClassTeacher')">Update Class's Teacher</button>
        <button onclick="query('updateGameResults')">Update Game Result</button>
    </div>
    <div class="deleteMenu">
        <button onclick="query('deleteTeacher')">Remove Teacher</button>
        <button onclick="query('deleteGame')">Remove Game</button>
    </div>
    <div id="result"></div>
    <div id="resultTable"></div>
</body>

</html>
