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