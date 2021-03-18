<?php
// Connection admin et vérification des informations de connection en bdd
//Initialisation des variables
$email = "";
$password = "";
$auth = "0";
$update = "false";
$errors = array();
$success = array();
//Si je clique sur le bouton de connection
if (isset($_POST['connect-admin'])) {
    connectAdmin($_POST);
}
//Si je clique sur le bouton de déconnection
if (isset($_GET['disconnect-admin'])) {
    disconnectAdmin($GET);
}
// Si je clique sur le bouton ajouter un utilisateur
if (isset($_POST['register-user'])) {
    registerUser($_POST);
}
// Si je clique sur le bouton ajouter un ordinateur
if (isset($_POST['register-computer'])) {
    registerComputer($_POST);
}
// Si je clique sur le bouton ajouter une attribution
if (isset($_POST['register-attribution'])) {
    registerAttribution($_POST);
}
// si je clique sur l'icône modifier un utilisateur
if (isset($_GET['edit-user'])) {
    $update = true;
    $user_id = $_GET['edit-user'];
    editUser($user_id);
}
// si je clique sur l'icône modifier un ordinateur
if (isset($_GET['edit-computer'])) {
    $update = true;
    $computer_id = $_GET['edit-computer'];
    editComputer($computer_id);
}
// si je clique sur l'icône modifier une attribution
if (isset($_GET['edit-attribution'])) {

    $update = true;
    $attribution_id = $_GET['edit-attribution'];
     $userAttributions = readUserAtt($attribution_id);
    editAttribution($attribution_id);
   
}

//si je clique sur le bouton mettre a jour un utilisateur
if (isset($_POST['update-user'])) {
    updateUser();
}
//si je clique sur le bouton mettre a jour un ordinateur
if (isset($_POST['update-computer'])) {
    updateComputer();
}
//si je clique sur le bouton mettre a jour un ordinateur
if (isset($_POST['update-attribution'])) {
    updateAttribution();
}

//si je clique sur l'icone pr supprimer une attribution
if (isset($_GET['delete-attribution'])) {
    $attribution_id = $_GET['delete-attribution'];
    $update = true;
    deleteAttribution($attribution_id);
}
//si je clique sur l'icone pr supprimer un ordinateur
if (isset($_GET['delete-computer'])) {
    $computer_id = $_GET['delete-computer'];
    $update = true;
    deleteComputer($computer_id);
}

//si je clique sur l'icone pr supprimer un utilisteur
if (isset($_GET['delete-user'])) {
    $user_id = $_GET['delete-user'];
    $update = true;
    deleteUser($user_id);
}

// FONCTION ajout d'ordinateur

function registerComputer()
{
    global $log;
    global $db_connect, $errors, $success, $number;
    $number = htmlentities(($_POST['number']));
    if (empty($number)) {
        array_push($errors, "Veuillez choisir un numéro de post");
    }
    if ($number > 15 || $number < 0) {
        array_push($errors, "Veuillez choisir un numéro de post compris entre 1 et 15");
    }
    //on vérifie si un poste n'est pas déjà créer avec le même numéro de Post informatique
    $sql = "SELECT * FROM computers";
    $query = $db_connect->query($sql);
    $computers = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($computers)) {
        foreach ($computers as $key => $computer) {
            if ($computer['numbers'] === $number) {
                array_push($errors, "Ce numéro de post est déjà attribué");
            }
        }
    }
    if (count($errors) == 0) {
        $etat = "0";
        $sql = "INSERT INTO `computers` (numbers, etat,  created) VALUES ( '$number', '$etat', now() )";
        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Ajout de l'ordinateur réussi");
    }
}

// FONCTION ajout utilisateur

