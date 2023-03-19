<?php

function updatePost($db)
{
    // Instantiate Author object
    include_once '../../models/Author.php';
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && property_exists($data, 'id') && !empty($data->id) &&
        isset($data->author) && property_exists($data, 'author') && !empty($data->author)) {

        // Set ID to UPDATE
        $author->id = $data->id;
        $author->author = $data->author;

        // Update the post
        echo json_encode(
            array('id' => $author->id,
                "author" => $author->author)
        );
        } else {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        }
}