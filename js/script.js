$(document).ready(function (e) {
    getMessages();

    $('#sendBtn').click(function () {
        sendMessage();
    });
    setInterval(function () {
        getMessages()
    }, 1000);
});

function getMessages() {

    $.ajax({
        url: "chatroom-handler.php",
        type: "POST",
        dataType: "xml",
        data: {action: "get"},
        timeout: 3000,
        success: function (data) {

            // display messages coming from handler
            var htmlContent = "";

            $(data).find('allMessages')
                .children()
                .each(function () {
                    var data = '<article>';
                    var msg = $(this).find('content').text();
                    var nick = $(this).find('nick').text();
                    var time = $(this).find('date').text();

                    data += "<strong>" + nick + "</strong>&nbsp; (" + time + ") <p class='message'>" + msg + "</p></article>";

                    htmlContent += data;

                });

            $('#messages').html(htmlContent);
        }
    })
}

function sendMessage() {

    var msg = $('#msgBox').val();
    $.ajax({
        url: "chatroom-handler.php",
        type: "POST",
        dataType: "text",
        data: {action: "send", m: msg},
        timeout: 3000,
        success: function (data) {

            if (data == "error") {
                alert("Your message couldn't send");
                return;
            }
            $('#msgBox').val(""); // remove all message from message box you put
            getMessages();
        }
    })

}