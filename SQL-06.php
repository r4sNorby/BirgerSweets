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
        echo "<h1>SQL-06</h1>";
        
        $mysqli = new connection();

        $result = getCustomersByID($mysqli->conn);

        echo "<h2>Alle kunder sorteret efter ID</h2>";

        echo "<h3>SELECT Customer.customerID, firstName, lastName, Address.address, Address.zipCode, ZipCity.city, PhoneNumber.phoneNumber 
            FROM Customer
            INNER JOIN CustomerHasAddress ON Customer.customerID = CustomerHasAddress.customerID
            INNER JOIN Address ON CustomerHasAddress.addressID = Address.addressID
            INNER JOIN ZipCity ON Address.zipCode = ZipCity.zipCode
            INNER JOIN CustomerHasPhoneNumber ON Customer.customerID = CustomerHasPhoneNumber.customerID
            INNER JOIN PhoneNumber ON CustomerHasPhoneNumber.phoneID = PhoneNumber.phoneID
            ORDER BY customerID ASC</h3>";

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                    <th>Adresse</th>
                    <th>Postnummer</th>
                    <th>Telefonnummer</th>
                </tr>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['customerID'] . "</td>
                    <td>" . $row['firstName'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['zipCode'] . "</td>
                    <td>" . $row['city'] . "</td>
                    <td>" . $row['phoneNumber'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>