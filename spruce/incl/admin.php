<?php
$users = $database->query("SELECT * FROM `users`")->fetchAll(2);

if (!isAdmin($_SESSION['uid'])) {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}
$user_id = $_SESSION['uid'];
$user = $database->query("SELECT * FROM `users` WHERE `id`='$user_id'")->fetch(2);

if (isset($_POST['status'])) {
    $status_state = $_POST['status_value'];
    $order_id = $_POST['order_id'];
    $state = $database->prepare("UPDATE `orders` SET `status`='$status_state' WHERE `id` = '$order_id'");
    $state->execute();
}


$category = $database->query("SELECT * FROM `categories`")->fetchAll(2);

if (isset($_POST['add_category'])) {
    unset($_SESSION['errors']);
    $category_name = htmlspecialchars($_POST['category_name']);
    $category_name = trim($category_name);
    if (empty($category_name)){
        $_SESSION['errors'][] = '<div class="modal_error2"> Пустое поле </div> ';
    }
    if (empty($_SESSION['errors'])) {
        $sql = "INSERT INTO `categories`(`name`) VALUE ('$category_name')";
        $state = $database->prepare($sql);
        $state->execute();
        echo '<meta http-equiv = "Refresh" content = "0 ; URL = http://spruce/?page=admin">';
        exit();
    }
}
$orders = $database->query("SELECT * FROM `orders` WHERE `status` = 'ожидание' ")->fetchAll(2);
?>
<div class="container">
    <div class="user">
        <?php if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo $error;
                break;
            }
        } ?>
        <div class="category">
            <form action="?page=admin" class="category-form" method="POST">
                <input type="text" name="category_name" placeholder="Категория">
                <input class="btn" name="add_category" type="submit">

            </form>

            <?php foreach ($category as $category_one): ?>
                <p>
                    <?= $category_one['name'] ?> <a href="/?page=del_cat&id=<?= $category_one['id']; ?>"><svg width="22"
                            height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 2L20 20" stroke="#DE8F6E" stroke-width="3" stroke-linecap="round" />
                            <path d="M20 2L2 20" stroke="#DE8F6E" stroke-width="3" stroke-linecap="round" />
                        </svg></a>
                </p>
            <?php endforeach; ?>



        </div>
        <?php if($orders): ?>
        <div class="zakaz">
            <h2>Заказы</h2>
            <div class="zakazs">

                <?php foreach ($orders as $order): ?>
                    <?php if($order['status'] == "ожидание"): ?>
                    <div class="zakaz-grid">
                        <?php

                        $piece_one = $order['id_piece'];
                        $product = $database->query("SELECT * FROM `tovars` WHERE `id`= '$piece_one'")->fetch(2);
                        $cat_order = $product['category'];
                        $category_name = $database->query("SELECT * FROM `categories` WHERE `id` = '$cat_order'")->fetch(2);
                        $id_user = $order['id_user'];
                        $user_order = $database->query("SELECT * FROM `users` WHERE `id` = '$id_user'")->fetch(2);
                        ?>
                        <p>Участок №
                            <?= $product['number'] ?>
                        </p>
                        <p>
                            Категория участка: <br>
                            <?= $category_name['name'] ?>
                        </p>
                        <p>
                            Имя пользователя: <br>
                            <?= $user_order['name'] ?>
                        </p>
                        <p>
                            Почта пользователя: <br>
                            <?= $user_order['email'] ?>
                        </p>
                        <form action="" method="POST">
                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                            <select name="status_value" id="">
                                <option value="ожидание" <?php if ($order['status'] == "ожидание")
                                    echo 'selected' ?>>ожидание
                                    </option>
                                    <option value="подтверждено" <?php if ($order['status'] == "подтверждено")
                                    echo 'selected' ?>>
                                        подтверждено</option>
                                    <option value="отклонено" <?php if ($order['status'] == "отклонено")
                                    echo 'selected' ?>>
                                        отклонено</option>
                                </select>



                                <input type="submit" name="status" class="ok" value="подтвердить">
                            </form>

                        </div>
                        <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
        <?php endif; ?>
        <div class="zakaz">
            <h2>Пользователи</h2>
            <div class="zakazs">
                <?php foreach ($users as $user): ?>
                    <?php if($user['id'] != $_SESSION['uid']): ?>
                    <div class="users-grid">
                        <p>id:
                            <?= $user['id'] ?>
                        </p>
                        <p>
                            Имя пользователя: <br>
                            <?= $user['name'] ?>
                        </p>
                        <p>
                            Телефон пользователя: <br>
                            <?= $user['phone'] ?>
                        </p>
                        <p>
                            Почта пользователя: <br>
                            <?= $user['email'] ?>
                        </p>
                        <a href="actions/delete_user.php?user_id=<?= $user['id'] ?>">Удалить</a>
                        <?php if ($user['ban'] == '0'): ?>
                            <a href="actions/ban.php?user_id=<?= $user['id'] ?>">Заблокировать</a>
                        <?php endif; ?>
                        <?php if ($user['ban'] == '1'): ?>
                            <a href="actions/ban.php?user_id=<?= $user['id'] ?>">Разблокировать</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>