<?php
session_start();
unset($_SESSION['errors']);
if (isset($_POST['user_update'])) {
    unset($_SESSION['errors']);
    require('../incl/connect.php');
    require('../incl/functions.php');

    unset($_SESSION['errors']);

    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $date = htmlspecialchars($_POST['date']);
    $phone = htmlspecialchars($_POST['phone']);

    $email = trim($email);
    $name = trim($name);
    $surname = trim($surname);
    $date = trim($date);
    $phone = trim($phone);

    if(empty($phone)){
        $phone = 0;
    }

    if ($_FILES['avatar']['size'] > 0) {
        $avatar = uploadFile($_FILES['avatar'], $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'public');
    } else {
        $avatar = $_POST['image'];
    }


    // Проверка на пустые поля
    if (empty($email) || empty($name) || empty($surname) || empty($date)) {
        $_SESSION['errors'][] = "Заполните все поля";
    }

    if(strlen($phone) > 12){
        $_SESSION['errors'][] = "Телефон не может содержать больше 12 символов";
    }
    if(!is_numeric($phone)){
        $_SESSION['errors'][] = "Телефон не может содержать буквы";
    }

    if (empty($_SESSION['errors'])) {
        $sql = "UPDATE `users` SET `name`='$name ',
            `surname`='$surname',
            `email`='$email',
            `avatar`='$avatar',
            `phone`='$phone',
            `date`='$date' WHERE `id` =" . $_SESSION['uid'];
        $state = $database->prepare($sql);
        $state->execute();
        header("Location: /?page=profile");
        die();
    }
    header("Location: /?page=user_update");
    die();


} else {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}


?>