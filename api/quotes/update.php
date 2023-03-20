<?php

function updatePost($db) {
    // Instantiate Author object
    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && property_exists($data, 'id') && !empty($data->id) &&
        isset($data->quote) && property_exists($data, 'quote') && !empty($data->quote) &&
        isset($data->author_id) && property_exists($data, 'author_id') && !empty($data->author_id) &&
        isset($data->category_id) && property_exists($data, 'category_id') && !empty($data->category_id)) {

        // Set ID to UPDATE
        $quote->id = $data->id;
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        // So we have all 3 properties needed, need to check to make sure the author_id and category_id are value
        $authorCheck = $quote->checkAuthor();
        $categoryCheck = $quote->checkCategory();
        $quoteCheck = $quote->checkQuote();

        if (!$authorCheck) {
            echo json_encode(
                array('message' => 'author_id Not Found')
            );
        } elseif (!$categoryCheck) {
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
        } elseif (!$quoteCheck) {
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
        else {
            // Update the Quote
            if ($quote->update()) {
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