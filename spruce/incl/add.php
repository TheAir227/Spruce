<?php

if (isAdmin(isAuth())) {
    $category = $database->query("SELECT * FROM `categories`")->fetchAll(2);
    if (isset($_POST['add_item'])) {
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
            $userfile = "media/images/items/default.png";
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


        if (empty($number) || empty($about) || empty($price) || empty($weaving) || empty($category_add)) {
            $_SESSION['errors'][] = "Заполните все поля";
        }


        if (!is_numeric($number) || !is_numeric($price) || !is_numeric($weaving)) {
            $_SESSION['errors'][] = "Поля \"номер участка\", \"цена\" и \" количество соток\" не могут содержать буквы";
        }



        if (empty($_SESSION['errors'])) {
            $sql = "INSERT INTO `tovars`(`number`, `weaving`, `about`, `water`, `gas`, `energy`, `price`, `category`, `image`) 
            VALUES ('$number','$weaving','$about','$water','$gas','$energy','$price','$category_add','$userfile')";
            $state = $database->prepare($sql);
            $state->execute();
            echo '<div class="complete"> Товар успешно добавлен </div>';
        }
    }

} else {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}

?>

<!-- Добавление -->
<div class="container">
    <form action="" name="add_item" method="POST" class="form" enctype="multipart/form-data">
        <h2>Добавление</h2>
        <input type="text" name="number" placeholder="Номер участка">
        <input type="" name="about" placeholder="Описание">
        <input type="text" name="price" placeholder="Цена">
        <input type="text" name="weaving" placeholder="Количество соток">
        <select name="category" id="">
            <?php foreach ($category as $category_one): ?>
                <option value="<?= $category_one['id']; ?>"><?= $category_one['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="file" name="userfile">
        <div class="label">
            <div class="checkbox">
                <input type="checkbox" name="water" value="1" id="water">
                <label for="water"> <img src="media/images/add/water.png" alt="">Водопровод</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="gas" value="1" id="gas">
                <label for="gas"> <img src="media/images/add/fire.png" alt="">Газ</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="energy" value="1" id="energy">
                <label for="energy"> <img src="media/images/add/energy.png" alt="">Электричество</label>
            </div>
        </div>

        <input type="submit" name="add_item" class="btn" value="Добавить">
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
<!-- Добавление -->