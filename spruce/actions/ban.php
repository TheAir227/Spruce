<?php 
session_start();
require('../incl/functions.php');
require('../incl/connect.php');
if(isAdmin(isAuth())){
    $user_id = $_GET['user_id'];
    $user = $database->query("SELECT * FROM `users` WHERE `id`='$user_id'")->fetch(2);
    if($user['ban'] == 0){
        $state = $database->prepare("UPDATE `users` SET `ban`='1' WHERE `id`='$user_id'");
    }
    if($user['ban'] == 1){
        $state = $database->prepare("UPDATE `users` SET `ban`='0' WHERE `id`='$user_id'");
    }
    $state->execute();
    header("Location: /?page=admin");
    die();
}
else{
    header("Location: /");
    die();
}

?>