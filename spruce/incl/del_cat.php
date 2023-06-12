<?php 
if(isAdmin(isAuth())){
    $sql = "DELETE FROM `categories` WHERE `id`=" . $_GET['id'];
    $state = $database->prepare($sql);
    $state->execute();
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = http://spruce/?page=admin">';
    exit();
}
else{
    echo '<meta http-equiv = "Refresh" content = "0 ; URL = /">';
    exit();
}


?>