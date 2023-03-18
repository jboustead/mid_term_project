<?php

function findSingle($author) {

    // Get single author
    $author->read_single();

    if ($author->author == null) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    } else {
        // Create array
        $id_array = array (
            'id' => $author->id,
            'author' => $author->author
        );

        // Make JSON
        print_r(json_encode($id_array));
    }

}