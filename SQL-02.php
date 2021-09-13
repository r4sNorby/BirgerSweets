<!DOCTYPE html>
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
        echo "<h1>SQL-02</h1>";
        
        $mysqli = new connection();

        $result = selectAllSweets($mysqli->conn);

        echo "<h2>Alle bolcher</h2>";

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
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $colourStmt = getSweetsByColours($mysqli->conn, ["Rød"]);

        echo "<h2>Røde bolcher</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            WHERE Colour.colour IN ('Rød')
            ORDER BY sweetID</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($colourStmt->execute()) {
            $result = $colourStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $twoColourStmt = getSweetsByColours($mysqli->conn, ["Rød", "Blå"]);

        echo "<h2>Røde og blå bolcher</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            WHERE Colour.colour IN ('Rød', 'Blå')
            ORDER BY sweetID</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($twoColourStmt->execute()) {
            $result = $twoColourStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $colourNotStmt = getSweetsByNotColour($mysqli->conn, "Rød");

        echo "<h2>Alle andre end Røde bolcher, alfabetisk</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            WHERE NOT Colour.colour = 'Rød'
            ORDER BY name ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($colourNotStmt->execute()) {
            $result = $colourNotStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $startingLetterStmt = getSweetsByStartingLetter($mysqli->conn, "B");

        echo "<h2>Bolcher der starter med B</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            WHERE name LIKE 'B%'
            ORDER BY name ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($startingLetterStmt->execute()) {
            $result = $startingLetterStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $containingLetterStmt = getSweetsByContainingLetterAlphabetical($mysqli->conn, "e");

        echo "<h2>Mindst ét \"e\" i navnet på bolchet</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            WHERE name LIKE '%e%'
            ORDER BY name ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($containingLetterStmt->execute()) {
            $result = $containingLetterStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $weightByLessThanStmt = getSweetsByWeightLessThan($mysqli->conn, 10);

        echo "<h2>Bolcher mindre end 10g sorteret efter vægt, stigende</h2>";

        echo "<h3>SELECT sweetID, name, weight
            FROM Boiledsweet
            WHERE weight < 10
            ORDER BY weight ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($weightByLessThanStmt->execute()) {
            $result = $weightByLessThanStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $weightBetweenStmt = getSweetsByWeightBetween($mysqli->conn, 10, 12);

        echo "<h2>Bolcher mellem 10g og 12g, alfabetisk, derefter vægt</h2>";

        echo "<h3>SELECT sweetID, name
            FROM Boiledsweet
            WHERE weight BETWEEN 10 AND 12
            ORDER BY name, weight ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($weightBetweenStmt->execute()) {
            $result = $weightBetweenStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $heaviestSweetsStmt = getAmountOfHeaviestSweets($mysqli->conn, 3);

        echo "<h2>De tre tungeste bolcher</h2>";

        echo "<h3>SELECT sweetID, name, weight
            FROM Boiledsweet
            ORDER BY weight DESC
            LIMIT 3</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($heaviestSweetsStmt->execute()) {
            $result = $heaviestSweetsStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";

        $randomStmt = getRandomSweets($mysqli->conn, 1);

        echo "<h2>Tilfældigt bolche</h2>";

        echo "<h3>SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            ORDER BY RAND() ASC
            LIMIT 1</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Navn</th>
                    <th>Farve</th>
                    <th>Vægt</th>
                    <th>Surhed</th>
                    <th>Smags-styrke</th>
                    <th>Smags-type</th>
                    <th>Råvarepris (Øre)</th>
                </tr>";
        if ($randomStmt->execute()) {
            $result = $randomStmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['sweetID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['colour'] . "</td>
                    <td>" . $row['weight'] . "</td>
                    <td>" . $row['sourness'] . "</td>
                    <td>" . $row['strength'] . "</td>
                    <td>" . $row['flavour'] . "</td>
                    <td>" . $row['price'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>