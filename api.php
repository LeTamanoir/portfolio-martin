<?php

session_start();
include("settings.php");
date_default_timezone_set('Europe/Paris');

$conn = new PDO("mysql:host={$settings['DBaddr']};dbname={$settings['DBname']}", $settings['DBuser'], $settings['DBpass']);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

if ($_SESSION['allow_editor_access'] === true) {

    if ($_GET['action'] === 'upload') {
        $request = $conn->prepare("INSERT INTO `writeups` (`title`, `banner`, `content`, `date`) VALUES (?, ?, ?, ?)");
        $request->execute([$_POST['title'],$_POST['banner'],$_POST['content'],date("Y:m:d H:i:s")]);
    }
    elseif ($_GET['action'] === 'edit') {
        $request = $conn->prepare("UPDATE `writeups` SET `title`= ?,`banner`= ?,`content`= ?,`date`= ? WHERE `id` = ?");
        $request->execute([$_POST['title'],$_POST['banner'],$_POST['content'],date("Y:m:d H:i:s"),$_GET['id']]);
    }
    elseif ($_GET['action'] === 'delete') {
        $request = $conn->prepare("DELETE FROM `writeups` WHERE `id` = ?");
        $request->execute([$_GET['id']]);
    }

}

if ($_GET['action'] === 'display' && !empty($_GET['top'])) {
    $request = $conn->prepare("SELECT * FROM `writeups` ORDER BY `id` DESC LIMIT ?");
    $request->execute([$_GET['top']]);
    $writeups = $request->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($writeups);
}
elseif ($_GET['action'] === 'display' && !empty($_GET['id'])) {
    $request = $conn->prepare("SELECT * FROM `writeups` WHERE `id` = ?");
    $request->execute([$_GET['id']]);
    $writeup = $request->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($writeup);
}
elseif ($_GET['action'] === 'display' && !empty($_GET['search'])) {
    $request = $conn->prepare("SELECT * FROM `writeups` WHERE `title` LIKE ? OR `content` LIKE ?");
    $request->execute(["%{$_GET['search']}%","%{$_GET['search']}%"]);
    $writeups = $request->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($writeups);
}
elseif ($_GET['action'] === 'display') {
    $request = $conn->query("SELECT * FROM `writeups` ORDER BY `id` DESC");
    $writeups = $request->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($writeups);
}

?>