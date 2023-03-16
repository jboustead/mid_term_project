<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Category.php';
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $category->id = $data->id;
    $category->category = $data->category;

    // Delete the post
    if($category->update()) {
        echo json_encode(
            array('message' => 'Author id: '.$category->id.', '.$category->category.' has been updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Author id: '.$category->id.', '.$category->category.' has NOT been updated')
        );
    }
}