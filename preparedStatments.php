<?php

function calculateQuestionMarks($amount) {
    $questionMarkString = "";
    for ($i = 0; $i < $amount; $i++) {
        if ($i == $amount - 1) {
            $questionMarkString .= "?";
        } else {
            $questionMarkString .= "?, ";
        }
    }
    return $questionMarkString;
}

function selectAllSweets($conn) {
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            ORDER BY sweetID";

    return $conn->query($sql);
}

function getSweetsByColours($conn, $colours) {
    $questionMarks = calculateQuestionMarks(count($colours));
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE Colour.colour IN ($questionMarks)
            ORDER BY sweetID";

    $stmt = $conn->prepare($sql);

    $dataTypes = str_repeat("s", count($colours));
    $stmt->bind_param($dataTypes, ...$colours);

    return $stmt;
}

function getSweetsByNotColour($conn, $colour) {
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE NOT Colour.colour = ?
            ORDER BY name ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $colour);

    return $stmt;
}

function getSweetsByStartingLetter($conn, $letter) {
    $letter .= "%";
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE name LIKE ?
            ORDER BY name ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $letter);

    return $stmt;
}

function getSweetsByContainingLetter($conn, $letter) {
    $letter = "%" . $letter . "%";
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE name LIKE ?
            ORDER BY sweetID ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $letter);

    return $stmt;
}

function getSweetsByContainingLetterAlphabetical($conn, $letter) {
    $letter = "%" . $letter . "%";
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE name LIKE ?
            ORDER BY name ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $letter);

    return $stmt;
}

function getSweetsByWeightLessThan($conn, $weight) {
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE weight < ?
            ORDER BY weight ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $weight);

    return $stmt;
}

function getSweetsByWeightBetween($conn, $lowWeight, $highWeight) {
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE weight BETWEEN ? AND ?
            ORDER BY name, weight ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ii", $lowWeight, $highWeight);

    return $stmt;
}

function getAmountOfHeaviestSweets($conn, $amount) {
    $sql = "SELECT sweetID, name, weight, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            ORDER BY weight DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $amount);

    return $stmt;
}

function getRandomSweets($conn, $amount) {
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            ORDER BY RAND() ASC
            LIMIT ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $amount);

    return $stmt;
}

function getSweetsByContainingLetterAndColours($conn, $letter, $colours) {
    $letter = "%" . $letter . "%";
    $questionMarks = calculateQuestionMarks(count($colours));
    $sql = "SELECT sweetID, name, Colour.colour, weight, Sourness.sourness, Strength.strength, Flavour.flavour, price 
            FROM Boiledsweet
            INNER JOIN Colour ON Boiledsweet.colourID = Colour.colourID
            INNER JOIN Sourness ON Boiledsweet.sournessID = Sourness.sournessID
            INNER JOIN Strength ON Boiledsweet.strengthID = Strength.strengthID
            INNER JOIN Flavour ON Boiledsweet.flavourID = Flavour.flavourID
            WHERE name LIKE ?
            AND Colour.colour IN ($questionMarks)
            ORDER BY sweetID ASC";

    $stmt = $conn->prepare($sql);

    $dataTypes = str_repeat("s", count($colours));
    $stmt->bind_param("s" . $dataTypes, $letter, ...$colours);

    return $stmt;
}

// ------------------------------- SQL-06 ----------------------------------- //

function getCustomersByID($conn) {
    $sql = "SELECT Customer.customerID, Customer.firstName, Customer.lastName, Address.address, Address.zipCode, ZipCity.city, PhoneNumber.phoneNumber 
            FROM Customer
            INNER JOIN CustomerHasAddress ON Customer.customerID = CustomerHasAddress.customerID
            INNER JOIN Address ON CustomerHasAddress.addressID = Address.addressID
            INNER JOIN ZipCity ON Address.zipCode = ZipCity.zipCode
            INNER JOIN CustomerHasPhoneNumber ON Customer.customerID = CustomerHasPhoneNumber.customerID
            INNER JOIN PhoneNumber ON CustomerHasPhoneNumber.phoneID = PhoneNumber.phoneID
            ORDER BY customerID ASC";

    return $conn->query($sql);
}

function getOrdersByDate($conn) {
    $sql = "SELECT CustomerOrder.orderDate, CustomerOrder.orderID, Customer.firstName, Customer.lastName
            FROM CustomerOrder
            INNER JOIN Customer ON CustomerOrder.customerID = Customer.customerID
            ORDER BY CustomerOrder.orderDate ASC";

    return $conn->query($sql);
}

function getLatestOrder($conn) {
    $sql = "SELECT CustomerOrder.orderDate, CustomerOrder.orderID, BoiledSweet.name, OrderedSweets.amount, Customer.firstName, Customer.lastName
            FROM CustomerOrder
            INNER JOIN Customer ON CustomerOrder.customerID = Customer.customerID
            INNER JOIN OrderedSweets ON CustomerOrder.orderID = OrderedSweets.orderID
            INNER JOIN BoiledSweet ON OrderedSweets.sweetID = BoiledSweet.sweetID
            WHERE CustomerOrder.orderDate = (SELECT MAX(CustomerOrder.orderDate) FROM CustomerOrder)
            ORDER BY CustomerOrder.orderDate ASC;";

    return $conn->query($sql);
}

function getOrdersByDatse($conn) {
    $sql = "SELECT CustomerOrder.orderID, BoiledSweet.name, OrderedSweets.amount, CustomerOrder.orderDate
            FROM CustomerOrder
            INNER JOIN OrderedSweets ON CustomerOrder.orderID = OrderedSweets.orderID
            INNER JOIN BoiledSweet ON OrderedSweets.sweetID = BoiledSweet.sweetID
            ORDER BY CustomerOrder.orderDate ASC";

    return $conn->query($sql);
}