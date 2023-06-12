<?php

function generateFilename($file): string
{
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

    $filename = uniqid() . '.' . $extension;

    return $filename;
}

function uploadFile($file, $to)
{
    if ($file) {

        $filename = generateFilename($file);

        if (move_uploaded_file($file['tmp_name'], $to . DIRECTORY_SEPARATOR . $filename)) {
            return 'public' . '/' . $filename;
        }

    }

    return false;
}

function isAuth()
{
    if (isset($_SESSION['uid'])) {
        return intval($_SESSION['uid']);
    } else {
        return false;
    }
}

function isAdmin($id)
{
    if (isset($_SESSION['uid'])) {
        global $database;

        $user_id = $database->query("SELECT `role` FROM `users` WHERE `id`='$id'")->fetch(2);

        if ($user_id['role'] == '2') {
            return true;
        } else {
            return false;
        }
    }
}
?>