<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Birger Bolcher - DB H3</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        require_once 'header.php';
        ?>
        <main>
            <?php
            echo "<h1>SQL-03</h1>";
            ?>
            <a id="showAll" class="button">Vis Bolcher</a>
            <div id="container">
                <div id="inputs">
                    <input id="searchBar" type="text">
                    <input id="Rød" class="colours" value="Rød" type="checkbox"><label for="Rød">Rød</label>
                    <input id="Orange" class="colours" value="Orange" type="checkbox"><label for="Orange">Orange</label>
                    <input id="Gul" class="colours" value="Gul" type="checkbox"><label for="Gul">Gul</label>
                    <input id="Sort" class="colours" value="Sort" type="checkbox"><label for="Sort">Sort</label>
                    <input id="Lyseblå" class="colours" value="Lyseblå" type="checkbox"><label for="Lyseblå">Lyseblå</label>
                    <input id="Blå" class="colours" value="Blå" type="checkbox"><label for="Blå">Blå</label>
                </div>
                <div id="sweetList">

                </div>
            </div>
        </main>
        <script src="functions.js"></script>
    </body>
</html>