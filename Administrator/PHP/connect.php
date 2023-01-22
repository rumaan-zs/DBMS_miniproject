<?php
//String connection to the database
$link = mysqli_connect("localhost","root","") or die ('<h2>Failed to connect to the web server. Please Check your web server!</h2>');
mysqli_select_db($link,"dbmis") or die ('<h2>Failed to connect to the database!</h2>');
?>