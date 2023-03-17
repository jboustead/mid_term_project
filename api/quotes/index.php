<?php

// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the method request and the id if provided

$method = $_SERVER['REQUEST_METHOD'];
$quoteId = ($_GET['id']);
$authorId = ($_GET['authorId']);
$categoryId = ($_GET['categoryId']);

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
        include_once '../../models/Quote.php';
        $quote = new Quote($db);
        if ($quoteId!= null) {
            $quote->id = $quoteId;
            include_once 'read_single.php';
            findSingle($quote);
        } elseif ($authorId != null && $categoryId == null) {
            $quote->author_id = $authorId;
            include_once 'read.php';
            findAll($quote);
        } elseif ($authorId == null && $categoryId != null) {
            $quote->category_id = $categoryId;
            include_once 'read.php';
            findAll($quote);
        } elseif ($authorId != null && $categoryId != null) {
            $quote->author_id = $authorId;
            $quote->category_id = $categoryId;
            include_once 'read.php';
            findAll($quote);
        } else {
            include_once 'read.php';
            findAll($quote);
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