function registerUser()
{
    global $log;
    global $db_connect, $errors, $success, $last_name,  $first_name, $email, $phone;
    $last_name = htmlentities(trim(ucwords(strtolower($_POST['last_name']))));
    $first_name = htmlentities(trim(ucwords(strtolower($_POST['first_name']))));
    $email = trim($_POST['email']);
    $password_1 = trim($_POST['password_1']);
    $password_2 = trim($_POST['password_2']);
    $phone = htmlentities(($_POST['phone']));
    if (empty($last_name)) {
        array_push($errors, "Entrer votre nom");
    }
    if (empty($first_name)) {
        array_push($errors, "Entrer votre prenom");
    }
    if (empty($email)) {
        array_push($errors, "Entrer une adresse mail");
    }
    if (empty($password_1)) {
        array_push($errors, "Vous avez oublié le mot de passe");
    }
    if (empty($phone)) {
        array_push($errors, "Inscrire un numéro de téléphone");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Les deux mots de passe ne correspondent pas");
    }
    //On vérifie si le compte n'existe pas en bdd (éviter les doublons en bdd)
    $sql = "SELECT * FROM users";
    $query = $db_connect->query($sql);
    $users = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($users)) {
        foreach ($users as $key => $user) {
            if ($user['email'] === $email) {
                array_push($errors, "Email déjà existant");
            }
        }
    }
    if (count($errors) == 0) {
        $password_hash = password_hash($password_2, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (first_name, last_name, email, password, phone, created) VALUES ( '$first_name','$last_name', '$email', '$password_hash', '$phone', now() )";
        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Ajout utilisateur réussi");
        // $log->log('inscription', 'validation_inscription', "Fonction registerUser() : l'inscription a réussi", Log::FOLDER_MONTH); 
        // header('location: ./login.php');
    } else {
        // $log->log('inscription', 'err_inscription', "Fonction registerUser() : l'inscription a échoué", Log::FOLDER_MONTH);
    }
}


// FONCTION ajout d'ordinateur

function registerAttribution()
{
    global $log;
    global $db_connect, $errors, $success, $user_select, $computer_select, $date_select;
    $user_select = htmlentities(($_POST['user-select'])); //value de id users recupérer 
    $computer_select = htmlentities(($_POST['computer-select'])); //value de id pc recupérer 
    $date_select = ($_POST['date-select']);

    if (empty($user_select)) {
        array_push($errors, "Veuillez choisir un utilisateur disponible");
    }
    if (empty($computer_select)) {
        array_push($errors, "Veuillez choisir un post disponible");
    }
    if (empty($date_select)) {
        array_push($errors, "Veuillez choisir une date disponible");
    }
    if ($computer_select  < 0) {
        array_push($errors, "Veuillez choisir un numéro de post supérieur à 0");
    }
    //on vérifie si un poste n'est pas déjà attribuer à un utilisateuravec le même numéro de Post informatique
    $sql = "SELECT * FROM attributions";
    $query = $db_connect->query($sql);
    $attributions = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($attributions)) {
        foreach ($attributions as $key => $attribution) {
            //si on attibue à un nouvel utilisateur un meme pc sur un même crenaux déjà attribué à un autre utilisateur
            if (
                ($attribution['computer_id'] === $computer_select
                    && $attribution['crenaux']  === $date_select)
            ) {
                array_push($errors, "Ce PC est déjà attribué à un utilisateur à cette date. Choisissez un autre PC ou une autre date.");
            }
        }
    }
    if (count($errors) == 0) {
        $etat = "0";
        $sql = "INSERT INTO `attributions` (user_id, computer_id,  crenaux,  created) VALUES ( '$user_select', '$computer_select','$date_select', now() )";

        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Attribution réussi");
    }
}

// FONCTION CONNECTION ADMINISTRATEUR

