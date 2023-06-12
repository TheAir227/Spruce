<?php
session_start();
unset($_SESSION['errors']);
if (isset($_POST['signin'])) {
    require('../incl/connect.php');

    unset($_SESSION['errors']);

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);


    // Проверка на пустые поля
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['errors'][] = "Заполните все поля";
    }

    // Проверка на наличие пользователя
    $checkUser = $database->query("SELECT * FROM `users` WHERE `email`='$email'")->fetch(2);
    if (empty($checkUser)) {
        $_SESSION['errors'][] = $email . " Пользователя не существует";
    }




    // Проверка на совпадение паролей
    if (!password_verify($password, $checkUser['password'])) {
        $_SESSION['errors'][] = "Неверный логин или пароль";
    }

    // Проверка на бан
    if ($checkUser['ban'] == '1') {
        $_SESSION['errors'][] = "Вы заблокированы администратором";
    }


    if (empty($_SESSION['errors'])) {
        $_SESSION['uid'] = $checkUser['id'];
        header("Location: /?page=profile");
        die();
    } else {
        header("Location: /?page=auth");
        die();
    }


} else {
    header("Location: /?page=auth");
    die();
}




?>