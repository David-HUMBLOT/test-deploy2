<?php  




//connection en local
// $host = "localhost";
// $login = "root";
// $pwd = "";
// $db = "culturel";

// connection en ligne (heroku bdd mysql)
$host = "eu-cdbr-west-03.cleardb.net";
$login = "ba707d338cd120";
$pwd = "00cbd8e5";
$db = heroku_e725779b43b3b92;

// connexion à la BDD
$db_connect = mysqli_connect($host, $login, $pwd, $db);


// $db_host = 'localhost';
// $db_user = 'root';
// $db_password = 'root';
// $db_db = 'information_schema';
// $db_port = 8889;

// $db_connect = new mysqli(
//     $host,
//     $login,
//     $pwd,
//     $db
// );
	
if ($db_connect->connect_error) {
    echo 'Errno: '.$db_connect->connect_errno;
    echo '<br>';
    echo 'Error: '.$db_connect->connect_error;
    exit();
}

else{
    echo 'Connection à la bdd réussi';
    echo '<br>';
    echo 'Host information: '.$db_connect->host_info;
    echo '<br>';
    echo 'Protocol version: '.$db_connect->protocol_version;
    
    $db_connect->close();
}




?>