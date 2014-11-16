<?php
session_start();

if (isset($_POST['nick'])) {
    $_SESSION['nickname'] = $_POST['nick'];
}

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <title>Quick Chat Room</title>
    <link href="css/style.css" rel="stylesheet">

</head>

    <body>

    <?php if (!isset($_SESSION['nickname'])) {
        // user for start joining from now 
        ?>

        <div class="login-wrapper">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <p class="login-title">Put your nickname :)</p>
                <input type="text" name="nick" placeholder="Nickname.." required/>
                <input type="submit" value="Go Chatbox"/>
            </form>
        </div>

    <?php
    // user already have a nickname so display chatbox
    } else {
    ?>

        <div class="wrapper">

            <h1 class="title">Hi,<?php echo $_SESSION['nickname'];?> Let's Chat :)
                <a href="logout-handler.php" class="logoutBtn">X</a>
            </h1>

            <div id="messages"></div>
            <textarea id="msgBox" placeholder="Type your message.."></textarea>
            <input type="button" id="sendBtn" value="Send"/>

        </div>

        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="js/script.js"></script>

    <?php } // closing else statement for logged in user
    ?>

    </body>
</html>

