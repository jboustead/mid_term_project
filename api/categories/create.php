<?php
function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Category.php';
    $category = new Category($db);

    // Assign json data to Author object

    $category->category = $data->category;

    // Add the category to the database

    if ($category->author != "") {
        $category->create();
        echo json_encode(
            array(
                'id' => $category->id,
                'category' => $category->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters\'s')
        );
    }
}