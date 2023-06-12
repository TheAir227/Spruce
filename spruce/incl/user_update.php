<?php
if (isset($_SESSION['uid'])) {
    $user = $database->query("SELECT * FROM `users` WHERE `id`=" . $_SESSION['uid'])->fetch(2);
    
} else {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}

?>

<!-- Редактирование пользователя -->
<div class="container">
    <form action="actions/update_user.php" method="POST" class="form" enctype="multipart/form-data">
        <h2>Редактирование</h2>
        <input type="email" value="<?= $user['email'] ?>" name="email" placeholder="Почта">
        <input type="text" value="<?= $user['name'] ?>" name="name" placeholder="Имя">
        <input type="text" value="<?= $user['surname'] ?>" name="surname" placeholder="Фамилия">
        <input type="date" value="<?= $user['date'] ?>" name="date" placeholder="Дата рождения">
        <input type="text" value="<?= $user['phone'] ?>" name="phone" placeholder="Номер телефона">
        <input type="file" name="avatar">
        <input type="hidden" value="<?= $user['avatar'] ?>" name="image">
        <input type="submit" name="user_update" class="btn" value="Редактировать">

        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo '<div class="modal_error">' . $error . '</div>';
                unset($_SESSION['errors']);
                break;
            }
        }

        ?>
    </form>
</div>
<!-- Редактирование пользователя -->