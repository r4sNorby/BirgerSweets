<?php

class connection {

    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $db_name = "BirgerSweets";
    public $conn;

    function __construct() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name);
        $this->conn->set_charset("utf8");
    }

    function __destruct() {
        mysqli_close($this->conn);
    }

    function runSql($sql) {
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }
}
