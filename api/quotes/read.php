<?php

function findAll($quote) {

    include_once '../../models/Quote.php';

    if ($quote->author_id == null && $quote->category_id == null) {
        $result = $quote->read();
    } else {
        $result = $quote->read_category();
    }

    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0) {
        // Quotes array
        $quote_arr = array();
        //$quote_arr['data'] = array();

        // Loop through the quotes
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            // Push to the 'data'
            //array_push($quote_arr['data'], $quote_item);
            array_push($quote_arr, $quote_item);
        }

        // Turn to JSON output
        echo json_encode($quote_arr);

    } else {
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }
}