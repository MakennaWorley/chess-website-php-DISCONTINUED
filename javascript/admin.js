$(document).ready(function () {
    window.query = function (method, keyword = null) {
        var data = new URLSearchParams();
        data.append('action', method);
        if (keyword !== null) {
            data.append('myUniqueString', keyword);
        }
        fetch('query.php', {
            method: 'POST',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: data
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(responseText => {
                console.log(responseText);
                $("#resultTable").html();
                document.getElementById("resultTable").innerHTML = responseText;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    //------------------------------------------------------------------------------input1 query----------------------//
    window.queryClass = function (entry) { //this is from a button
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'showAllPlayerInClass',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                document.getElementById("resultTable").innerHTML = response;
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    };

    window.queryClassForm = function (entry) { //this is from a button
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'addPlayerClass',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    }

    window.queryClassForm2 = function (entry) { //this is from a button
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'updatePlayerClass',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    }

    window.queryTeacherForm = function (entry) { //this is from a button
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'addTeacher',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    }

    window.queryClassUpdateTeacher = function (entry) { //this is from a buttton
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'updateClassTeacher',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                document.getElementById("resultTable").innerHTML = response;
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    };

    window.queryClassRemoveTeacher = function (entry) { //this is from a buttton
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'deleteTeacher',
                myUniqueString: entry,
            },
            success: function (response) {
                console.log("Keyword is:" + entry);
                $("#resultTable").html();
                document.getElementById("resultTable").innerHTML = response;
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    };

    //------------------------------------------------------------------------------input1 get----------------------------//
    window.getSearchPlayerName = function () {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: "searchPlayerName",
                userInput: userInputValue
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
    };

    window.getSearchGameName = function () {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: "searchGameName",
                userInput: userInputValue
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
    };

    window.getAddPlayerName = function () {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: "addPlayer",
                userInput: userInputValue
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    };

    window.getAddClassName = function () {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: "addClass",
                userInput: userInputValue
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    };

    window.getAddPlayerRating = function () {
        var playerNameValue = document.getElementById("playerName").value;
        var playerRatingValue = document.getElementById("playerRating").value;
        if (playerNameValue.trim() === "" || playerRatingValue.trim() === "") {
            console.log("No data found in one or both text boxes");
            $("#result").html("Please enter information into both textboxes");
            return;
        } else if (parseInt(playerRatingValue) < 100) {
            console.log("Invalid rating");
            $("#result").html("Rating must be greater than 99");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: "addPlayerRating",
                playerName: playerNameValue,
                playerRating: playerRatingValue
            },
            success: function (response) {
                console.log("Player Name is: " + playerNameValue);
                console.log("Player Rating is: " + playerRatingValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    };

    window.getAddGameForm = function () {
        var boardLetter = document.getElementById("boardLetter").value;
        var boardNumber = document.getElementById("boardNumber").value;
        var whitePlayerName = document.getElementById("whitePlayerName").value;
        var blackPlayerName = document.getElementById("blackPlayerName").value;
        if (boardLetter.trim() === "" || boardNumber.trim() === "" || whitePlayerName.trim() === "" || blackPlayerName.trim() === "") {
            console.log("No data found in one or all text boxes");
            $("#result").html("Please enter information into all textboxes");
            return;
        } else if (/^[a-z]$/.test(boardLetter) == false) {
            console.log("Invalid boardLetter");
            $("#result").html("Must be a lowercase single letter");
        } else if (/^[0-9]?[1-9]$/.test(boardNumber) == false) {
            console.log("Invalid boardNumber");
            $("#result").html("Must be a number between 1-99");
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'addGame',
                boardLetter: boardLetter,
                boardNumber: boardNumber,
                whitePlayerName: whitePlayerName,
                blackPlayerName: blackPlayerName
            },
            success: function (response) {
                console.log("boardLetter: " + boardLetter);
                console.log("boardNumber: " + boardNumber);
                console.log("whitePlayerName: " + whitePlayerName);
                console.log("blackPlayerName: " + blackPlayerName);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getUpdatePlayerNameForm = function () {
        var playerOldName = document.getElementById("playerOldName").value;
        var playerNewName = document.getElementById("playerNewName").value;
        if (playerOldName.trim() === "" || playerNewName.trim() === "") {
            console.log("No data found in one or both text boxes");
            $("#result").html("Please enter information into both textboxes");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'updatePlayerName',
                playerOldName: playerOldName,
                playerNewName: playerNewName
            },
            success: function (response) {
                console.log(playerOldName + " changerd to " + playerNewName);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getUpdateGameResult = function () {
        var boardLetter = document.getElementById("boardLetter").value;
        var boardNumber = document.getElementById("boardNumber").value;
        if (boardLetter.trim() === "" || boardNumber.trim() === "") {
            console.log("No data found in one or all text boxes");
            $("#result").html("Please enter information into all textboxes");
            return;
        } else if (/^[a-z]$/.test(boardLetter) == false) {
            console.log("Invalid boardLetter");
            $("#result").html("Must be a lowercase single letter");
        } else if (/^[0-9]?[1-9]$/.test(boardNumber) == false) {
            console.log("Invalid boardNumber");
            $("#result").html("Must be a number between 1-99");
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'updateGameResults',
                boardLetter: boardLetter,
                boardNumber: boardNumber
            },
            success: function (response) {
                console.log("boardLetter: " + boardLetter);
                console.log("boardNumber: " + boardNumber);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getDeleteGame = function () {
        var boardLetter = document.getElementById("boardLetter").value;
        var boardNumber = document.getElementById("boardNumber").value;
        if (boardLetter.trim() === "" || boardNumber.trim() === "") {
            console.log("No data found in one or all text boxes");
            $("#result").html("Please enter information into all textboxes");
            return;
        } else if (/^[a-z]$/.test(boardLetter) == false) {
            console.log("Invalid boardLetter");
            $("#result").html("Must be a lowercase single letter");
        } else if (/^[0-9]?[1-9]$/.test(boardNumber) == false) {
            console.log("Invalid boardNumber");
            $("#result").html("Must be a number between 1-99");
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input: 'deleteGame',
                boardLetter: boardLetter,
                boardNumber: boardNumber
            },
            success: function (response) {
                console.log("boardLetter: " + boardLetter);
                console.log("boardNumber: " + boardNumber);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    //------------------------------------------------------------------------------input2 get----------------------------//
    window.getAddPlayerNameClass = function (classId) {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input2: 'addPlayerClass',
                userInput: userInputValue,
                classId: classId
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getAddTeacherNameClass = function (classId) {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input2: 'addTeacher',
                userInput: userInputValue,
                classId: classId
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getUpdatePlayerNameClass = function (classId) {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input2: 'updatePlayerClass',
                userInput: userInputValue,
                classId: classId
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

    window.getUpdateTeacherNameClass = function (classId) {
        var userInputValue = document.getElementById("userInput").value;
        if (userInputValue.trim() === "") {
            console.log("Invalid entry");
            $("#result").html("Please try again");
            return;
        }
        $.ajax({
            type: "POST",
            url: "query.php",
            data: {
                input2: 'updateClassTeacher',
                userInput: userInputValue,
                classId: classId
            },
            success: function (response) {
                console.log("Name is: " + userInputValue);
                $("#resultTable").html();
                $("#resultTable").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr.responseText);
            },
        });
    };

});

function sendResult(result, letter, number) { //this uses buttons
    $.ajax({
        type: "POST",
        url: "query.php",
        data: {
            input2: 'updateGameResult',
            result: result,
            letter: letter,
            number: number
        },
        success: function (response) {
            console.log("Game results is " + result);
            $("#resultTable").html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", xhr.responseText);
        },
    });
}


//------------------------------------------------------------------------------hide/show-----------------------------//
let currentVisibleMenu = null;

function hideShow(showId) {
    const selectors = ['.searchMenu', '.showMenu', '.addMenu', '.updateMenu', '.deleteMenu'];
    if (currentVisibleMenu === showId) {
        console.log("Currently visible: " + currentVisibleMenu);
        hideMenu(showId);
        currentVisibleMenu = null;
    } else {
        selectors.forEach(selector => {
            hideMenu(selector);
        });
        console.log("Showing: " + showId);
        currentVisibleMenu = showId;
        showMenu(showId);
    }
}

function showMenu(selector) {
    var menuElements = document.querySelectorAll(selector);
    if (menuElements.length > 0) {
        menuElements.forEach(function (element) {
            element.style.display = "block";
        });
    }
}

function hideMenu(selector) {
    var menuElements = document.querySelectorAll(selector);
    if (menuElements.length > 0) {
        menuElements.forEach(function (element) {
            element.style.display = "none";
        });
    }
}

function hideAll() {
    const selectors = ['.searchMenu', '.showMenu', '.addMenu', '.updateMenu', '.deleteMenu'];
    selectors.forEach(selector => {
        hideMenu(selector);
    });
    console.log("Hide all");
}
