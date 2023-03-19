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
                "quote" => $this->quote,
                "author_id" => $this->authur_id,
                "category_id" => $this->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'Author id: '.$quote->id.' has NOT been updated')
        );
    }
}