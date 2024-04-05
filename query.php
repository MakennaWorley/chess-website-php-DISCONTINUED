<?php

/* Things to be added at a later date
 *
 * Update queries to check conditions, wamp version of MY_SQL doesn't support CHECK
 * Game- check board letters are Capital letters
 * Game- check that black and white player are not the same person
 * Rating- check that rating is greater than 99
 *
 * UPDATE Player Rating
 * UPDATE Class Level (aka name)
 * REMOVE Player (which means also removing Player from Rating, Class(es), Game)
 * REMOVE Class (requires a removeAll function...)
*/

$user = 'website';
$password = '123';
$database = 'chessdatabase';
$host = 'localhost:8889';
$port = 3306;

$dsn = "mysql:host=$host;dbname=$database;port=$port;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

//------------------------------------------------------------------------------action switch-------------------------//
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'showAllPlayerInformation':
            $result = queryAllPlayers($pdo);
            finish($result);
            break;
        case 'showAllPlayerInClass':
            queryClassNames($pdo);
            break;
        case 'showMinMaxRating':
            $result = queryMinMaxRating($pdo);
            finish($result);
            break;
        case 'showAllTeacherInformation':
            $result = queryAllTeachers($pdo);
            finish($result);
            break;
        case 'showAllGame':
            $result = queryAllGames($pdo);
            finish($result);
            break;
        case 'searchPlayerName':
            searchPlayerNameForm();
            break;
        case 'searchGameName':
            searchGameNameForm();
            break;
        case 'addPlayer':
            addPlayerForm();
            break;
        case 'addClass':
            addClassForm();
            break;
        case 'addPlayerRating':
            addRatingForm();
            break;
        case 'addPlayerClass':
            queryClassNamesForm($pdo);
            break;
        case 'addTeacher':
            queryClassNoTeacher($pdo);
            break;
        case 'addGame':
            addGameForm();
            break;
        case 'updatePlayerName':
            updatePlayerNameForm();
            break;
        case 'updatePlayerClass':
            queryClassNamesForm2($pdo);
            break;
        case 'updateClassTeacher';
            queryClassUpdateTeacher($pdo);
            break;
        case 'updateGameResults':
            updateGameResultsForm();
            break;
        case 'deleteTeacher':
            queryClassDeleteTeacher($pdo);
            break;
        case 'deleteGame':
            deleteGameForm();
            break;
    }
}

