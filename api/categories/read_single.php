<?php

function findSingle($category) {

    // Get single author
    $category->read_single();

    if($category->category == null) {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    } else {
        // Create array
        $id_array = array (
            'id' => $category->id,
            'category' => $category->category
        );

        // Make JSON
        print_r(json_encode($id_array));
    }

}