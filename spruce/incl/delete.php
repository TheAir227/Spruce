<?php

if (isAdmin(isAuth())) {
    if (isset($_GET['product_id'])) {
        if (isset($_POST['delete'])) {
            $product_id = $_GET['product_id'];
            $state = $database->prepare("DELETE FROM `tovars` WHERE `id`='$product_id'");
            $state->execute();
            echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
            exit();
        }
    }
} else {
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}
?>

<!-- Удаление -->
<div class="container del">
    <form action="" method="POST" class="form">
        <h2>Удаление</h2>
        <p>Участок № 123</p>
        <div class="checkbox">
            <input type="checkbox" id="delete" required>
            <label for="delete"> Подтверждение удаления</label>
        </div>
        <input type="submit" name="delete" class="btn" value="Удалить">
    </form>
</div>
<!-- Удаление -->