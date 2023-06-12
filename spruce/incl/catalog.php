<?php

$category = $database->query("SELECT * FROM `categories` ORDER BY id DESC")->fetchAll(2);
?>

<?php
if (isset($_GET['piece_category'])) {
    $sql = "SELECT * FROM `tovars` WHERE";

    if (trim($_GET['piece_category']) != "all") {
        $category_search = $_GET['piece_category'];
        $sql .= " `category`='$category_search' AND";

    } else {
        $category_search = "all";
    }

    if (trim($_GET['weaving_from']) == "") {
        $weaving_from = "0";
        $sql .= " `weaving` > $weaving_from AND";
    } elseif (strlen(trim($_GET['weaving_from'])) > 0) {
        $weaving_from = trim($_GET['weaving_from']);
        if (!is_numeric($weaving_from)) {
            $_SESSION['error'][] = "Нельзя ввести буквы в поля";
            
        } else {
            $sql .= " `weaving` > $weaving_from AND";
        }

    }
    if (trim($_GET['weaving_to']) == "") {
        $weaving_to = "999999999999";
        $sql .= " `weaving` < $weaving_to AND";
    } elseif (strlen(trim($_GET['weaving_to'])) > 0) {
        $weaving_to = trim($_GET['weaving_to']);
        if (!is_numeric($weaving_to)) {
            $_SESSION['error'][] = "Нельзя ввести буквы в поля";
            
        } else {
            $sql .= " `weaving` < $weaving_to AND";
        }

    }
    if (trim($_GET['price_from']) == "") {
        $price_from = "0";
        $sql .= " `price` > $price_from AND";
    } elseif (strlen($_GET['price_from']) > 0) {
        $price_from = trim($_GET['price_from']);
        if (!is_numeric($price_from)) {
            $_SESSION['error'][] = "Нельзя ввести буквы в поля";
            
        } else {
            $sql .= " `price` > $price_from AND ";
        }
    }
    if (trim($_GET['price_to']) == "") {
        $price_to = "999999999999";
        $sql .= " `price` < $price_to";
    } elseif (strlen($_GET['price_to']) > 0) {
        $price_to = trim($_GET['price_to']);
        if (!is_numeric($price_to)) {
            $_SESSION['error'][] = "Нельзя ввести буквы в поля";
            
        } else {
            $sql .= " `price` < $price_to";
        }
    }

    $items = $database->query($sql)->fetchAll(2);

    if (empty($items)) {
        echo '<meta http-equiv = "Refresh" content = "0 ; URL = incl/404.php">';
        exit();
    }
} elseif (isset($_GET['sort'])) {
    $sql = "SELECT * FROM `tovars` WHERE";

    if (isset($_GET['energy'])) {
        $energy = 1;
        $sql .= " `energy` = '1'";
        if (isset($_GET['water']) || isset($_GET['gas'])) {
            $sql .= " AND ";
        }
    }
    if (isset($_GET['water'])) {
        $water = 1;
        $sql .= " `water` = '1'";
        if (isset($_GET['gas'])) {
            $sql .= " AND ";
        }
    }
    if (isset($_GET['gas'])) {
        $gas = 1;
        $sql .= " `gas` = '1'";
    }
    $items = $database->query($sql)->fetchAll(2);
    if (empty($items)) {
        echo '<meta http-equiv = "Refresh" content = "0 ; URL = incl/404.php">';
        exit();
    }
} elseif (isset($_POST['all'])) {
    $items = $database->query("SELECT * FROM `tovars`")->fetchAll(2);
} else {
    $items = $database->query("SELECT * FROM `tovars`")->fetchAll(2);
}


?>
<!-- Лучшие предложения -->
<div class="container items padd100 catalog">
    <h2>Каталог</h2>
    <form action="/?page=catalog" class="filter">
        <button name="all">Все</button>
        <div class="label">
            <div class="checkbox">
                <input type="checkbox" name="energy" id="energy">
                <label for="energy"> <img src="media/images/add/energy.png" alt="">Электричество</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="water" id="water">
                <label for="water"> <img src="media/images/add/water.png" alt="">Водопровод</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="gas" id="gas">
                <label for="gas"> <img src="media/images/add/fire.png" alt="">Газ</label>
            </div>
        </div>
        <input type="submit" name="sort" class="search-btn" value="" id="search">
    </form>
    <div class="items-grid">

        <?php
        foreach ($items as $item):
            ?>
            <div class="item">
                <img src="<?= $item['image'] ?>" alt="">
                <div class="item-text">
                    <p>
                        <?php foreach ($category as $category_one): ?>
                            <?php if ($category_one['id'] == $item['category']): ?>
                                <?= $category_one['name'] . ' №' . $item['number'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </p>
                    <span>
                        <?= $item['price'] ?> ₽
                    </span>
                    <a href="?page=item&product_id=<?= $item['id'] ?>" class="btn">подробнее</a>
                </div>
            </div>

        <?php endforeach; ?>


    </div>

</div>
<!-- Лучшие предложения -->