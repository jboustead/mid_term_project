<?php
function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Category.php';
    $category = new Category($db);

    if (isset($data->category) && property_exists($data, 'category') && !empty($data->category)) {
        // Assign json data to category object
        $category->category = $data->category;

        // Update the category
        $category->create();

        // Search for the new id for the new author
        $category->id = $category->findID();

        // Create JSON response message
        echo json_encode(
            array(
                'id' => $category->id,
                'author' => $category->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
}