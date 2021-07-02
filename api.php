<?php

session_start();
include("settings.php");
date_default_timezone_set('Europe/Paris');

$conn = new PDO("mysql:host={$settings['DBaddr']};dbname={$settings['DBname']}", $settings['DBuser'], $settings['DBpass']);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

if ($_SESSION['allow_editor_access'] === true) {

    if ($_GET['action'] === 'upload') {
        $request = $conn->prepare("INSERT INTO `writeups` (`title`, `banner`, `content`, `date`, `tags`, `password`) VALUES (?, ?, ?, ?, ?, ?)");
        $request->execute([$_POST['title'],$_POST['banner'],$_POST['content'],date("Y:m:d"),$_POST['tags'],$_POST['password']]);
    }
    elseif ($_GET['action'] === 'edit') {
        $request = $conn->prepare("UPDATE `writeups` SET `title`= ?,`banner`= ?,`content`= ?,`date`= ?,`password`= ?,`tags`= ? WHERE `id` = ?");
        var_dump($_POST);
        $request->execute([$_POST['title'],$_POST['banner'],$_POST['content'],date("Y:m:d"),$_POST['password'],$_POST['tags'],$_POST['id']]);
    }
    elseif ($_GET['action'] === 'delete') {
        $request = $conn->prepare("DELETE FROM `writeups` WHERE `id` = ?");
        $request->execute([$_POST['id']]);
    }
    elseif ($_GET['action'] === 'getall') {
        $request = $conn->query("SELECT * FROM `writeups` ORDER BY `id` DESC");
        $writeups = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($writeups);
    }
    elseif ($_GET['action'] === 'upload_image') {
        if (!file_exists('/var/www/WebSites/portfolio/images/' . $_POST['name'] . '.png')) {
            file_put_contents('/var/www/WebSites/portfolio/images/' . $_POST['name'] . '.png', file_get_contents($_POST['image']));
            echo '{"state":"success"}';
        }
        else {
            echo '{"state":"failed"}';
        }
    }
    elseif ($_GET['action'] === 'manage_image') {
        if (!empty($_POST['name'])) {
            unlink('/var/www/WebSites/portfolio/images/' . $_POST['name']);
            echo '{"state":"success"}';
        }
        else {
            $files = scandir('/var/www/WebSites/portfolio/images/');
            unset($files[0]);unset($files[1]);

            echo json_encode($files);
        }
    }
}

if ($_GET['action'] === 'display' && empty($_GET['id']) && empty($_GET['search'])) {
    $request = $conn->prepare("SELECT `title`,`banner`,`date`,`id`,`tags` FROM `writeups` ORDER BY `id` DESC");
    $request->execute([]);
    $writeups = $request->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($writeups);
}
elseif ($_GET['action'] === 'display' && !empty($_GET['id'])) {
    $request = $conn->prepare("SELECT * FROM `writeups` WHERE `id` = ?");
    $request->execute([$_GET['id']]);
    $writeup = $request->fetchAll(PDO::FETCH_ASSOC);
    
    if ($writeup[0]['password'] === $_GET['password'] || $writeup[0]['password'] === 'none' || $_SESSION['allow_writeup_access'] === true || in_array($writeup[0]['id'], $_SESSION['authorized_wp'])) {
        
        if (empty($_SESSION['authorized_wp'])) {
            $_SESSION['authorized_wp'] = array($writeup[0]['id']);
        }
        elseif (!in_array($writeup[0]['id'], $_SESSION['authorized_wp'])) {
            array_push($_SESSION['authorized_wp'],$writeup[0]['id']);
        }

        echo json_encode($writeup);
        
    } else {
        echo '{"state":"failed"}';
    }
}
elseif ($_GET['action'] === 'display' && !empty($_GET['search'])) {
    $request = $conn->prepare("SELECT `title`,`banner`,`date`,`id`,`tags` FROM `writeups` WHERE `title` LIKE ? OR `content` LIKE ? OR `tags` LIKE ?");
    $request->execute(["%{$_GET['search']}%","%{$_GET['search']}%","%{$_GET['search']}%"]);
    $writeups = $request->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($writeups);
}

?>