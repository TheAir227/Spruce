<?php 
session_start();
require('../incl/functions.php');
require('../incl/connect.php');
if(isAdmin(isAuth())){
    $user_id = $_GET['user_id'];
    $state = $database->prepare("DELETE FROM `users` WHERE `id` = '$user_id'");
    $state->execute();
    header("Location: /?page=admin");
    die();
}
else{
    header("Location: /");
    die();
}

?>