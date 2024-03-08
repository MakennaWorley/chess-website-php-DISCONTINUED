<!doctype html>
<html>
<head>
    <title>Databases Project</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js" defer></script>
    <!-- php include 'query.php'  -->
</head>
<body>
    <h1>Databases Project</h1>
    <p>This uses way too many buttons but it works</p>
    <div class="mainMenu">
        <button onclick="hideShow('.mainMenu','.searchMenu');">Search</button>
        <button onclick="hideShow('.mainMenu','.showMenu');">Show</button>
        <button onclick="hideShow('.mainMenu','.addMenu');">Add</button>
        <button onclick="hideShow('.mainMenu','.updateMenu');">Update</button>
        <button onclick="hideShow('.mainMenu','.deleteMenu');">Remove</button>
    </div>
    <div class="searchMenu">
        <button onclick="hideShow('.searchMenu', '.mainMenu')">Back</button>
        <button onclick="query('searchPlayerName')">Search Player</button>
        <button onclick="query('searchGameName')">Search Game</button>
    </div>
    <div class="addMenu">
        <button onclick="hideShow('.addMenu', '.mainMenu')">Back</button>
        <button onclick="query('addPlayer')">Add Player</button>
        <button onclick="query('addPlayerRating')">Add Player Rating</button>
        <button onclick="query('addPlayerClass')">Add Player to Class</button>
        <button onclick="query('addTeacher')">Add Teacher</button>
        <button onclick="query('addClass')">Add Class</button>
        <button onclick="query('addGame')">Add Game</button>
    </div>
    <div class="showMenu">
        <button onclick="hideShow('.showMenu', '.mainMenu')">Back</button>
        <button onclick="query('showAllPlayerInformation')">Show All Players</button>
        <button onclick="query('showAllPlayerInClass')">Show All Players in a Class</button>
        <button onclick="query('showMinMaxRating')">Show Rating Range</button>
        <button onclick="query('showAllTeacherInformation')">Show All Teachers</button>
        <button onclick="query('showAllGame')">Show All Games</button>
    </div>
    <div class="updateMenu">
        <button onclick="hideShow('.updateMenu', '.mainMenu')">Back</button>
        <button onclick="query('updatePlayerName')">Update Player's Name</button>
        <button onclick="query('updatePlayerClass')">Update Player's Class</button>
        <button onclick="query('updateClassTeacher')">Update Class's Teacher</button>
        <button onclick="query('updateGameResults')">Update Game Result</button>
    </div>
    <div class="deleteMenu">
        <button onclick="hideShow('.deleteMenu', '.mainMenu')">Back</button>
        <button onclick="query('deleteTeacher')">Remove Teacher</button>
        <button onclick="query('deleteGame')">Remove Game</button>
    </div>
    <div id="result"></div>
    <div id="resultTable"></div>
</body>

</html>
