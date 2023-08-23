<?php
session_start();

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

// instantiate user object
$admUser = new User($db);

$stmt = $admUser->listUsers();
$num = $stmt->rowCount();

if ($num > 0) {

    $users_arr = array();
    $users_arr['records'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // extract row
        // this will make $row['name'] to
        // just $name only

        $user_item = array(
            "id_user" => $id_user,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "role" => $role,


        );

        array_push($users_arr["records"], $user_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data
    echo json_encode($users_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
}
