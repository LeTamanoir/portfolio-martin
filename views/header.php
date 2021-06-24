<header>
    <h2>
        <a href="index.php">
            &lt;h1&gt;<span>Le_Tamanoir</span>&lt;/h1&gt;
        </a>
    </h2>
    <nav>
        <ul>
            <li><a class="<?php if ($_GET['page'] === "about") { echo 'active'; } ?>" href="?page=about">/About</a></li>
            <li><a class="<?php if ($_GET['page'] === "writeups") { echo 'active'; } ?>" href="?page=writeups">/Writeups</a></li>
            <li><a class="<?php if ($_GET['page'] === "skills") { echo 'active'; } ?>" href="?page=skills">/Skills</a></li>
            <li><a href="https://www.tamanoir.net/projects/index.html">/Projects</a></li>
        </ul>
    </nav>
</header>