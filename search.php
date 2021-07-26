<?php

require_once 'connection.php';
require_once 'preparedStatments.php';

$input = filter_input(INPUT_POST, "input");
$json = filter_input(INPUT_POST, "colours");
$colours = json_decode($json);

$mysqli = new connection();

if (!empty($input) && !empty($colours)) {
    $stmt = getSweetsByContainingLetterAndColours($mysqli->conn, $input, $colours);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    }
} else if (!empty($input) && empty($colours)) {
    $stmt = getSweetsByContainingLetter($mysqli->conn, $input);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    }
} else if (!empty($colours) && empty($input)) {
    $stmt = getSweetsByColours($mysqli->conn, $colours);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    }
} else {
    $result = selectAllSweets($mysqli->conn);
}

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
    echo "</tr></table>";
}