function connectAdmin()
{
    global $log;
    global $db_connect, $errors, $success;
    //Sécurisation des saisies
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // Sécurisation des champs vides
    if (empty($email)) {
        array_push($errors, "Veulliez saisir une adresse email !");
    }
    if (empty($password)) {
        array_push($errors, "Mot de passe requis");
    }
    //On vérifie en bdd si les informations correspondent (ici pour l'email est trouver)
    $sql = "SELECT * FROM admins WHERE email = '$email' ";
    $res = $db_connect->query($sql);
    $rows = $res->num_rows;
    //Si un rélustats est trouvé en bdd
    if ($rows > 0) {
        //on récupère les informations trouvé avant de comparer
        $user = $res->fetch_array();
        //en bdd le mot de passe est déjà hasher du coup on utilise la function de vérification de mot de passe crypté en bdd
        if (password_verify($password, $user['password'])) {
            // echo 'mot de passe correct';
            //on stocke l'information id de l'admin en session
            $_SESSION['user']['id'] = $user['id'];
            //on modifi en bdd le booleen d'authentification de 0 à 1
            $sql = "UPDATE admins SET auth = 1 WHERE email = '$email'";
            $query = $db_connect->query($sql);
            //on stock l'état d'authentification (ATTENTION!! ne pas oublier de le remettre à zéro lors de la déconnection de l'administrateur)
            $_SESSION['user']['auth'] = 1;
            // array_push($succes, "Authentification réussie");
            //redirection sur l'espace administrateur pour la gestion du parc d'ordinateur
            header("Location: user-gestion.php");
        } else {
            array_push($errors, "Mot de passe incorrect");
        }
    } else {
        array_push($errors, " Accès non autorisé. Compte administrateur requis");
    }
}

// FONCTION DECONNECTION ADMINISTRATEUR

function disconnectAdmin()
{
    global $db_connect;
    $user_id = $_SESSION['user']['id'];
    $_SESSION['user']['auth'] = 1;
    //On remet l'état de connection auth sur 0 en bdd
    $sql = "UPDATE admins SET auth = 0 WHERE id = '$user_id' ";
    $query = $db_connect->query($sql);
    //on détruit la session et on vide les varibles de sessions
    session_destroy();
    unset($_SESSION['user']);
    //on redirige sur la page de bienvenue
    header('location: ../../../index.php');
}

//FONCTION READUSER

function readUsers()
{
    global $db_connect;
    $sql = "SELECT * FROM users";
    $query = $db_connect->query($sql);
    $users = $query->fetch_all(MYSQLI_ASSOC);
    return $users;
}
//FONCTION READUSER

function readComputers()
{
    global $db_connect;
    $sql = "SELECT * FROM computers";
    $query = $db_connect->query($sql);
    $computers = $query->fetch_all(MYSQLI_ASSOC);
    return $computers;
}

//FONCTION READ ATTRIBUTION

function readAttributions()
{
    global $db_connect;
    $sql = "SELECT * FROM attributions";
    $query = $db_connect->query($sql);
    $attributions = $query->fetch_all(MYSQLI_ASSOC);
    return $attributions;
}

//FINCTION edituser

function editUser($user_id)
{
    global $db_connect, $update, $role, $email, $user_id, $email, $phone, $first_name, $last_name;
    $sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
    $query = $db_connect->query($sql);
    $users = $query->fetch_array(MYSQLI_ASSOC);
    $first_name = $users['first_name'];
    $last_name = $users['last_name'];
    $email = $users['email'];
    $phone = $users['phone'];
}

//FONCTION editattribution

function editAttribution($attribution_id)
{
    global $db_connect, $update, $attribution_id, $user_select, $computer_select, $date_select;
    $update = true;
    $sql = "SELECT * FROM attributions WHERE id = $attribution_id LIMIT 1";
    $query = $db_connect->query($sql);
    $attributions = $query->fetch_array(MYSQLI_ASSOC);
    $user_select = $attributions['user_id'];
    $computer_select = $attributions['computer_id'];
    $date_select = $attributions['crenaux'];
}

function editComputer($computer_id)
{
    global $db_connect, $update, $number, $computers;
    $sql = "SELECT * FROM computers WHERE id = $computer_id LIMIT 1";
    $query = $db_connect->query($sql);
    $computers = $query->fetch_array(MYSQLI_ASSOC);
    $number = $computers['numbers'];
}

