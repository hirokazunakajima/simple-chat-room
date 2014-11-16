<?php
session_start();


if(isset($_POST['action']))
{

    include("includes/mysql-functions.php");
    connect_db();

	// retrieving last 10 messages from database and return as XML
	if($_POST['action']=="get") 
	{
		$sql = "SELECT * FROM messages ORDER BY msg_id DESC LIMIT 10";
		if($result = query($sql))
		{
			$content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
			$content .= "<allMessages>";
			
			while($row = mysqli_fetch_array($result))
			{
				$content .= "<msg>";
				$content .= "<content>".$row['content']."</content>";
				$content .= "<nick>".$row['user_nick']."</nick>";
				$content .= "<date>".date("h:i:s",strtotime($row['msg_date']))."</date>";
				$content .= "</msg>";
			}
			$content .= "</allMessages>";
			header("Content-Type: application/xml; charset=utf-8");
			echo $content;
		}
		else
		{
			$content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
			$content .= "<error><message>Query error</message></error>";
			header("Content-Type: application/xml; charset=utf-8");
			echo $content;
		}
	} // end for action=get
	else if($_POST['action']=="send" && isset($_POST['m']))
	{
		$msg = mysqli_real_escape_string($dblink, $_POST['m']);
		$ip = $_SERVER['REMOTE_ADDR']; // save ip address
		$nick = $_SESSION['nickname'];
		$sid = session_id(); // save current session's id
		
		$sql = "INSERT INTO messages (`content`,`user_nick`,`user_session`,`user_ip`) VALUES ('".$msg."','".$nick."','".$sid."','".$ip."')";
		if(query($sql))
		{
			echo "ok";
		}
		else
		{
			echo "error";
		}
	}
	
}

?>