//------------------------------------------------------------------------------input1 switch-------------------------//
if (isset($_POST['input'])) {
    $input = $_POST['input'];
    switch ($input) {
        case 'showAllPlayerInClass':
            if (isset($_POST['myUniqueString'])) {
                $keyword = $_POST['myUniqueString'];
                $result = queryAllPlayersInClass($pdo, $keyword);
                finish($result);
            } else {
                echo "<div class='center'>
                        Select a class
                        </div>";
            }
            break;
        case 'searchPlayerName':
            if (isset($_POST['userInput'])) {
                $userInput = $_POST['userInput'];
                $result = querySearchPlayerName($pdo, $userInput);
                finish($result);
            }
            break;
        case 'searchGameName':
            if (isset($_POST['userInput'])) {
                $userInput = $_POST['userInput'];
                $result = querySearchGameName($pdo, $userInput);
                finish($result);
            }
            break;
        case 'addPlayer':
            if (isset($_POST['userInput'])) {
                $userInput = $_POST['userInput'];
                if (queryAddPlayerName($pdo, $userInput)) {
                    $result = queryAllPlayers($pdo);
                    finish($result);
                    break;
                } else {
                    echo '<div class=center>
                    Could not add player
                    </div>';
                }
            }
            break;
        case 'addClass':
            if (isset($_POST['userInput'])) {
                $userInput = $_POST['userInput'];
                if (queryAddClassName($pdo, $userInput)) {
                    echo '<div class=center>
                    Added class successfully
                    </div>';
                } else {
                    echo '<div class=center>
                    Could not add class
                    </div>';
                }
            }
            break;
        case 'addPlayerRating':
            if (isset($_POST['playerName']) && isset($_POST['playerRating'])) {
                $playerName = $_POST['playerName'];
                $playerRatingValue = $_POST['playerRating'];
                if (is_numeric($playerRatingValue) && (int)$playerRatingValue >= 100) {
                    if (queryAddPlayerRating($pdo, $playerName, $playerRatingValue)) {
                        $result = queryAllPlayers($pdo);
                        finish($result);
                    }
                }
            }
            break;
        case 'addPlayerClass':
            if (isset($_POST['myUniqueString'])) {
                $className = $_POST['myUniqueString'];
                echo "Adding to " . $className;
                $classId = getIDFromNameClass($pdo, $className);
                addPlayerNameForm($classId);
            }
            break;
        case 'addTeacher':
            if (isset($_POST['myUniqueString'])) {
                $className = $_POST['myUniqueString'];
                echo "Adding to " . $className;
                $classId = getIDFromNameClass($pdo, $className);
                addTeacherNameForm($classId);
            }
            break;
        case 'addGame':
            if (isset($_POST['boardLetter']) && isset($_POST['boardNumber']) && isset($_POST['whitePlayerName']) && isset($_POST['blackPlayerName'])) {
                $letter = $_POST['boardLetter'];
                $number = $_POST['boardNumber'];
                $white = $_POST['whitePlayerName'];
                $black = $_POST['blackPlayerName'];
                if (getIDFromNamePlayer($pdo, $white) && getIDFromNamePlayer($pdo, $black)) {
                    $whiteId = getIDFromNamePlayer($pdo, $white);
                    $blackId = getIDFromNamePlayer($pdo, $black);
                    if ($whiteId !== $blackId) {
                        if (queryAddGameNormal($pdo, $letter, $number, $whiteId, $blackId)) {
                            $result = queryAllGames($pdo);
                            finish($result);
                        }
                    } else {
                        echo '<div class=center>
                        The same player cannot play both white and black
                        </div>';
                    }
                }
            }
            break;
        case 'updatePlayerName':
            if (isset($_POST['playerOldName']) && isset($_POST['playerNewName'])) {
                $oldName = $_POST['playerOldName'];
                $newName = $_POST['playerNewName'];
                if (getIDFromNamePlayer($pdo, $oldName)) {
                    $playerId = getIDFromNamePlayer($pdo, $oldName);
                    if (queryUpdatePlayerName($pdo, $playerId, $newName)) {
                        $result = showPlayer($pdo, $playerId);
                        finish($result);
                    }
                }
            }
            break;
        case 'updatePlayerClass':
            if (isset($_POST['myUniqueString'])) {
                $className = $_POST['myUniqueString'];
                echo "Adding to " . $className;
                $classId = getIDFromNameClass($pdo, $className);
                updatePlayerClassForm($classId);
            }
            break;
        case 'updateClassTeacher':
            if (isset($_POST['myUniqueString'])) {
                $className = $_POST['myUniqueString'];
                echo "Changing " . $className . "'s teacher to ";
                $classId = getIDFromNameClass($pdo, $className);
                updateTeacherClassForm($classId);
                break;
            }
            break;
        case 'updateGameResults':
            if (isset($_POST['boardLetter']) && isset($_POST['boardNumber'])) {
                $letter = $_POST['boardLetter'];
                $number = $_POST['boardNumber'];
                if (isBoardBeingUsedTrue($pdo, $letter, $number)) {
                    $tempResult = showSingleGame($pdo, $letter, $number);
                    finish($tempResult);
                    updateResultForm($letter, $number);
                }
                break;
            }
        case 'deleteTeacher':
            if (isset($_POST['myUniqueString'])) {
                $className = $_POST['myUniqueString'];
                $classId = getIDFromNameClass($pdo, $className);
                if (deleteTeacherFromClass($pdo, $classId)) {
                    echo '<div class=center>
                        Teacher has been removed from class
                        </div>';
                }
                break;
            }
        case 'deleteGame':
            if (isset($_POST['boardLetter']) && isset($_POST['boardNumber'])) {
                $letter = $_POST['boardLetter'];
                $number = $_POST['boardNumber'];
                if (isBoardBeingUsedTrue($pdo, $letter, $number)) {
                    queryDeleteGame($pdo, $letter, $number);
                    echo '<div class=center>
                        Game has been deleted
                        </div>';
                }
                break;
            }
    }
}

