<?php 

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
    $product = $database->query("SELECT * FROM `tovars` WHERE id='$product_id'")->fetch(2);
    $product_category = $product['category'];
    $category_one = $database->query("SELECT `name` FROM `categories` WHERE id='$product_category'")->fetch(2);
    if($_GET['product_id'] != $product['id']){
        echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
        exit();
    }
} 
else{
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}




?>

    <div class="container">
        <div class="one-item">
            <div class="one-item-img">
                <a href="<?= $product['image'] ?>" target="_blank">
                    <img src="<?= $product['image'] ?>" alt="">
                </a>
            </div>
            <div class="one-item-text">
                <h2>  <?= $category_one['name'] . ' №' . $product['number']  ?>  </h2>
                <p>Участок <?=$product['weaving'] ?> соток</p>
                <p><?=$product['about'] ?></p>
                <div class="obustr">
                    <?php if($product['water'] == true): ?>
                    <div class="obustr-item">
                        <img src="media/images/add/water.png" alt="">
                        <span>Проведен водопровод</span>
                    </div>
                    <?php  endif;?>
                    <?php if($product['gas'] == true): ?>
                    <div class="obustr-item">
                        <img src="media/images/add/fire.png" alt="">
                        <span>Проведен газ</span>
                    </div>
                    <?php endif; ?>
                    <?php if($product['energy'] == true): ?>
                    <div class="obustr-item">
                        <img src="media/images/add/energy.png" alt="">
                        <span>Проведено электричество</span>
                    </div>
                    <?php endif; ?>
                </div>
                <span><b><?=$product['price'] ?></b> ₽</span>
                <div class="one-item-btns">
                    <a href="../actions/order.php?piece=<?=$product['id'] ?>" class="btn">Купить</a>
                    <?php if(isAdmin(isAuth())): ?>
                    <a href="?page=update&product_id=<?= $product_id ?>" class="btn">Редактировать</a>
                    <a href="?page=delete&product_id=<?= $product_id ?>" class="btn">Удалить</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

