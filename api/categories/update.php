<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Category.php';
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && property_exists($data, 'id') && !empty($data->id) &&
        isset($data->category) && property_exists($data, 'category') && !empty($data->category)) {

        // Set ID to UPDATE
        $category->id = $data->id;
        $category->category = $data->category;

        // Update the post
        echo json_encode(
            array('id' => $category->id,
                "category" => $category->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
}