//------------------------------------------------------------------------------input2 switch-------------------------//
if (isset($_POST['input2'])) {
    $input2 = $_POST['input2'];

    switch ($input2) {
        case 'addPlayerClass':
            if (isset($_POST['userInput']) && isset($_POST['classId'])) {
                $playerName = $_POST['userInput'];
                $classId = $_POST['classId'];
                $playerId = getIDFromNamePlayer($pdo, $playerName);
                if (!empty($playerId)) {
                    if (queryAddPlayerClass($pdo, $playerId, $classId)) { //maybe add a query that will show the player in the class??????
                        echo '<div class=center>
                        Added player to class successfully
                        </div>';
                    }
                } else {
                    echo "Error: Player ID not found";
                }
            } else {
                echo "Error: Incomplete data";
            }
            break;
        case 'addTeacher':
            if (isset($_POST['userInput']) && isset($_POST['classId'])) {
                $teacherName = $_POST['userInput'];
                $classId = $_POST['classId'];
                $teacherId = getIDFromNamePlayer($pdo, $teacherName);
                if (!empty($teacherId)) {
                    if (queryAddTeacherClass($pdo, $teacherId, $classId)) { //maybe add a query that will show the player in the class??????
                        echo '<div class=center>
                            Added teacher to class successfully
                            </div>';
                    }
                } else {
                    echo "Error: Player ID not found";
                }
            } else {
                echo "Error: Incomplete data";
            }
            break;
        case 'updatePlayerClass':
            if (isset($_POST['userInput']) && isset($_POST['classId'])) {
                $playerName = $_POST['userInput'];
                $classId = $_POST['classId'];
                $playerId = getIDFromNamePlayer($pdo, $playerName);
                if (!empty($playerId)) {
                    if (queryAddPlayerClass($pdo, $playerId, $classId)) { //maybe add a query that will show the player in the class??????
                        echo '<div class=center>
                        Added player to class successfully
                        </div>';
                    }
                } else {
                    echo "Error: Player ID not found";
                }
            } else {
                echo "Error: Incomplete data";
            }
            break;
        case 'updateClassTeacher':
            if (isset($_POST['userInput']) && isset($_POST['classId'])) {
                $teacherName = $_POST['userInput'];
                $classId = $_POST['classId'];
                $teacherId = getIDFromNamePlayer($pdo, $teacherName);
                if (!empty($teacherId)) {
                    if (queryAddTeacherClass($pdo, $teacherId, $classId)) { //maybe add a query that will show the player in the class??????
                        echo '<div class=center>
                            Updated class\' teacher successfully
                            </div>';
                    }
                } else {
                    echo "Error: Player ID not found";
                }
            } else {
                echo "Error: Incomplete data";
            }
            break;
        case 'updateGameResult':
            $result = $_POST['result'];
            $letter = $_POST['letter'];
            $number = $_POST['number'];
            if (queryUpdateResult($pdo, $letter, $number, $result)) {
                $result = showSingleGame($pdo, $letter, $number);
                finish($result);
            }
            break;
    }
}

