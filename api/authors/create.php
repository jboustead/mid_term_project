<?php

function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Author.php';
    $author = new Author($db);

    // Assign json data to Author object

    $author->author = $data->author;

    // Add the author to the database

    //TODO go back and figure out why I'm not getting the author id in the message of Post created
    if ($author->create()) {
        echo json_encode(
            array(
                'message' => 'Author Created',
                'id' => $author->id,
                'author' => $author->author)
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Created')
        );
    }
}