<?php

class DatabaseConnection
{
    private $connection;    
    public function __construct($hostname, $username, $password)
    {
        $this->connection = new mysqli($hostname, $username, $password);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function createDatabase($database)
    {
        $sqlCreateDatabaseQuery = "CREATE DATABASE IF NOT EXISTS $database";

        if ($this->connection->query($sqlCreateDatabaseQuery) === FALSE) {
            echo "Failed to create database: " . $this->connection->error;
        }

        $this->connection->select_db($database);
    }
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
                                     //TABLE USERS//
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
    public function createTable1()
    {
        $tableName = 'users';

        $sqlCreateTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        if ($this->connection->query($sqlCreateTableQuery) === FALSE) {
            echo "Failed to create table: " . $this->connection->error;
        }
    }
    public function insertData($username, $firstname, $lastname, $password)
    {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sqlInsertQuery = "INSERT INTO users (username, firstname, lastname, password) VALUES ('$username','$firstname','$lastname','$hashedPassword')";

        if ($this->connection->query($sqlInsertQuery) === FALSE) {
            echo "Failed to insert data: " . $this->connection->error;
        }
    }

    public function updatePassword($username, $newPassword)
    {
        $tableName = 'users';
    
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $sqlUpdateQuery = "UPDATE $tableName SET password='$hashedNewPassword' WHERE username='$username'";
    
        if ($this->connection->query($sqlUpdateQuery) === FALSE) {
            echo "Failed to update password: " . $this->connection->error;
        } else {
            echo "Password updated successfully.";
        }
    }

    public function getUserId($username)
{
    $tableName = 'users';

    $sqlQuery = "SELECT id FROM $tableName WHERE username = '$username'";

    $result = $this->connection->query($sqlQuery);

    if ($result === FALSE) {
        echo "Failed to fetch user ID: " . $this->connection->error;
        return null;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        return $userId;
    } else {
        echo "User not found.";
        return null;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
                                     //TABLE SCORE//
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

    public function createTable2()
    {
        $tableName = 'score';
    
        $sqlCreateTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
            otherTableId INT(6) UNSIGNED,
            life INT DEFAULT 6,
            flag1 BOOLEAN,
            flag2 BOOLEAN,
            flag3 BOOLEAN,
            flag4 BOOLEAN,
            flag5 BOOLEAN,
            flag6 BOOLEAN,            
            PRIMARY KEY (otherTableId),
            FOREIGN KEY (otherTableId) REFERENCES users(id)
        )";
    
        if ($this->connection->query($sqlCreateTableQuery) === FALSE) {
            echo "Failed to create table: " . $this->connection->error;
        }
    }
    public function getScoreData($userId)
{
    $tableName = 'score';

    $sqlQuery = "SELECT life, flag1, flag2, flag3, flag4, flag5, flag6 FROM $tableName WHERE otherTableId = '$userId'";

    $result = $this->connection->query($sqlQuery);

    if ($result === FALSE) {
        echo "Failed to fetch score data: " . $this->connection->error;
        return null;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
               $life = $row['life'];
        $flag1 = $row['flag1'];
        $flag2 = $row['flag2'];
        $flag3 = $row['flag3'];
        $flag4 = $row['flag4'];
        $flag5 = $row['flag5'];
        $flag6 = $row['flag6'];

        // Update your program variables with the retrieved values
        // ...

        // Return the retrieved data
        return [
            'life' => $life,
            'flag1' => $flag1,
            'flag2' => $flag2,
            'flag3' => $flag3,
            'flag4' => $flag4,
            'flag5' => $flag5,
            'flag6' => $flag6
        ];
    } else {
        echo "No score data found for user with ID $userId.";
        return null;
    }
}

public function insertScoreData($username, $life, $flag1, $flag2, $flag3, $flag4, $flag5, $flag6)
{
    $userId = $this->getUserId($username);

    if ($userId === null) {
        echo "User not found.";
        return;
    }

    // Check the conditions for each flag
    if ($flag2 && !$flag1) {
        echo "Flag 2 can only be set after Flag 1.";
        return;
    }

    if ($flag3 && !($flag1 && $flag2)) {
        echo "Flag 3 can only be set after Flag 1 and Flag 2.";
        return;
    }

    if ($flag4 && !($flag1 && $flag2 && $flag3)) {
        echo "Flag 4 can only be set after Flag 1, Flag 2, and Flag 3.";
        return;
    }

    if ($flag5 && !($flag1 && $flag2 && $flag3 && $flag4)) {
        echo "Flag 5 can only be set after Flag 1, Flag 2, Flag 3, and Flag 4.";
        return;
    }

    if ($flag6 && !($flag1 && $flag2 && $flag3 && $flag4 && $flag5)) {
        echo "Flag 6 can only be set after Flag 1, Flag 2, Flag 3, Flag 4, and Flag 5.";
        return;
    }

    // Insert the score data into the database
    $sqlInsertQuery = "INSERT INTO score (otherTableId, life, flag1, flag2, flag3, flag4, flag5, flag6) 
                       VALUES ('$userId', '$life', '$flag1', '$flag2', '$flag3', '$flag4', '$flag5', '$flag6')";

    if ($this->connection->query($sqlInsertQuery) === FALSE) {
        echo "Failed to insert data: " . $this->connection->error;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
                                     //Utility//
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
 
function selectDatabase($database){
    //Declare variables
    global $connection;
    //Attempt to connect to the database 
    $select = mysqli_select_db($connection, $database);
    if ($select === FALSE){
        $errorMessage = mysqli_connect_error();
        die("Selection of the database $database failed! <br>" . $errorMessage);
    }
}

    public function displayUserDataWithScore()
    {
        $sqlQuery = "SELECT users.id, users.username, score.life, score.flag1, score.flag2, score.flag3, score.flag4, score.flag5, score.flag6
                     FROM users
                     INNER JOIN score ON users.id = score.otherTableId";
    
        $result = $this->connection->query($sqlQuery);
    
        if ($result === FALSE) {
            echo "Failed to fetch data: " . $this->connection->error;
        } else {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
    
            $this->displayTwoDimAssocArray($data);
        }
    }

    private function displayTwoDimAssocArray($array)
    {
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Score</th><th>Life</th><th>Flag1</th><th>Flag2</th><th>Flag3</th><th>Flag4</th><th>Flag5</th><th>Flag6</th></tr>";

        foreach ($array as $item) {
            echo "<tr>";
            echo "<td>{$item['id']}</td>";
            echo "<td>{$item['username']}</td>";
            echo "<td>{$item['life']}</td>";
            echo "<td>{$item['flag1']}</td>";
            echo "<td>{$item['flag2']}</td>";
            echo "<td>{$item['flag3']}</td>";
            echo "<td>{$item['flag4']}</td>";
            echo "<td>{$item['flag5']}</td>";
            echo "<td>{$item['flag6']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}




$hostname = 'localhost';
$username = 'root';
$password = 'simex911';

$database = 'ProjectPHP';

// Create a new instance of the DatabaseConnection class
$dbConnection = new DatabaseConnection($hostname, $username, $password);

// Create the database if it doesn't exist
$dbConnection->createDatabase($database);

//insure we use this Database
$dbConnection->selectDatabase($database);

// Create Table 1 (users)
$dbConnection->createTable1();

// Create Table 2 (score)
$dbConnection->createTable2();

// Example usage
$username = 'Runbooster';
$firstname = "Simon";
$lastname = 'Guay Gozzi';
$score = 100;
$life = 3;
$flag1 = true;
$flag2 = true;
$flag3 = false;
$flag4 = false;
$flag5 = false;
$flag6 = false;

$dbConnection->insertScoreData($username, $life, $flag1, $flag2, $flag3, $flag4, $flag5, $flag6);

$dbConnection->displayUserDataWithScore();
?>
