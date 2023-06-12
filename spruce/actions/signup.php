<?php
session_start();
unset($_SESSION['errors']);
if (isset($_POST['signup'])) {
    require('../incl/connect.php');

    unset($_SESSION['errors']);

    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $date = htmlspecialchars($_POST['date']);
    $password = htmlspecialchars($_POST['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    // Проверка на пустые поля
    if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['date']) || empty($_POST['password']) || empty($_POST['re_password'])) {
        $_SESSION['errors'][] = "Заполните все поля";
    }

    // Проверка на наличие пользователя
    $checkUser = $database->query("SELECT * FROM `users` WHERE `email`='$email'")->fetch(2);
    if (!empty($checkUser)) {
        $_SESSION['errors'][] = $email . "Пользователь уже существует";
    }

    // Проверка на совпадение паролей
    if ($password != $_POST['re_password']) {
        $_SESSION['errors'][] = "Пароли не совпадают";
    }
    // Проверка на длинну пароля
    if (strlen($password) < 6) {
        $_SESSION['errors'][] = "Пароль должен быть больше 6 символов";
    }

    $birthdate = new DateTime($date); // преобразуем дату в объект DateTime
    $currentdate = new DateTime(); // текущая дата
    $age = $birthdate->diff($currentdate)->y; // вычисляем разницу в годах между датами
    if ($age < 16) {
        $_SESSION['errors'][] = "Вы должны быть старше 16 лет. Приходите завтра.";
    }





    if (empty($_SESSION['errors'])) {
        $sql = "INSERT INTO `users`(`name`, `surname`, `email`, `password`, `date`) VALUES ('$name','$surname','$email','$password_hash','$date')";
        $state = $database->prepare($sql);
        $state->execute();
        $_SESSION['uid'] = $database->lastInsertId();
        header("Location: /?page=profile");
        die();
    } else {
        header("Location: /?page=registration");
        die();
    }


} else {
    header("Location: /?page=registration");
    die();
}




?>