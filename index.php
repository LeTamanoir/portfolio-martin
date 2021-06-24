<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Martin Saldinger">
    <meta name="description" content="Hello I am Martin Saldinger, a Web-Dev enthusiast.">
    <meta name="keywords" content="portfolio, martin, saldinger, martin saldinger, freelance, web-dev">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin Saldinger</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/github.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/github.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/markdown-it/12.0.4/markdown-it.min.js"></script>
    <script defer src="js/markdown.js"></script>
    <script src="js/emoji.js"></script>
    <link rel="icon" type="image/png" href="/portfolio/favicon.png">
</head>
<body>
<?php
    session_start();
    include("settings.php");
    date_default_timezone_set('Europe/Paris');
    include('views/header.php');

    switch ($_GET['page']) {
        case "":
            include('views/home.html');
            break;

        case "about":
            include('views/about.html');
            break;

        case "skills":
            include('views/skills.html');
            break;

        case "login":
            if (empty($_POST['username']) && empty($_POST['password'])) {
                include('views/login.html');
            }
            else {
                if ($_POST["username"] === $settings["username"] && md5($_POST["password"]) === $settings["password"]) {
                    $_SESSION['allow_editor_access'] = true;
                    header('Location: ?page=editor');
                } else { header('Location: ?page=login'); }
            }
            break;
        
        case "logout":
            unset($_SESSION);
            session_destroy();
            header('Location: ?page=login');
            break;
            
        case "editor":
            if ($_SESSION['allow_editor_access'] === true) {
                include('views/editor.html');
            }
            else {
                header('Location: ?page=login');
            }
            break;
        
        case "writeups":
            include('views/writeups.html');
            break;

    }

    include('views/footer.php');
?>
</body>
</html>