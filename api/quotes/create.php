<?php
function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Instantiate author object

    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    if (isset($data->quote) && property_exists($data, 'quote') && !empty($data->quote) &&
        isset($data->author_id) && property_exists($data, 'author_id') && !empty($data->author_id) &&
        isset($data->category_id) && property_exists($data, 'category_id') && !empty($data->category_id)) {

        // Assign json data to Author object
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
}