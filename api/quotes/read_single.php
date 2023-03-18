<?php

function findSingle($quote) {

    // Get single quote
    $quote->read_single();

    if ($quote->quote == null) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    } else {
        // Create array
        $id_array = array (
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author_id,
            'category' => $quote->category_id
        );

        // Make JSON
        print_r(json_encode($id_array));
    }

}