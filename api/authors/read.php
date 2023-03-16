<?php

function findAll($result) {
    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0) {
        // Quotes array
        $author_arr = array();
        $author_arr['data'] = array();

        // Loop through the quotes
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author,
            );

            // Push to the 'data'
            array_push($author_arr['data'], $author_item);
        }

        // Turn to JSON output
        echo json_encode($author_arr);

    } else {
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }
}
