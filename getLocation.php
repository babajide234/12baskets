<?php
// include __DIR__ . "/configs.php";
include __DIR__."/configs/connection.php";
include __DIR__."/configs/functions.php";

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = sc_sec($_POST["id"]) ?? null;

    if(empty($id)) {
        $data['status'] = false;
        $data['message'] = "id cannot be empty";
    }else{
        $sql = $db->query("SELECT * FROM `pl_gps_track` WHERE `rider_id` = {$id}")or die($db->error);


        if ($sql->num_rows) {
            $data['status'] = true;
            $data['message'] = "message ";
        } 

    }
    echo json_encode($data);
}