<?php 
if(empty($_SESSION['uid'])){
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
        exit();
}



$user_id = $_SESSION['uid'];
$orders = $database->query("SELECT * FROM `orders` WHERE `id_user`='$user_id'")->fetchAll(2);

$user = $database->query("SELECT * FROM `users` WHERE `id`='$user_id'")->fetch(2);
?>
    <div class="container">
        <div class="user">
            <div class="user-info">
                <div class="avatar"><img src="<?= $user['avatar'] ?>" alt=""></div>
                <div class="user-text">
                    <h2><span>Здравствуйте, </span>  <?= $user['name'] . ' ' . $user['surname'] ?>!</h2>
                    <p><b>Дата рождения:</b> <?= $user['date'] ?></p>
                    <p><b>Почта:</b> <?= $user['email'] ?></p>
                    <p><b>Телефон:</b> <?= $user['phone'] ?></p>
                    <a href="?page=user_update" class="btn">редактировать</a>
                </div>
            </div>
            <div class="zakaz">
                <h2>Заказы</h2>
                <div class="zakazs">
                    <?php foreach($orders as $order): ?>
                    <div class="zakaz-grid">
                        <?php $piece_one = $order['id_piece']; 
                        $product = $database->query("SELECT * FROM `tovars` WHERE `id`= '$piece_one'")->fetch(2);
                        $cat_id = $product['category'];
                        $categories = $database->query("SELECT * FROM `categories` WHERE `id`= '$cat_id'")->fetch(2); ?>
                        <a href="?page=item&product_id=<?= $product['id']; ?>">Посмотреть заказ</a>
                        <p>Категория участка: <?= $categories['name']; ?> </p>
                        <p>Участок №<?=  $product['number']; ?></p>
                        <p>Стоимость: <?=  $product['price']; ?> ₽</p>
                        <?php if($order['status'] == "отклонено"): ?>
                        <span class="status_red"><?= $order['status']; ?></span>
                        <?php endif; ?>
                        <?php if($order['status'] == "ожидание"): ?>
                        <span class="status_black"><?= $order['status']; ?></span>
                        <?php endif; ?>
                        <?php if($order['status'] == "подтверждено"): ?>
                        <span class="status_green"><?= $order['status']; ?></span>
                        <?php endif; ?>
                        
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
   