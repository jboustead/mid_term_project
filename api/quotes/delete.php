<?php
function deletePost($db) {
    // Instantiate Author object
    include_once '../../models/Quote.php';
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Generate potential messages
    $noQuote = array('message'=>'No Quotes Found');
    $missing = array('message'=>'Missing Required Parameters');

    if (isset($data->id) && property_exists($data, 'id') && !empty($data->id)) {

        // Set ID to UPDATE
        $quote->id = $data->id;

        if ($quote->findID() != null) {
            // Delete the post
            $quote->delete();

            // Create JSON message that quote was delete
            echo json_encode(
                array('id' => $quote->id)
            );
        } else {
//            echo json_encode(
//                array('message' => 'No Quotes Found')
//            );
            echo json_encode($noQuote);
        }
    } else {
//        echo json_encode(
//            array('message' => 'Missing Required Parameters')
//        );
        echo json_encode($missing);
    }
}