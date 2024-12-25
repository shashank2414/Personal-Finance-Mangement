<?php
error_reporting(0);
// Globals
global  $DB_LINK, $PDO_LINK;
const LOCAL_HOST = 'localhost';
const REMOTE_USERNAME = 'root';
const REMOTE_PASSWORD = '';
const DATABASE = 'u144885197_jhd';

//const REMOTE_USERNAME = 'root';
//const REMOTE_PASSWORD = '';

 

// Database credentials
$host = "localhost";
$username = REMOTE_USERNAME;
$password = "";

// Function to create MySQLi connection
function createMysqliConnection($host, $username, $password, $db)
{
    $mysqli = new mysqli($host, $username, $password, $db);
    if ($mysqli->connect_error) {
        die("Server Busy kindly wait.. (MySQLi Error): " . $mysqli->connect_error);
    }
    return $mysqli;
}

// Function to create PDO connection
function createPdoConnection($host, $username, $password, $db)
{
    try {
        $dsn = "mysql:host=$host;dbname=$db";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Server Busy kindly wait.. (PDO Error): " . $e->getMessage());
    }
}

// Create connections
$DB_LINK = createMysqliConnection($host, $username, $password, DATABASE);
$PDO_LINK = createPdoConnection($host, $username, $password, DATABASE);
