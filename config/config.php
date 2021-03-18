<?php  
session_start();

//connection bdd en local
// $host = "localhost";
// $login = "root";
// $pwd = "";
// $db = "culturel";
// connection en ligne (heroku bdd mysql)

// connection bdd en ligne
// $host = "eu-cdbr-west-03.cleardb.net";
// $login = "ba707d338cd120";
// $pwd = "00cbd8e5";
// $db = "heroku_e725779b43b3b92";
// connexion à la BDD
$db_connect = mysqli_connect($host, $login, $pwd, $db);
?>