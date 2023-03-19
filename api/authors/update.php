<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Author.php';
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $author->id = $data->id;
    $author->category = $data->author;

    // Delete the post
    if($author->update()) {
        echo json_encode(
            array('id' => $author->id,
                "author" => $author->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Author id: '.$category->id.', '.$category->category.' has NOT been updated')
        );
    }
}