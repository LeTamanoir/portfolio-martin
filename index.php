<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Martin Saldinger">
    <meta name="description" content="Hello I am Martin Saldinger, a Web-Dev enthusiast.">
    <meta name="keywords" content="portfolio, martin, saldinger, martin saldinger, freelance, web-dev">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin Saldinger</title>
    <link rel="stylesheet" href="style/style.css">
</head>

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

    <?php if (empty($_GET)) : ?>

        <main id="home">
            <div>
                <h1>
                    Hello, I am<br>
                    <span>Martin Saldinger</span><br>
                    <span>web-dev</span> and <span>pentest</span> enthusiast
                </h1>
            </div>
            <div>
                <a href="" onclick="alert('username : Le Tamanoir#1772')"><img src="svg/discord.svg" alt=""></a>
                <a href="https://github.com/LeTamanoir" target="_blank"><img src="svg/github.svg" alt=""></a>
                <a href="https://tryhackme.com/p/tamanoir" target="_blank"><img src="svg/thm.svg" alt=""></a>
                <a href="https://app.hackthebox.eu/users/341555" target="_blank"><img src="svg/htb.svg" alt=""></a>
                <a href="https://www.root-me.org/Le_Tamanoir" target="_blank"><img src="svg/rootme.svg" alt=""></a>
                <a href="mailto: martin.saldinger@gmail.com" target="_blank"><img src="svg/email.svg" alt=""></a>
            </div>
        </main>
    
    <?php elseif ($_GET['page'] === "login") : ?>
        
        <form action="?page=login" method="POST">
            <input type="text" name="username">
            <input type="password" name="password">
            <input type="submit" value="connect">

            <?php var_dump($_POST) ?>
        
        </form>

        <?php 
            if ($_POST['username'] )

        ?>
    
    <?php elseif ($_GET['page'] === "about") : ?>
    
        <main id="about">
            <div>
                <h2>About</h2>
                <p>
                    Hello, my name is Martin Saldinger.
                    I am passionate about computer sciense, more precisely web development and pentesting.                  
                </p>
                <h2>Education</h2>
                <h3><b>PREMIERE GENERALE |</b> Notre Dame Institute – St Germain en Laye</h3>
                <h4>Main Subjects :</h4>
                <ul>
                    <li>Mathematics</li>
                    <li>Physics</li>
                    <li>Computer Science</li>
                </ul>
                <h3><b>CAMBRIDGE FIRST certificate |</b> Notre Dame Institute – St Germain en Laye</h3>
                <ul>
                    <li>Grade : A</li>
                    <li>CEFR level : C1</li>
                </ul>
                <h2>Experience</h2>
                <h3><b>Internship |</b> SAP Levallois Perret</h3>
                <p>
                    From January 28 to February 1, 2019<br>
                    Discover the different departments of the company SAP, supplier of software solutions.
                </p>
                <h3>Website development</h3>
                <p>I created my own website : <a href="https://www.tamanoir.net">tamanoir.net</a></p>
            </div>
        </main>
    
    <?php elseif ($_GET['page'] === "skills") : ?>

        <script defer src="js/main.js"></script>
        <main>
            <div id="skills-container">
                <header>
                    <button id="frontend-btn" onclick="showSkill('frontend')" class="click">Frontend</button>
                    <button id="backend-btn" onclick="showSkill('backend')">Backend</button>
                </header>
                <div id="frontend" class="deploy">
                    <ul>
                        <li>
                            <img src="svg/html.svg" alt="logo html">
                            <p>I can developp any kind of showcase website that relies on an <b>HTML</b> basis.</p>
                        </li>
                        <li>
                            <img src="svg/css.svg" alt="logo css">
                            <p>I can add styling to a web-page along with effects and animations using <b>CSS</b>.</p>
                        </li>
                        <li>
                            <img src="svg/scss.svg" alt="logo scss">
                            <p>I use <b>SCSS</b> to style my web-pages more efficiently.</p>
                        </li>
                        <li>
                            <img src="svg/js.svg" alt="logo js">
                            <p>Using <b>JavaScript</b> I can make dynamic web-pages with good responsiveness and animations.</p>
                        </li>
                    </ul>
                </div>
                <div id="backend">
                    <ul>
                        <li>
                            <img src="svg/php.svg" alt="logo php">
                            <p>I can build a complete website with a <b>model-view-controller</b> (MVC).</p>
                        </li>
                        <li>
                            <img src="svg/nodejs.svg" alt="logo nodejs">
                            <p>I can developp any kind of <b>API</b> to use in a website</p>
                        </li>
                        <li>
                            <img src="svg/linux.svg" alt="logo linux">
                            <p>I have basic knowledge in linux, I can manage an <b>apache</b> server along with a <b>mysql</b> server</p>
                        </li>
                    </ul>
                </div>
            </div>
        </main>

    <?php elseif ($_GET['page'] === "writeups") : ?>

        <main id="writeups">
            coming soon
        </main>

    <?php endif ?>
    
    <footer>
        made by Le_Tamanoir | &copy; all rights reserved
    </footer>
<body>
</body>
</html>