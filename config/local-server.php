<?php  

// connexion à la BDD
// $db_connect = mysqli_connect($host, $login, $pwd, $db);

$host = "localhost";
$login = "root";
$pwd = "";
$db = "culturel";


// $db_host = 'localhost';
// $db_user = 'root';
// $db_password = 'root';
// $db_db = 'information_schema';
// $db_port = 8889;

$db_connect = new mysqli(
    $host,
    $login,
    $pwd,
    $db
);
	
if ($db_connect->connect_error) {
    echo 'Errno: '.$db_connect->connect_errno;
    echo '<br>';
    echo 'Error: '.$db_connect->connect_error;
    exit();
}

else{
    // echo 'Connection à la bdd réussi';
    // echo '<br>';
    // echo 'Host information: '.$db_connect->host_info;
    // echo '<br>';
    // echo 'Protocol version: '.$db_connect->protocol_version;
    
    // $db_connect->close();
}




?>