function updateUser()
{
    global $log;
    global $db_connect, $user_id, $errors, $success;
    $last_name = htmlentities(trim(ucwords(strtolower($_POST['last_name']))));
    $first_name = htmlentities(trim(ucwords(strtolower($_POST['first_name']))));
    $email = trim($_POST['email']);
    $password_1 = trim($_POST['password_1']);
    $password_2 = trim($_POST['password_2']);
    $phone = htmlentities(($_POST['phone']));
    if (empty($last_name)) {
        array_push($errors, "Entrer votre nom");
    }
    if (empty($first_name)) {
        array_push($errors, "Entrer votre prenom");
    }
    if (empty($email)) {
        array_push($errors, "Entrer une adresse mail");
    }
    if (empty($password_1)) {
        array_push($errors, "Vous avez oublié le mot de passe");
    }
    if (empty($phone)) {
        array_push($errors, "Inscrire un numéro de téléphone");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Les deux mots de passe ne correspondent pas");
    }
    //On vérifie si le compte n'existe pas en bdd (éviter les doublons en bdd)
    $sql = "SELECT * FROM users";
    $query = $db_connect->query($sql);
    $users = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($users)) {
        foreach ($users as $key => $user) {
            if ($user['email'] === $email) {
                array_push($errors, "Email déjà existant");
            }
        }
    }
    if (count($errors) == 0) {
        $user_id = $_POST['user_id'];
        $password_hash = password_hash($password_2, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password_hash', phone = '$phone' , update_at = now() WHERE id = '$user_id' LIMIT 1";
        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Mise à jour utilisateur réussi");
        // $log->log('inscription', 'validation_inscription', "Fonction registerUser() : l'inscription a réussi", Log::FOLDER_MONTH); 
        // header('location: ./login.php');
    } else {
        // $log->log('inscription', 'err_inscription', "Fonction registerUser() : l'inscription a échoué", Log::FOLDER_MONTH);
    }
}
// FONCTION modification d'ordinateur
function updateComputer()
{
    global $log;
    global $db_connect, $errors, $success, $computer_id, $etat;
    $number = htmlentities(($_POST['number']));
    if (empty($number)) {
        array_push($errors, "Veuillez choisir un numéro de post");
    }
    if ($number > 15 || $number < 0) {
        array_push($errors, "Veuillez choisir un numéro de post compris entre 1 et 15");
    }
    //on vérifie si un poste n'est pas déjà créer avec le même numéro de Post informatique
    $sql = "SELECT * FROM computers";
    $query = $db_connect->query($sql);
    $computers = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($computers)) {
        foreach ($computers as $key => $computer) {
            if ($computer['numbers'] === $number) {
                array_push($errors, "Ce numéro de post est déjà attribué");
            }
        }
    }
    if (count($errors) == 0) {
        $computer_id = $_POST['computer_id'];
        $etat = "0";
        $sql = "UPDATE  `computers` SET numbers = '$number' ,  update_at = now() WHERE id = '$computer_id' LIMIT 1 ";
        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Modification de l'ordinateur réussi");
    }
}

