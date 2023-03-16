<?php
function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    // Assign json data to Author object

    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;
    var_dump($quote->quote);
    var_dump($quote->author_id);
    var_dump($quote->category_id);

    // Add the quote to the database

    if ($quote->create()) {
        echo json_encode(
            array(
                'message' => 'Quote Created',
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }
}