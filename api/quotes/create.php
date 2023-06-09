<?php
function createEntry($db) {

    // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    // Return messages
    $noAuthor = array(
        'message' => 'author_id Not Found'
    );

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

        // So we have all 3 properties needed, need to check to make sure the author_id and category_id are value
        $authorCheck = $quote->checkAuthor();
        $categoryCheck = $quote->checkCategory();

        if (!$authorCheck) {
//            echo json_encode(
//                array('message' => 'author_id Not Found')
//            );
            echo json_encode($noAuthor);
        } elseif (!$categoryCheck) {
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
        } else {
            // Create the Quote
            if ($quote->create()) {
                // Find the ID of the newly create quote
                $quote->id = $quote->findQuoteID();
                echo json_encode(
                    array(
                        'id' => $quote->id,
                        'quote' => $quote->quote,
                        'author_id' => $quote->author_id,
                        'category_id' => $quote->category_id)
                );
            }
        }
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
}