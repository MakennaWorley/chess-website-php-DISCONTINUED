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

});

//------------------------------------------------------------------------------hide/show-----------------------------//
let currentVisibleMenu = null;

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