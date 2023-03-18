<?php

function findAll($result) {
    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0) {
        // Quotes array
        $category_arr = array();
        //$category_arr['data'] = array();

        // Loop through the quotes
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category,
            );

            // Push to the 'data'
            array_push($category_arr, $category_item);
        }

        // Turn to JSON output
        echo json_encode($category_arr);

    } else {
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }
}

