<?php
  $db_host = 'localhost';
  $db_user = 'writers';
  $db_password = 'writers';
  $db_db = 'my_elusive';
 
  $mysqli = @new mysqli($db_host, $db_user, $db_password, $db_db);
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL eLusive was made.';
  echo '<br>';
  echo 'Host information: '.$mysqli->host_info;
  echo '<br>';
  echo 'Protocol version: '.$mysqli->protocol_version;

  //$mysqli->close();
?>