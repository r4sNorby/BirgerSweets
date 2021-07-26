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
    </head>
    <body>
        <?php
        require_once 'header.php';
        require_once 'connection.php';
        require_once 'preparedStatments.php';
        
        $mysqli = new connection();

        $result = selectAllSweets($mysqli->conn);
        
        echo "<h1>SQL-04</h1>";

        echo "<h2>Samlet prisliste over alle bolcher</h2>";
        
        echo "<h3>SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            ORDER BY sweetID</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Vægt</th>
                    <th>Råvarepris (Øre)</th>
                    <th>Nettopris (Øre)</th>
                    <th>Salgspris (Øre)</th>
                    <th>Salgspris pr 100g (Øre)</th>
                </tr>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $netPrice = $row['price'] + ($row['price'] / 100 * 250);
                $sellingPrice = $netPrice + ($netPrice / 100 * 25);
                
                $netPrice100 = $netPrice / $row['weight'] * 100;
                $sellingPrice100 = $netPrice100 + ($netPrice100 / 100 * 25);
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['price'] . "</td>
                    <td>" . round($netPrice) . "</td>
                    <td>" . round($sellingPrice) . "</td>
                    <td>" . round($sellingPrice100) . "</td>
                    </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>