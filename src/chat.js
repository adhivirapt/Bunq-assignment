//POST REQUEST
var urlParams
var user1
var user2

$(document).ready(function () {
    urlParams = new URLSearchParams(window.location.search);
    user1 = urlParams.get('username1');
    user2 = urlParams.get('username2');
    setInterval(getMessages, 3000)
    $('#postMessage').click(function (e) {
        e.preventDefault();
        //pass serialized data to function
        var data = {
            user_1: user1,
            user_2: user2,
            message: document.getElementById("message").value,
        }
        postMessage(data)

    });
});
function postMessage(data) {
    $.ajax({
        type: "POST",
        url: "http://192.168.64.2/php_rest/api/create.php",
        data: JSON.stringify(data),
        ContentType: "application/json",

        success: function () {
            getMessages();
        },
        error: function (err) {
            alert(JSON.stringify(err));
        }

    });
}

function getMessages() {
    $.ajax({
        url: "http://192.168.64.2/php_rest/api/read.php",
        type: "get", //send it through get method
        data: {
            user_1: user1,
            user_2: user2,
        },
        success: function (req) {
            var json = req;
            var html = "";

            //loop and display data
            json.forEach(function (val) {
                var keys = Object.keys(val);

                if (val.user_1 === user1) {
                    html += "<h2>" + user1 + ":" + val.message + "</h2> ";
                } else {
                    html += "<h3>" + user2 + ":" + val.message + "</h3> ";
                }
                html += "</div>";
            });

            //append in message class
            document.getElementsByClassName('message')[0].innerHTML = html;
        },
        error: function (xhr) {
            alert(e)
        }

    })
}