// FONCTION modification d'ordinateur
function updateAttribution()
{
    global $log;
    global $db_connect, $errors, $success, $attribution_id;
   
    // $attribution_id_verif = $attribution_id;
    $user_select = htmlentities(($_POST['user-select'])); //value de id users recupérer 
    $computer_select = htmlentities(($_POST['computer-select'])); //value de id pc recupérer 
    $date_select = ($_POST['date-select']);
  

    if (empty($user_select)) {
        array_push($errors, "Veuillez choisir un utilisateur disponible");
    }
    if (empty($computer_select)) {
        array_push($errors, "Veuillez choisir un post disponible");
    }
    if (empty($date_select)) {
        array_push($errors, "Veuillez choisir une date disponible");
    }
    if ( $computer_select < 0) {
        array_push($errors, "Veuillez choisir un numéro de post supérieur à 0");
    }

    //on vérifie si un poste n'est pas déjà attribuer à un utilisateuravec le même numéro de Post informatique
    $sql = "SELECT * FROM attributions";
    $query = $db_connect->query($sql);
    $attributions_verif = $query->fetch_all(MYSQLI_ASSOC);
    if (is_array($attributions_verif)) {
        foreach ($attributions_verif as $key => $attribution_verif) {
            //si on attibue à un nouvel utilisateur un meme pc sur un même crenaux déjà attribué à un autre utilisateur
            if (
                ($attribution_verif['computer_id'] === $computer_select
                    && $attribution_verif['crenaux']  === $date_select)
            ) {
                array_push($errors, "Ce PC est déjà attribué à un utilisateur à cette date. Choisissez un autre PC ou une autre date.");
            }
        }
    }


    if (count($errors) == 0) {
        $attribution_id = $_POST['attribution_id'];
        $sql = "UPDATE  `attributions` SET user_id = '$user_select', computer_id = '$computer_select' , crenaux = '$date_select',  update_at = now()  WHERE computer_id = '$attribution_id' LIMIT 1 ";
        $req = $db_connect->prepare($sql); //preparation de la requete
        $req->execute(); //execution de la requete
        // $query = $db_connect->query($sql);
        array_push($success, "Modification de d'attribution réussi");
    }
}

//fonction delete user good
function deleteUser($user_id)
{
    global  $db_connect, $log, $user_id, $success;
    // requete de suppression 
    $reqt = "DELETE FROM users WHERE id = '$user_id' LIMIT 1 "; //supprime la ligne du compte en repérant l id en bdd en fontion de l id de session . L id de session est stocker dans la varaible $delete_id_user.
    $reqUpdate = $db_connect->prepare($reqt); //preparation de la requete
    $reqUpdate->execute(); //execution de la requete
    array_push($success, "Suppression utilisateur réussi");
}

//fonction delete computer good
function deleteComputer($computer_id)
{
    global  $db_connect, $log, $computer_id, $success;
    $reqt = "DELETE FROM computers WHERE id = '$computer_id' LIMIT 1 ";
    $reqUpdate = $db_connect->prepare($reqt); //preparation de la requete
    $reqUpdate->execute(); //execution de la requete
    array_push($success, "Suppression de l'ordinateur réussi");
}

//fonction delete attribution good
function deleteAttribution($attribution_id)
{
    global  $db_connect, $log, $attribution_id, $success;
    $reqt = "DELETE  FROM attributions WHERE computer_id = '$attribution_id' ";
    $reqUpdate = $db_connect->prepare($reqt); //preparation de la requete
    $reqUpdate->execute(); //execution de la requete
    array_push($success, "Suppression de l'attribution réussi");
}

// fonction de lecture par jointure
function readAttributionJointure()
{
    global $db_connect;
    $sql = " SELECT * FROM attributions INNER JOIN users ON attributions.user_id = users.id INNER JOIN computers ON attributions.computer_id = computers.id  ";
    $query = $db_connect->query($sql);
    $attributions_jointure_user = $query->fetch_all(MYSQLI_ASSOC);
    return   $attributions_jointure_user;
}


function readUserAtt()
{
    global $db_connect, $attribution_id;
   //   888888888888888888888
//    $sql = " SELECT users.first_name FROM users INNER JOIN attributions  on  attributions.user_id = users.id  WHERE attributions.computer_id = $attribution_id  AND INNER JOIN attributions on computers.id = attributions.computer_id  ";
 
   $sql = " SELECT * FROM attributions INNER JOIN users ON attributions.user_id = users.id  WHERE attributions.computer_id = $attribution_id limit 1 ";

   $query = $db_connect->query($sql);
   $userAttributions = $query->fetch_all(MYSQLI_ASSOC);

 foreach ( $userAttributions as $key =>   $userAttribution) :

    $userAtt = $userAttribution['first_name'];
    $userCrenaux = $userAttribution['crenaux'];

  
 endforeach;
   
 return $userAtt;
 return   $userAttributions;
 return $userCrenaux;

}


 