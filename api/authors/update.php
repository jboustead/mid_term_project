<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Author.php';
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $author->id = $data->id;
    $author->author = $data->author;

    //TODO Can't get the not update message to work for this either
    // Delete the post
    if($author->update()) {
        echo json_encode(
            array('id' => $author->id,
                'author' => $this->authur)
        );
    } else {
        echo json_encode(
            array('message' => 'Author id: '.$author->id.', '.$author->author.' has NOT been updated')
        );
    }
}