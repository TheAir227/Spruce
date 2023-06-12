<?php 
session_start();
require('../incl/functions.php');
require('../incl/connect.php');
if(isset($_GET['piece'])){
    if(isAuth()){
        $id_piece = $_GET['piece'];
        $id_user = $_SESSION['uid'];
        $state = $database->prepare("INSERT INTO `orders`(`id_piece`, `id_user`) VALUES ('$id_piece','$id_user')");
        $state->execute();
        header("Location: /?page=profile");
        die();
    }
    else{
        header("Location: /?page=auth");
        die();
    }
}
header("Location: /?page=main");
die();

?>