//------------------------------------------------------------------------------table creation------------------------//
function finish($result)
{
    if (is_array($result) && count($result) > 0) {
        $columns = array_keys($result[0]);
        echo "<table border='1'>
            <tr>";
        foreach ($columns as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } elseif ($result instanceof PDOStatement && $result->rowCount() > 0) {
        $columns = array_keys($result->fetch(PDO::FETCH_ASSOC));
        echo "<table border='1'>
            <tr>";
        foreach ($columns as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found";
    }
}

//------------------------------------------------------------------------------show functions------------------------//
function queryAllPlayers($pdo)
{
    $result = $pdo->query("SELECT Player.name AS Name, Rating.currentRating AS Rating, Class.level AS Class
                                FROM Player
                                LEFT JOIN Rating ON Rating.playerId = Player.id
                                LEFT JOIN PlayersInClass ON PlayersInClass.playerId = Player.id
                                LEFT JOIN Class ON Class.id = PlayersInClass.classId;");
    if (!$result) {
        die('Error: ' . $pdo->error);
    }
    return $result;
}

function queryAllPlayersInClass($pdo, $keyword) //keyword is from a query to get the names on all entries in level
{
    $stmt = $pdo->prepare("SELECT Player.name AS Name, Class.level AS Class
                            FROM Player
                            LEFT JOIN PlayersInClass ON PlayersInClass.playerId = Player.id
                            LEFT JOIN Class ON Class.id = PlayersInClass.classId
                            WHERE Class.level = :keyword");
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
    }
}


function queryMinMaxRating($pdo)
{
    $result = $pdo->query("SELECT MIN(Rating.currentRating) AS Min, MAX(Rating.currentRating) AS Max
                                FROM Rating;");
    if (!$result) {
        die('Error: ' . $pdo->error);
    }
    return $result;
}

function queryAllTeachers($pdo)
{
    $result = $pdo->query("SELECT Class.level AS Class, Player.name AS Name, Rating.currentRating AS Rating
                                FROM Class
                                INNER JOIN Player ON Player.id = Class.teacherId
                                LEFT JOIN Rating ON Rating.playerId = Player.id;");
    if (!$result) {
        die('Error: ' . $pdo->error);
    }
    return $result;
}

function queryAllGames($pdo)
{
    $result = $pdo->query("SELECT Game.boardLetter AS 'Board Letter', Game.boardNumber AS 'Board Number', WhitePlayer.name AS 'White Player', BlackPlayer.name AS 'Black Player', Game.result AS Result
                                FROM Game
                                LEFT JOIN Player AS WhitePlayer ON WhitePlayer.id = Game.whitePlayer
                                LEFT JOIN Player AS BlackPlayer ON BlackPlayer.id = Game.blackPlayer
                                ORDER BY Game.boardLetter, Game.boardNumber;");
    if (!$result) {
        die('Error: ' . $pdo->error);
    }
    return $result;
}

//------------------------------------------------------------------------------search functions----------------------//
function querySearchPlayerName($pdo, $name)
{
    $stmt = $pdo->prepare("SELECT Player.name AS Name, Rating.currentRating AS Rating, Class.level AS Class
                                FROM Player
                                LEFT JOIN Rating ON Rating.playerId = Player.id
                                LEFT JOIN PlayersInClass ON PlayersInClass.playerId = Player.id
                                LEFT JOIN Class ON Class.id = PlayersInClass.classId
                                WHERE Player.name LIKE :name");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
    }
}

function querySearchGameName($pdo, $name)
{
    $stmt = $pdo->prepare("SELECT Game.boardLetter AS 'Board Letter', Game.boardNumber AS 'Board Number', WhitePlayer.name AS 'White Player', BlackPlayer.name AS 'Black Player', Game.result AS Result
                                FROM Game
                                LEFT JOIN Player AS WhitePlayer ON WhitePlayer.id = Game.whitePlayer
                                LEFT JOIN Player AS BlackPlayer ON BlackPlayer.id = Game.blackPlayer
                                WHERE WhitePlayer.name LIKE :name OR BlackPlayer.name LIKE :name
                                ORDER BY Game.boardLetter, Game.boardNumber;");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
    }
}

//------------------------------------------------------------------------------add functions-------------------------//
function queryAddPlayerName($pdo, $name)
{
    $insertStmt = $pdo->prepare("INSERT INTO Player(name) VALUES (:name);");
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    try {
        if ($insertStmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

//--------------------------------------------------------------------------------------------------function needs to check for dup Class.level
function queryAddClassName($pdo, $name)
{
    $insertStmt = $pdo->prepare("INSERT INTO Class(level) VALUES (:name);");
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    try {
        if ($insertStmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

function queryAddPlayerRating($pdo, $playerName, $playerRatingValue)
{
    $id = getIDFromNamePlayer($pdo, $playerName);
    if ($id !== null) {
        $id2 = checkIDInRating($pdo, $id);
        if ($id2 == false) {
            $insertStmt = $pdo->prepare("INSERT INTO Rating(playerId, currentRating, oldRating)
                                        VALUES (:id, :rating, :rating)");
            $insertStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $insertStmt->bindParam(':rating', $playerRatingValue, PDO::PARAM_INT);
            try {
                if ($insertStmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
        } else {
            return false;
        }
        return false;
    }
}

function queryAddPlayerClass($pdo, $idPlayer, $idClass)
{
    if ($idPlayer !== null) {
        if ($idClass !== null) {
            $insertStmt = $pdo->prepare("INSERT INTO PlayersInClass(playerId, classId)
                                        VALUES (:id, :class)");
            $insertStmt->bindParam(':id', $idPlayer, PDO::PARAM_INT);
            $insertStmt->bindParam(':class', $idClass, PDO::PARAM_INT);
            try {
                if ($insertStmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
        } else {
            return false;
        }
        return false;
    }
}

function queryAddTeacherClass($pdo, $idPlayer, $idClass)
{
    if ($idPlayer !== null) {
        if ($idClass !== null) {
            $insertStmt = $pdo->prepare("UPDATE Class
                                        Set teacherId = :id
                                        WHERE id = :class");
            $insertStmt->bindParam(':id', $idPlayer, PDO::PARAM_INT);
            $insertStmt->bindParam(':class', $idClass, PDO::PARAM_INT);
            try {
                if ($insertStmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
        } else {
            return false;
        }
        return false;
    }
}

function queryAddGameNormal($pdo, $letter, $number, $whiteId, $blackId)
{
    $status = 'Playing';
    if (isBoardBeingUsed($pdo, $letter, $number) == false) {
        $insertStmt = $pdo->prepare("INSERT INTO Game(boardNumber, boardLetter, whitePlayer, blackPlayer, result)
                                    VALUES (:number, :letter, :white, :black, :status)");
        $insertStmt->bindParam(':number', $number, PDO::PARAM_INT);
        $insertStmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
        $insertStmt->bindParam(':white', $whiteId, PDO::PARAM_INT);
        $insertStmt->bindParam(':black', $blackId, PDO::PARAM_INT);
        $insertStmt->bindParam(':status', $status, PDO::PARAM_STR);
        try {
            if ($insertStmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    } else {
        return false;
    }
    return false;
}

//------------------------------------------------------------------------------update functions----------------------//
function queryUpdatePlayerName($pdo, $playerId, $newName)
{
    $insertStmt = $pdo->prepare("UPDATE Player Set name = :name WHERE id = :id;");
    $insertStmt->bindParam(':id', $playerId, PDO::PARAM_INT);
    $insertStmt->bindParam(':name', $newName, PDO::PARAM_STR_CHAR);
    try {
        if ($insertStmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

function queryUpdateResult($pdo, $letter, $number, $result)
{
    $insertStmt = $pdo->prepare("UPDATE Game
                                    SET result = :result
                                    WHERE Game.boardLetter LIKE :letter AND Game.boardNumber LIKE :number;");
    $insertStmt->bindParam(':number', $number, PDO::PARAM_INT);
    $insertStmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
    $insertStmt->bindParam(':result', $result, PDO::PARAM_STR);
    try {
        if ($insertStmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

//------------------------------------------------------------------------------delete functions----------------------//
function deleteTeacherFromClass($pdo, $classId)
{
    if ($classId !== null) {
        $insertStmt = $pdo->prepare("UPDATE Class
                                        Set teacherId = NULL
                                        WHERE id = :class");
        $insertStmt->bindParam(':class', $classId, PDO::PARAM_INT);
        try {
            if ($insertStmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    } else {
        return false;
    }
    return false;
}

function queryDeleteGame($pdo, $letter, $number)
{
    $insertStmt = $pdo->prepare("DELETE FROM Game
                                    WHERE Game.boardLetter LIKE :letter AND Game.boardNumber LIKE :number;");
    $insertStmt->bindParam(':number', $number, PDO::PARAM_INT);
    $insertStmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
    try {
        if ($insertStmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

//------------------------------------------------------------------------------helper functions----------------------//
function getColumnNames($result)
{
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    $values = array_column($rows, 'level');
    return $values;
}

function getColumnId($result)
{
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    $values = array_column($rows, 'id');
    return $values;
}

function getIDFromNamePlayer($pdo, $name)
{
    $stmt = $pdo->prepare("SELECT id FROM Player WHERE name LIKE :name");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['id'])) {
            return $result['id'];
        } else {
            echo '<div class=center>
            Could not find a player
            </div>';
            return null;
        }
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
        return null;
    }
}

function getIDFromNameClass($pdo, $className)
{
    $stmt = $pdo->prepare("SELECT id FROM Class WHERE level LIKE :className");
    $stmt->bindParam(':className', $className, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['id'];
        }
    }
    return null;
}

function checkIDInRating($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT playerId FROM Rating WHERE playerId = :playerId");
    $stmt->bindParam(':playerId', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) { //if the player doesn't have a rating
            return false;
        } else {
            echo '<div class=center>
            Player already has a rating, please use Update Player Rating instead
            </div>';
            return true;
        }
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
        return null;
    }
}

function isBoardBeingUsed($pdo, $letter, $number)
{
    $insertStmt = $pdo->prepare("SELECT boardLetter, boardNumber
                                FROM Game
                                WHERE boardLetter = :letter AND boardNumber = :number;");
    $insertStmt->bindParam(':number', $number, PDO::PARAM_INT);
    $insertStmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
    if ($insertStmt->execute()) {
        $result = $insertStmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) { //if the board isn't being used
            return false;
        } else {
            echo '<div class=center>
                This board is being used, please enter a different board
                </div>';
            return true;
        }
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($insertStmt->errorInfo(), true)));
        return null;
    }
}

function isBoardBeingUsedTrue($pdo, $letter, $number)
{
    $insertStmt = $pdo->prepare("SELECT boardLetter, boardNumber
                                FROM Game
                                WHERE boardLetter = :letter AND boardNumber = :number;");
    $insertStmt->bindParam(':number', $number, PDO::PARAM_INT);
    $insertStmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
    if ($insertStmt->execute()) {
        $result = $insertStmt->fetch(PDO::FETCH_ASSOC);
        if ($result == true) {
            return true;
        } else {
            echo '<div class=center>
                This board is not being used
                </div>';
            return false;
        }
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($insertStmt->errorInfo(), true)));
        return null;
    }
}

function showPlayer($pdo, $playerId)
{
    $insertStmt = $pdo->prepare("SELECT Player.name AS Name, Rating.currentRating AS Rating, Class.level AS Class
                                FROM Player
                                LEFT JOIN Rating ON Rating.playerId = Player.id
                                LEFT JOIN PlayersInClass ON PlayersInClass.playerId = Player.id
                                LEFT JOIN Class ON Class.id = PlayersInClass.classId
                                WHERE Player.id = :number;");
    $insertStmt->bindParam(':number', $playerId, PDO::PARAM_INT);
    if ($insertStmt->execute()) {
        $result = $insertStmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($insertStmt->errorInfo(), true)));
    }
}

function showSingleGame($pdo, $letter, $number)
{
    $stmt = $pdo->prepare("SELECT Game.boardLetter AS 'Board Letter', Game.boardNumber AS 'Board Number', WhitePlayer.name AS 'White Player', BlackPlayer.name AS 'Black Player', Game.result AS Result
                                FROM Game
                                LEFT JOIN Player AS WhitePlayer ON WhitePlayer.id = Game.whitePlayer
                                LEFT JOIN Player AS BlackPlayer ON BlackPlayer.id = Game.blackPlayer
                                WHERE Game.boardLetter LIKE :letter AND Game.boardNumber LIKE :number;");
    $stmt->bindParam(':number', $number, PDO::PARAM_INT);
    $stmt->bindParam(':letter', $letter, PDO::PARAM_STR_CHAR);
    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } else {
        die('Error in query execution: ' . htmlspecialchars(print_r($stmt->errorInfo(), true)));
    }
}

//------------------------------------------------------------------------------query buttons-------------------------//
function queryClassNames($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Class;");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryClass(\'' . htmlspecialchars($entry) . '\')">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

function queryClassNamesForm($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Class;");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $index => $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryClassForm(\'' . htmlspecialchars($entry) . '\');">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

function queryClassNamesForm2($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Class;");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $index => $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryClassForm2(\'' . htmlspecialchars($entry) . '\');">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

function queryClassNoTeacher($pdo)
{
    $stmt = $pdo->query("SELECT *
                        FROM Class
                        WHERE id NOT IN (SELECT Class.id
                                            FROM Class
                                            INNER JOIN Player ON Player.id = Class.teacherId);");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $index => $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryTeacherForm(\'' . htmlspecialchars($entry) . '\');">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

function queryClassUpdateTeacher($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Class;");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryClassUpdateTeacher(\'' . htmlspecialchars($entry) . '\')">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

function queryClassDeleteTeacher($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Class;");
    if ($stmt) {
        $entries = getColumnNames($stmt);
        $ids = getColumnId($stmt);
        if (empty($entries)) {
            echo "No entries found.";
        } else {
            echo '<div class="button-container">';
            foreach ($entries as $entry) {
                //$id = $ids[$index];
                echo '<button onclick="queryClassRemoveTeacher(\'' . htmlspecialchars($entry) . '\')">' . htmlspecialchars($entry) . '</button>';
            }
            echo '</div>';
        }
    } else {
        echo "Error: " . print_r($pdo->errorInfo(), true);
    }
}

//------------------------------------------------------------------------------form search---------------------------//
//Is there a way to get the user input of a textbox when a button is clicked?
function searchPlayerNameForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getSearchPlayerName();">Search</button>
    </form>
    <div id="result"></div>';
}

function searchGameNameForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getSearchGameName();">Search</button>
    </form>
    <div id="result"></div>';
}

//------------------------------------------------------------------------------form add------------------------------//
function addPlayerForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getAddPlayerName();">Add</button>
    </form>
    <div id="result"></div>';
}

function addClassForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a class name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getAddClassName();">Add</button>
    </form>
    <div id="result"></div>';
}

function addRatingForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="playerName">Enter a player name:</label>
    <input type="text" id="playerName" name="playerName">
    <label for="playerRating">Enter their rating:</label>
    <input type="text" id="playerRating" name="playerRating">
    <button type="button" onclick="getAddPlayerRating();">Add</button>
    </form>
    <div id="result"></div>';
}

function addPlayerNameForm($classId)
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getAddPlayerNameClass(' . $classId . ');">Add</button>
    </form>
    <div id="result"></div>';
}

function addTeacherNameForm($classId)
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getAddTeacherNameClass(' . $classId . ');">Add</button>
    </form>
    <div id="result"></div>';
}

function addGameForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
        <label for="boardLetter">Enter a board letter:</label>
        <input type="text" id="boardLetter" name="boardLetter">
        <label for="boardNumber">Enter a board number:</label>
        <input type="text" id="boardNumber" name="boardNumber">
        <label for="whitePlayerName">Enter the white player\'s name:</label>
        <input type="text" id="whitePlayerName" name="whitePlayerName">
        <label for="blackPlayerName">Enter the black player\'s name:</label>
        <input type="text" id="blackPlayerName" name="blackPlayerName">
        <button type="button" onclick="getAddGameForm();">Add</button>
    </form>
    <div id="result"></div>';
}

//------------------------------------------------------------------------------form update---------------------------//
function updatePlayerNameForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="playerOldName">Enter the player\'s name you need to change:</label>
    <input type="text" id="playerOldName" name="playerOldName">
    <label for="playerNewName">Enter their new name:</label>
    <input type="text" id="playerNewName" name="playerNewName">
    <button type="button" onclick="getUpdatePlayerNameForm();">Update</button>
    </form>
    <div id="result"></div>';
}

function updatePlayerClassForm($classId)
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getUpdatePlayerNameClass(' . $classId . ');">Update</button>
    </form>
    <div id="result"></div>';
}

function updateTeacherClassForm($classId)
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="userInput">Enter a name:</label>
    <input type="text" id="userInput" name="userInput">
    <button type="button" onclick="getUpdateTeacherNameClass(' . $classId . ');">Update</button>
    </form>
    <div id="result"></div>';
}

function updateGameResultsForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="playerName">Enter a board letter:</label>
    <input type="text" id="boardLetter" name="boardLetter">
    <label for="playerRating">Enter a board number:</label>
    <input type="text" id="boardNumber" name="boardNumber">
    <button type="button" onclick="getUpdateGameResult();">Search</button>
    </form>
    <div id="result"></div>';
}

function updateResultForm($letter, $number)
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="resultForm">
        <button type="button" onclick="sendResult(\'White\', \'' . $letter . '\', ' . $number . ');">White Won</button>
        <button type="button" onclick="sendResult(\'Black\', \'' . $letter . '\', ' . $number . ');">Black Won</button>
        <button type="button" onclick="sendResult(\'Draw\', \'' . $letter . '\', ' . $number . ');">Draw</button>
        <button type="button" onclick="sendResult(\'Playing\', \'' . $letter . '\', ' . $number . ');">Playing</button>
    </form>
    <div id="result"></div>';
}

//------------------------------------------------------------------------------form delete---------------------------//
function deleteGameForm()
{
    echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    echo '<script src="script.js"></script>';
    echo '
    <form id="myForm">
    <label for="playerName">Enter a board letter:</label>
    <input type="text" id="boardLetter" name="boardLetter">
    <label for="playerRating">Enter a board number:</label>
    <input type="text" id="boardNumber" name="boardNumber">
    <button type="button" onclick="getDeleteGame();">Delete</button>
    </form>
    <div id="result"></div>';
}