<footer>
    made by Le_Tamanoir | &copy; all rights reserved | 
    
    <?php if (empty($_SESSION['allow_writeup_access'])) : ?>
        <a href="?page=login">login</a>
    <?php else : ?>
        <?php if ($_SESSION['allow_editor_access'] === true) : ?>
            <a href="?page=editor">editor</a> |
        <?php endif ?>
        <a href="?page=logout">logout</a>
    <?php endif ?>
</footer>