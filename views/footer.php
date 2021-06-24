<footer>
    made by Le_Tamanoir | &copy; all rights reserved | 
    
    <?php if (empty($_SESSION['allow_editor_access'])) : ?>
        <a href="?page=login">login</a>
    <?php else : ?>
        <a href="?page=editor">editor</a> |
        <a href="?page=logout">logout</a>
    <?php endif ?>
</footer>