<?php

// Headers

// Get the method request and the id if provided

$method = $_SERVER['REQUEST_METHOD'];

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Obtain the Database class and instantiate a new Database object

include_once '../../config/Database.php';
$database = new Database();
$db = $database->connect();

// Logic to access the right end point based on the request method

switch ($method) {
    case 'GET':
        include_once '../../models/Author.php';
        $author = new Author($db);
        if (isset($_GET['id'])) {
            $author->id = ($_GET['id']);
            include_once 'read_single.php';
            findSingle($author);
        } else {;
            $result = $author->read();
            include_once 'read.php';
            findAll($result);
        }
        break;
    case 'POST':
        include_once 'create.php';
        createEntry($db);
        break;
    case 'PUT':
        include_once 'update.php';
        updatePost($db);
        break;
    case 'DELETE':
        include_once 'delete.php';
        deletePost($db);
        break;
}

