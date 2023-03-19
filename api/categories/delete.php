<?php
function deletePost($db) {
    // Instantiate Author object
    include_once '../../models/Category.php';
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $category->id = $data->id;

    //TODO can't ever get the message of not deleted to return
    // Delete the post
    if($category->delete()) {
        echo json_encode(
            array('id' => $category->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Category id: '.$category->id.' NOT deleted')
        );
    }
}