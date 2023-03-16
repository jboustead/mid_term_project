<?php
function deletePost($db) {
    // Instantiate Author object
    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to UPDATE
    $quote->id = $data->id;

    // Delete the post
    if($quote->delete()) {
        echo json_encode(
            array('message' => 'Quote id: '.$quote->id.' has been deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote id: '.$quote->id.' has NOT been deleted')
        );
    }
}