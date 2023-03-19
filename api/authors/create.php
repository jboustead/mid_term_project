<?php

function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Author.php';
    $author = new Author($db);

    if (isset($data->author) && property_exists($data, 'author') && !empty($data->author)) {
        // Assign json data to Author object
        $author->author = $data->author;

        // Add the new author to the table
        $author->create();

        // Search for the new id for the new author
        $author->id = $author->findID();

        // Create JSON response
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author)
        );
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
}