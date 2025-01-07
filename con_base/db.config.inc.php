<?php
//error_reporting(0);
// Globals
global  $DB_LINK, $PDO_LINK; 

// Database credentials for live server
 
const DATABASE = 'u144885197_web_db';
const REMOTE_USERNAME = 'u144885197_web_user';
const REMOTE_PASSWORD = '@I5yaZ7#90j';  
$host = "localhost";
$username = REMOTE_USERNAME;
$password = REMOTE_PASSWORD;
$db = DATABASE;


// Database credentials for localhost server
// $host = "localhost";
// $username = "root";
// $password = "";
// const DATABASE = 'finance_advisor';
// $db = DATABASE;

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
