<?php
if (isAdmin(isAuth())) {
    $update_id = $_GET['product_id'];
    if (isset($_POST['update'])) {
        $number = htmlspecialchars($_POST['number']);
        $about = htmlspecialchars($_POST['about']);
        $price = htmlspecialchars($_POST['price']);
        $weaving = htmlspecialchars($_POST['weaving']);
        $category_add = htmlspecialchars($_POST['category']);

        $number = trim($number);
        $about = trim($about);
        $price = trim($price);
        $weaving = trim($weaving);
        $category_add = trim($category_add);

        if ($_FILES['userfile']['size'] > 0) {
            $userfile = uploadFile($_FILES['userfile'], $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'public');
        } else {
            $userfile = $_POST['image'];
        }



        if (isset($_POST['water'])) {
            $water = 1;
        } else {
            $water = 0;
        }
        if (isset($_POST['gas'])) {
            $gas = 1;
        } else {
            $gas = 0;
        }
        if (isset($_POST['energy'])) {
            $energy = 1;
        } else {
            $energy = 0;
        }
        foreach ($_POST as $value) {
            if (empty($value)) {
                $_SESSION['errors'][] = "Заполните все поля";
            }
        }

        if(!is_numeric($number) || !is_numeric($price) || !is_numeric($weaving)){
            $_SESSION['errors'][] = "Поля \"номер участка\", \"цена\" и \" количество соток\" не могут содержать буквы";
        }

        if (empty($_SESSION['errors'])) {
            $sql = "UPDATE `tovars` SET `number`='$number',`weaving`='$weaving',`about`='$about',`water`='$water',`gas`='$gas',`energy`='$energy',`price`='$price',`category`='$category_add',`image`=' $userfile' WHERE `id`='$update_id'";
            $state = $database->prepare($sql);
            $state->execute();
            echo '<div class="complete"> Товар успешно отредактирован </div>';
        }
    }



    $update_item = $database->query("SELECT * FROM `tovars` WHERE `id` = '$update_id'")->fetch(2);
    $category = $database->query("SELECT * FROM `categories` ")->fetchAll(2);
} else {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}


?>
<!-- Редактирование -->
<div class="container">
    <form action="" method="POST" class="form" enctype="multipart/form-data">
        <h2>Редактирование</h2>
        <input type="text" name="number" value="<?= $update_item['number']; ?>" placeholder="Номер участка">
        <input type="text" name="about" value="<?= $update_item['about']; ?>" placeholder="Описание">
        <input type="text" name="price" value="<?= $update_item['price']; ?>" placeholder="Цена">
        <input type="hidden" name="image" value="<?= $update_item['image']; ?>">
        <img src="<?= $update_item['image']; ?>" width="100px" height="100px" style="object-fit:cover" alt="">
        <input type="file" name="userfile">
        <input type="text" name="weaving" value="<?= $update_item['weaving']; ?>" placeholder="Количество соток">
        <select name="category" id="">
            <?php foreach ($category as $category_one): ?>
                <option <?php if ($category_one['id'] == $update_item['category'])
                    echo 'selected'; ?>
                    value="<?= $category_one['id']; ?>"><?= $category_one['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <div class="label">
            <div class="checkbox">
                <input type="checkbox" name="water" <?php if ($update_item['water'] == 1)
                    echo 'checked'; ?> id="water">
                <label for="water"> <img src="media/images/add/water.png" alt="">Водопровод</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="gas" <?php if ($update_item['gas'] == 1)
                    echo 'checked'; ?> id="fire">
                <label for="fire"> <img src="media/images/add/fire.png" alt="">Газ</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="energy" <?php if ($update_item['energy'] == 1)
                    echo 'checked'; ?> id="energy">
                <label for="energy"> <img src="media/images/add/energy.png" alt="">Электричество</label>
            </div>
        </div>
        <input type="submit" name="update" class="btn" value="Редактировать">
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
<!-- Редактирование -->