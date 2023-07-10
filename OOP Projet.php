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

    public function createTable($tableName)
    {
        $sqlCreateTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        if ($this->connection->query($sqlCreateTableQuery) === FALSE) {
            echo "Failed to create table: " . $this->connection->error;
        }
    }

    public function insertData($tableName, $username, $password)
    {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sqlInsertQuery = "INSERT INTO $tableName (username, password) VALUES ('$username', '$hashedPassword')";

        if ($this->connection->query($sqlInsertQuery) === FALSE) {
            echo "Failed to insert data: " . $this->connection->error;
        }
    }

    public function updatePassword($tableName, $username, $newPassword)
    {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sqlUpdateQuery = "UPDATE $tableName SET password='$hashedNewPassword' WHERE username='$username'";

        if ($this->connection->query($sqlUpdateQuery) === FALSE) {
            echo "Failed to update password: " . $this->connection->error;
        } else {
            echo "Password updated successfully.";
        }
    }
}

$hostname = 'localhost';
$username = 'root';
$password = 'simex911';

$databaseConnection = new DatabaseConnection($hostname, $username, $password);

$database = 'users';
$databaseConnection->createDatabase($database);

$tableName = 'accounts';
$databaseConnection->createTable($tableName);

$newUsername = 'john_doe';
$newPassword = 'secretpassword';
$databaseConnection->insertData($tableName, $newUsername, $newPassword);

$existingUsername = 'john_doe';
$newPassword = 'newpassword';
$databaseConnection->updatePassword($tableName, $existingUsername, $newPassword);

?>
