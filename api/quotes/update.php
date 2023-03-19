<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Delete the post
    if($quote->update()) {
        echo json_encode(
            array('id' => $quote->id,
                "quote" => $quote->quote,
                "author_id" => $quote->author_id,
                "category_id" => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote id: '.$quote->id.' has NOT been updated')
        );
    }
}