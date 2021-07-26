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

        $customerByIDResult = getCustomersByID($mysqli->conn);

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
        if ($customerByIDResult->num_rows > 0) {
            while ($row = $customerByIDResult->fetch_assoc()) {
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

        //--------------------------------------------------------------------//
        echo "<hr>";
        
        $ordersByDateResult = getOrdersByDate($mysqli->conn);

        echo "<h2>Alle ordrer sorteret efter dato</h2>";

        echo "<h3>SELECT CustomerOrder.orderDate, CustomerOrder.orderID, Customer.firstName, Customer.lastName
            FROM CustomerOrder
            INNER JOIN Customer ON CustomerOrder.customerID = Customer.customerID
            ORDER BY CustomerOrder.orderDate ASC</h3>";

        echo "<table>
                <tr>
                    <th>Dato</th>
                    <th>Ordre ID</th>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                </tr>";
        if ($ordersByDateResult->num_rows > 0) {
            while ($row = $ordersByDateResult->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['orderDate'] . "</td>
                    <td>" . $row['orderID'] . "</td>
                    <td>" . $row['firstName'] . "</td>
                    <td>" . $row['lastName'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }

        //--------------------------------------------------------------------//
        echo "<hr>";
        
        $latestOrderResult = getLatestOrder($mysqli->conn);

        echo "<h2>Den seneste ordre</h2>";

        echo "<h3>SELECT CustomerOrder.orderDate, CustomerOrder.orderID, BoiledSweet.name, OrderedSweets.amount, Customer.firstName, Customer.lastName
            FROM CustomerOrder
            INNER JOIN Customer ON CustomerOrder.customerID = Customer.customerID
            INNER JOIN OrderedSweets ON CustomerOrder.orderID = OrderedSweets.orderID
            INNER JOIN BoiledSweet ON OrderedSweets.sweetID = BoiledSweet.sweetID
            WHERE CustomerOrder.orderDate = (SELECT MAX(CustomerOrder.orderDate) FROM CustomerOrder)
            ORDER BY CustomerOrder.orderDate ASC;</h3>";

        echo "<table>
                <tr>
                    <th>Dato</th>
                    <th>Ordre ID</th>
                    <th>Bolche Navn</th>
                    <th>Mængde</th>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                </tr>";
        if ($latestOrderResult->num_rows > 0) {
            while ($row = $latestOrderResult->fetch_assoc()) {
                echo "
                    <tr>
                    <td>" . $row['orderDate'] . "</td>
                    <td>" . $row['orderID'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['amount'] . "</td>
                    <td>" . $row['firstName'] . "</td>
                    <td>" . $row['lastName'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }
        
        ?>
    </body>
</html>