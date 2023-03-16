<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the method request and the id if provided

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// Obtain the Database class and instantiate a new Database object

include_once '../../config/Database.php';
$database = new Database();
$db = $database->connect();

// Logic to access the right end point based on the request method

switch ($method) {
    case 'GET':
        include_once '../../models/Category.php';
        $category = new Category($db);
        if (isset($_GET['id'])) {
            $category->id = ($_GET['id']);
            include_once 'read_single.php';
            findSingle($category);
        } else {
            $result = $category->read();
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