<?php
function deletePost($db) {
    // Instantiate Author object
    include_once '../../models/Author.php';
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $author->id = $data->id;

    //TODO can't seem to get it to return false to this so the failed message never gets printed
    // Delete the post
    if($author->delete()) {
        echo json_encode(
            array('id' => $author->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Author id: '.$author->id.' has NOT been deleted')
        );
    }
}